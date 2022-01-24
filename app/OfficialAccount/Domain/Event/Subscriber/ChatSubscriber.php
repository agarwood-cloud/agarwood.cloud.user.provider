<?php declare(strict_types=1);
/**
 * This file is part of Agarwood Cloud.
 *
 * @link     https://www.agarwood-cloud.com
 * @document https://www.agarwood-cloud.com/docs
 * @contact  676786620@qq.com
 * @author   agarwood
 */

namespace App\OfficialAccount\Domain\Event\Subscriber;

use App\OfficialAccount\Domain\Aggregate\Enum\SubscriberEnum;
use App\OfficialAccount\Domain\Aggregate\Enum\WebSocketMessage;
use App\OfficialAccount\Domain\Aggregate\Repository\ChatMessageRecordMongoCommandRepository;
use App\OfficialAccount\Domain\ChatSendToTencentDomain;
use App\OfficialAccount\Interfaces\Assembler\ChatAssembler;
use App\OfficialAccount\Interfaces\Rpc\Client\MallCenter\OfficialAccountsRpc;
use GuzzleHttp\DefaultHandler;
use Swoft\Log\Helper\CLog;
use Swoft\Process\Process;
use Swoft\Process\UserProcess;
use Swoft\Redis\Redis;
use Swoole\Timer;
use Throwable;
use Yurun\Util\Swoole\Guzzle\SwooleHandler;

/**
 * @\Swoft\Process\Annotation\Mapping\Process()
 */
class ChatSubscriber extends UserProcess
{
    /**
     * @\Swoft\Bean\Annotation\Mapping\Inject()
     *
     * @var \App\OfficialAccount\Interfaces\Rpc\Client\MallCenter\OfficialAccountsRpc
     */
    public OfficialAccountsRpc $officialAccountsRpc;

    /**
     * @\Swoft\Bean\Annotation\Mapping\Inject()
     *
     * @var \App\OfficialAccount\Domain\ChatSendToTencentDomain
     */
    public ChatSendToTencentDomain $chatSendToTencentDomain;

    /**
     * @\Swoft\Bean\Annotation\Mapping\Inject()
     *
     * @var \App\OfficialAccount\Domain\Aggregate\Repository\ChatMessageRecordMongoCommandRepository
     */
    public ChatMessageRecordMongoCommandRepository $chatMessageRecordMongoCommandRepository;

    /**
     * Run
     *
     * @param \Swoft\Process\Process $process
     */
    public function run(Process $process): void
    {
        // Guzzle 支持协程
        DefaultHandler::setDefaultHandler(SwooleHandler::class);

        // Don't delete this line, init: set socket timeout
        Timer::after(1000, static function () {
            Redis::publish(SubscriberEnum::REDIS_PUBLISH_WECHAT_CHAT_CHANNEL, 'hello world!');
        });
        // set socket timeout -1
        ini_set('default_socket_timeout', '-1');
        // always true
        while (true) {
            $subscriber = function (\Redis $redis, string $chan, string $msg) {
                // set socket timeout
                $redis->setOption(\Redis::OPT_READ_TIMEOUT, -1);
                if ($chan === SubscriberEnum::REDIS_PUBLISH_WECHAT_CHAT_CHANNEL) {
                    try {
                        $message = json_decode($msg, true, 512, JSON_THROW_ON_ERROR);
                    } catch (Throwable $e) {
                        CLog::error('Failed to parse message: %s', $e->getMessage());
                        return;
                    }

                    // EasyWeChat Application
                    if (isset($message['officialAccountId'])) {
                        try {
                            $app = $this->officialAccountsRpc->officialAccountApplication((int)$message['officialAccountId']);
                        } catch (Throwable $e) {
                            CLog::error('Failed to get official account application: %s', $e->getMessage());
                            return;
                        }

                        // Send message to tencent
                        switch ($message['msgType']) {
                            case WebSocketMessage::TEXT_MESSAGE:
                                $DTO = ChatAssembler::attributesToTextMessageDTO($message);
                                try {
                                    $this->chatSendToTencentDomain->textMessage($app, $DTO);
                                } catch (Throwable $e) {
                                    CLog::error('Failed to send text message to tencent: %s', $e->getMessage());
                                    return;
                                }
                                // record message
                                $this->chatMessageRecordMongoCommandRepository->insertOneMessage(
                                    $DTO->getToUserName(),
                                    (int)$DTO->getFromUserId(),
                                    'customer',
                                    WebSocketMessage::TEXT_MESSAGE,
                                    ['content' => $DTO->getContent()],
                                    false
                                );
                                break;
                            case WebSocketMessage::IMAGE_MESSAGE:
                                $DTO = ChatAssembler::attributesToImageMessageDTO($message);
                                $this->chatSendToTencentDomain->imageMessage($app, $DTO);
                                break;
                            case WebSocketMessage::VIDEO_MESSAGE:
                                $DTO = ChatAssembler::attributesToVideoMessageDTO($message);
                                $this->chatSendToTencentDomain->videoMessage($app, $DTO);
                                break;
                            case WebSocketMessage::VOICE_MESSAGE:
                                $DTO = ChatAssembler::attributesToVoiceMessageDTO($message);
                                $this->chatSendToTencentDomain->voiceMessage($app, $DTO);
                                break;
                            case WebSocketMessage::NEWS_ITEM_MESSAGE:
                                $DTO = ChatAssembler::attributesToNewsItemMessageDTO($message);
                                $this->chatSendToTencentDomain->newsItemMessage($app, $DTO);
                                break;
                            default:
                                break;
                        }
                    }
                }
            };

            /** @var string $subscriber \Closure */
            Redis::subscribe([SubscriberEnum::REDIS_PUBLISH_WECHAT_CHAT_CHANNEL], $subscriber);
        }
    }
}
