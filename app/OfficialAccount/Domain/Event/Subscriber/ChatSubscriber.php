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
use App\OfficialAccount\Domain\ChatSendToCustomerDomain;
use App\OfficialAccount\Domain\ChatSendToTencentDomain;
use App\OfficialAccount\Interfaces\Assembler\ChatAssembler;
use App\OfficialAccount\Interfaces\Rpc\Client\MallCenter\OfficialAccountsRpc;
use EasyWeChat\OfficialAccount\Application;
use Swoft\Log\Helper\CLog;
use Swoft\Process\Process;
use Swoft\Process\UserProcess;
use Swoft\Redis\Redis;
use Swoole\Timer;
use Throwable;

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
     * @\Swoft\Bean\Annotation\Mapping\Inject()
     *
     * @var \App\OfficialAccount\Domain\ChatSendToCustomerDomain
     */
    public ChatSendToCustomerDomain $chatSendToCustomerDomain;

    /**
     * Run
     *
     * @param \Swoft\Process\Process $process
     */
    public function run(Process $process): void
    {
        // Guzzle 支持协程
        // \GuzzleHttp\DefaultHandler::setDefaultHandler(\Yurun\Util\Swoole\Guzzle\SwooleHandler::class);

        // Don't delete this line, init: set socket timeout
        Timer::after(1000, static function () {
            Redis::publish(SubscriberEnum::REDIS_PUBLISH_WECHAT_CHAT_CHANNEL, 'hello world!');
        });
        // set socket timeout -1
        // ini_set('default_socket_timeout', '-1');
        // always true
        while (true) {
            $subscriber = function (\Redis $redis, string $chan, string $msg) {
                // set socket timeout
                $redis->setOption(\Redis::OPT_READ_TIMEOUT, -1);

                // listen to the tencent channel
                if ($chan !== SubscriberEnum::REDIS_PUBLISH_WECHAT_CHAT_CHANNEL) {
                    return;
                }

                // parse message
                try {
                    $message = json_decode($msg, true, 512, JSON_THROW_ON_ERROR);
                } catch (Throwable $e) {
                    CLog::error('Failed to parse message: %s', $e->getMessage());
                    return;
                }

                // Get EasyWeChat OfficialAccount
                try {
                    $app = $this->officialAccountsRpc->officialAccountApplicationConsole((int)$message['platformId']);
                } catch (Throwable $e) {
                    CLog::error('Failed to get official account application: %s', $e->getMessage());
                    return;
                }

                // Text Message
                if ($message['msgType'] === WebSocketMessage::TEXT_MESSAGE) {
                    $this->handleTextMessage($app, $message);
                }

                // Image Message
                if ($message['msgType'] === WebSocketMessage::IMAGE_MESSAGE) {
                    $this->handleImageMessage($app, $message);
                }

                // Video Message
                if ($message['msgType'] === WebSocketMessage::VIDEO_MESSAGE) {
                    $this->handleVideoMessage($app, $message);
                }

                // Voice Message
                if ($message['msgType'] === WebSocketMessage::VOICE_MESSAGE) {
                    $this->handleVoiceMessage($app, $message);
                }

                // News Item Message
                if ($message['msgType'] === WebSocketMessage::NEWS_ITEM_MESSAGE) {
                    $this->handleNewsItemMessage($app, $message);
                }
            };

            /** @var string $subscriber \Closure */
            Redis::subscribe([SubscriberEnum::REDIS_PUBLISH_WECHAT_CHAT_CHANNEL], $subscriber);
        }
    }

    /**
     * handle text message
     *
     * @param array                                   $message
     * @param \EasyWeChat\OfficialAccount\Application $app
     *
     * @return void
     */
    protected function handleTextMessage(Application $app, array $message): void
    {
        // send to tencent
        $DTO = ChatAssembler::attributesToTextMessageDTO($message);
        try {
            $this->chatSendToTencentDomain->textMessage($app, $DTO);
        } catch (Throwable $e) {
            CLog::error('Failed to send text message to tencent: %s', $e->getMessage());
            // todo: 发送消息回客户端
            return;
        }

        // Send to customer
        try {
            $this->chatSendToCustomerDomain->textMessage(
                $DTO->getToUserName(),
                $DTO->getFromUserName(),
                $DTO->getContent()
            );
        } catch (Throwable $e) {
            CLog::error('Failed to return text message: %s', $e->getMessage());
            // todo: 发送消息回客户端
        }

        // record message
        $this->chatMessageRecordMongoCommandRepository->insertOneMessage(
            $DTO->getToUserName(),
            (int)$DTO->getFromUserName(),
            'customer',
            WebSocketMessage::TEXT_MESSAGE,
            ['content' => $DTO->getContent()],
            true
        );
    }

    /**
     * handle video message
     *
     * @param \EasyWeChat\OfficialAccount\Application $app
     * @param array                                   $message
     *
     * @return void
     */
    protected function handleVideoMessage(Application $app, array $message): void
    {
        // send to tencent
        $DTO = ChatAssembler::attributesToVideoMessageDTO($message);
        try {
            $this->chatSendToTencentDomain->videoMessage($app, $DTO);
        } catch (Throwable $e) {
            CLog::error('Failed to send video message to tencent: %s', $e->getMessage());
            // todo: 发送消息回客户端
            return;
        }

        // send to customer
        try {
            $this->chatSendToCustomerDomain->videoMessage(
                $DTO->getToUserName(),
                $DTO->getFromUserName(),
                $DTO->getTitle(),
                $DTO->getMediaId(),
                $DTO->getDescription(),
                $DTO->getThumbMediaId(),
                $DTO->getVideoUrl()
            );
        } catch (Throwable $e) {
            CLog::error('Failed to return text message: %s', $e->getMessage());
            // todo: 发送消息回客户端
        }

        // record message
        $this->chatMessageRecordMongoCommandRepository->insertOneMessage(
            $DTO->getToUserName(),
            (int)$DTO->getFromUserName(),
            'customer',
            WebSocketMessage::VIDEO_MESSAGE,
            [
                'content'     => '[视频消息]',
                'video_url'   => $DTO->getVideoUrl(),
                'title'       => $DTO->getTitle(),
                'description' => $DTO->getDescription(),
            ],
            true
        );
    }

    /**
     * handle image message
     *
     * @param \EasyWeChat\OfficialAccount\Application $app
     * @param array                                   $message
     *
     * @return void
     */
    protected function handleImageMessage(Application $app, array $message): void
    {
        $DTO = ChatAssembler::attributesToImageMessageDTO($message);
        try {
            $this->chatSendToTencentDomain->imageMessage($app, $DTO);
        } catch (Throwable $e) {
            CLog::error('Failed to send image message to tencent: %s', $e->getMessage());
            return;
        }
        // send to customer
        try {
            $this->chatSendToCustomerDomain->imageMessage(
                $DTO->getToUserName(),
                $DTO->getFromUserName(),
                $DTO->getMediaId(),
                $DTO->getImageUrl()
            );
        } catch (Throwable $e) {
            CLog::error('Failed to return image message: %s', $e->getMessage());
        }

        // record message
        $this->chatMessageRecordMongoCommandRepository->insertOneMessage(
            $DTO->getToUserName(),
            (int)$DTO->getFromUserName(),
            'customer',
            WebSocketMessage::IMAGE_MESSAGE,
            [
                'content'   => '[图片消息]',
                'image_url' => $DTO->getImageUrl(),
            ],
            true
        );
    }

    /**
     * handle voice message
     *
     * @param \EasyWeChat\OfficialAccount\Application $app
     * @param array                                   $message
     *
     * @return void
     */
    protected function handleVoiceMessage(Application $app, array $message): void
    {
        // send to tencent
        $DTO = ChatAssembler::attributesToVoiceMessageDTO($message);
        try {
            $this->chatSendToTencentDomain->voiceMessage($app, $DTO);
        } catch (Throwable $e) {
            CLog::error('Failed to send voice message to tencent: %s', $e->getMessage());
            // todo: 发送消息回客户端
            return;
        }

        // send to customer
        try {
            $this->chatSendToCustomerDomain->voiceMessage(
                $DTO->getToUserName(),
                $DTO->getFromUserName(),
                $DTO->getMediaId(),
                $DTO->getVoiceUrl()
            );
        } catch (Throwable $e) {
            CLog::error('Failed to return voice message: %s', $e->getMessage());
        }

        // record message
        $this->chatMessageRecordMongoCommandRepository->insertOneMessage(
            $DTO->getToUserName(),
            (int)$DTO->getFromUserName(),
            'customer',
            WebSocketMessage::VOICE_MESSAGE,
            [
                'content'   => '[语音消息]',
                'voice_url' => $DTO->getVoiceUrl(),
            ],
            true
        );
    }

    /**
     * handle news item message
     *
     * @param \EasyWeChat\OfficialAccount\Application $app
     * @param array                                   $message
     *
     * @return void
     */
    protected function handleNewsItemMessage(Application $app, array $message): void
    {
        $DTO = ChatAssembler::attributesToNewsItemMessageDTO($message);
        try {
            $this->chatSendToTencentDomain->newsItemMessage($app, $DTO);
        } catch (Throwable $e) {
            CLog::error('Failed to send news item message to tencent: %s', $e->getMessage());
            // todo: 发送消息回客户端
            return;
        }

        // send to customer
        try {
            $this->chatSendToCustomerDomain->newsItemMessage(
                $DTO->getToUserName(),
                $DTO->getFromUserName(),
                $DTO->getTitle(),
                $DTO->getDescription(),
                $DTO->getNewItemUrl(),
                $DTO->getImageUrl()
            );
        } catch (Throwable $e) {
            CLog::error('Failed to return news item message: %s', $e->getMessage());
        }

        // record message
        $this->chatMessageRecordMongoCommandRepository->insertOneMessage(
            $DTO->getToUserName(),
            (int)$DTO->getFromUserName(),
            'customer',
            WebSocketMessage::NEWS_ITEM_MESSAGE,
            [
                'content'       => '[图文消息]',
                'news_item_url' => $DTO->getNewItemUrl(),
                'title'         => $DTO->getTitle(),
                'description'   => $DTO->getDescription(),
                'image_url'     => $DTO->getImageUrl(),
            ],
            true
        );
    }
}
