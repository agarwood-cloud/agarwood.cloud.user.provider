<?php declare(strict_types=1);
/**
 * This file is part of Agarwood Cloud.
 *
 * @link     https://www.agarwood-cloud.com
 * @document https://www.agarwood-cloud.com/docs
 * @contact  676786620@qq.com
 * @author   agarwood
 */

namespace App\OfficialAccount\Domain\Impl;

use App\OfficialAccount\Domain\Aggregate\Enum\SubscriberEnum;
use App\OfficialAccount\Domain\Aggregate\Enum\WebSocketMessage;
use App\OfficialAccount\Domain\Aggregate\Repository\UserCommandRepository;
use App\OfficialAccount\Domain\Aggregate\Repository\UserQueryRepository;
use App\OfficialAccount\Domain\MongoMessageRecordDomain;
use App\OfficialAccount\Domain\VoiceMessageHandlerDomain;
use App\OfficialAccount\Interfaces\Assembler\CallbackAssembler;
use App\Support\CustomerServiceHttpClient;
use Carbon\Carbon;
use EasyWeChat\Kernel\Http\StreamResponse;
use EasyWeChat\Kernel\Messages\Message;
use EasyWeChat\OfficialAccount\Application;
use Godruoyi\Snowflake\Snowflake;
use ReflectionException;
use Swoft\Redis\Redis;

/**
 * @\Swoft\Bean\Annotation\Mapping\Bean()
 */
class VoiceMessageHandlerDomainImpl implements VoiceMessageHandlerDomain
{
    /**
     * @\Swoft\Bean\Annotation\Mapping\Inject()
     *
     * @var \App\OfficialAccount\Domain\Aggregate\Repository\UserQueryRepository
     */
    public UserQueryRepository $userQueryRepository;

    /**
     * @\Swoft\Bean\Annotation\Mapping\Inject()
     *
     * @var \App\OfficialAccount\Domain\Aggregate\Repository\UserCommandRepository
     */
    public UserCommandRepository $userCommandRepository;

    /**
     * @\Swoft\Bean\Annotation\Mapping\Inject()
     *
     * @var \App\OfficialAccount\Domain\MongoMessageRecordDomain
     */
    public MongoMessageRecordDomain $mongoMessageRecordDomain;

    /**
     * @\Swoft\Bean\Annotation\Mapping\Inject()
     *
     * @var \App\Support\CustomerServiceHttpClient
     */
    public CustomerServiceHttpClient $customerServiceHttpClient;

    /**
     * @param int                                     $tencentId
     * @param \EasyWeChat\OfficialAccount\Application $application
     *
     * @throws \EasyWeChat\Kernel\Exceptions\InvalidArgumentException
     * @throws ReflectionException
     */
    public function voiceMessage(int $tencentId, Application $application): void
    {
        $application->server->push(function ($message) use ($application) {

            // 获取到所属的客服
            $user = $this->userQueryRepository->findByOpenid($message['FromUserName']);

            // 保存语音消息文件
            $stream   = $application->media->get($message['MediaId']);
            $filename = '';
            if ($stream instanceof StreamResponse) {
                // 以内容 md5 为文件名存到本地
                $path     = env('MEDIA_SERVER_PATH', '/var/www/www.cdn.xxx.com/');
                $filename = $stream->save($path . '/wechat/media/audio/');
            }

            // 文件的路径
            $voiceUrl = env('MEDIA_SERVER_DOMAIN', 'https://www.cdn.xxx.com') . '/wechat/media/audio/' . $filename;

            // 转发给客服
            if ($user['customerId']) {
                $snowflake = new Snowflake;
                $message =  [
                    'toUserName'     => $user['customerId'],
                    'fromUserId'     => $message['FromUserName'],
                    'mediaId'        => $message['MediaId'],
                    'voiceUrl'       => $voiceUrl,
                    'id'             => (int)$snowflake->id(),
                    'sender'         => 'user',
                    'createdAt'      => Carbon::now()->toDateTimeString(),
                    'msgType'        => WebSocketMessage::SERVER_VOICE_MESSAGE,
                ];

                Redis::publish(SubscriberEnum::REDIS_SUBSCRIBER_WECHAT_CHAT_CHANNEL, json_encode($message, JSON_THROW_ON_ERROR));
            }

            // todo 记录客服的消息到mongo
            $DTO = CallbackAssembler::attributesToVideoDTO($message);
            $this->mongoMessageRecordDomain->insertVideoMessageRecord($DTO);
        }, Message::VOICE);
    }
}
