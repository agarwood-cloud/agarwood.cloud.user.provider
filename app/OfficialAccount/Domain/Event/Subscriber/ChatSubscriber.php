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
use App\OfficialAccount\Domain\ChatSendToTencentDomain;
use App\OfficialAccount\Interfaces\Assembler\ChatAssembler;
use App\OfficialAccount\Interfaces\Rpc\Client\MallCenter\OfficialAccountsRpc;
use Swoft\Process\Process;
use Swoft\Process\UserProcess;
use Swoft\Redis\Redis;
use Swoole\Timer;

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
     * Run
     *
     * @param \Swoft\Process\Process $process
     */
    public function run(Process $process): void
    {
        // Don't delete this line, init: set socket timeout
        Timer::after(2000, static function () {
            Redis::publish(SubscriberEnum::REDIS_PUBLISH_WECHAT_CHAT_CHANNEL, 'hello world!');
        });
        while (true) {
            $subscriber = function (\Redis $redis, string $chan, string $msg) {
                // set socket timeout
                $redis->setOption(\Redis::OPT_READ_TIMEOUT, -1);
                if ($chan === SubscriberEnum::REDIS_PUBLISH_WECHAT_CHAT_CHANNEL) {
                    $message = json_decode($msg, true, 512, JSON_THROW_ON_ERROR);

                    // EasyWeChat Application
                    if (isset($message['officialAccountId'])) {
                        $app = $this->officialAccountsRpc->officialAccountApplication($message['officialAccountId']);

                        // Send message to tencent
                        switch ($message['msgType']) {
                            case WebSocketMessage::TEXT_MESSAGE:
                                $DTO = ChatAssembler::attributesToTextMessageDTO($message);
                                $this->chatSendToTencentDomain->textMessage($app, $DTO);
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
