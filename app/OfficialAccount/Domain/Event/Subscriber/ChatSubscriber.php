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
use App\OfficialAccount\Interfaces\Rpc\Client\MallCenter\OfficialAccountsRpc;
use Swoft\Process\Process;
use Swoft\Process\UserProcess;
use Swoft\Redis\Redis;

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
        $subscriber = function (\Redis $redis, string $chan, string $msg) {
            if ($chan === SubscriberEnum::REDIS_PUBLISH_WECHAT_CHAT_CHANNEL) {
                $message = json_decode($msg, true, 512, JSON_THROW_ON_ERROR);

                // EasyWeChat Application
                $app = $this->officialAccountsRpc->officialAccountApplication($message['p']);

                // Send message to tencent
                switch ($message['msgType']) {
                    case WebSocketMessage::TEXT_MESSAGE:
                        $this->chatSendToTencentDomain->textMessage($app, $message);
                        break;
                    case WebSocketMessage::IMAGE_MESSAGE:
                        $this->chatSendToTencentDomain->imageMessage($app, $message);
                        break;
                    case WebSocketMessage::VIDEO_MESSAGE:
                        $this->chatSendToTencentDomain->videoMessage($app, $message);
                        break;
                    case WebSocketMessage::VOICE_MESSAGE:
                        $this->chatSendToTencentDomain->voiceMessage($app, $message);
                        break;
                    case WebSocketMessage::NEWS_ITEM_MESSAGE:
                        $this->chatSendToTencentDomain->newsItemMessage($app, $message);
                        break;
                    default:
                        break;
                }
            }
        };

        Redis::subscribe([SubscriberEnum::REDIS_PUBLISH_WECHAT_CHAT_CHANNEL], $subscriber);
    }
}