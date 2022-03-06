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
use App\OfficialAccount\Domain\ImageMessageHandlerDomain;
use App\OfficialAccount\Domain\MongoMessageRecordDomain;
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
class ImageMessageHandlerDomainImpl implements ImageMessageHandlerDomain
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
     * @var \App\Support\CustomerServiceHttpClient
     */
    public CustomerServiceHttpClient $customerServiceHttpClient;

    /**
     * @\Swoft\Bean\Annotation\Mapping\Inject()
     *
     * @var \App\OfficialAccount\Domain\MongoMessageRecordDomain
     */
    public MongoMessageRecordDomain $mongoMessageRecordDomain;

    /**
     * @param int                                     $platformId
     * @param \EasyWeChat\OfficialAccount\Application $application
     *
     * @throws \EasyWeChat\Kernel\Exceptions\InvalidArgumentException
     * @throws ReflectionException
     */
    public function imageMessage(int $platformId, Application $application): void
    {
        $application->server->push(function ($message) use ($application) {

            // 获取到所属的客服
            $user = $this->userQueryRepository->findByOpenid($message['FromUserName']);

            // 保存图片消息文件
            $stream   = $application->media->get($message['MediaId']);
            $filename = '';
            if ($stream instanceof StreamResponse) {
                // 以内容 md5 为文件名存到本地
                $path     = env('MEDIA_SERVER_PATH', '/var/www/agarwood/app/public/media');
                $filename = $stream->save($path . '/wechat/image/');
            }

            // 文件的路径
            $imageUrl = env('MEDIA_SERVER_DOMAIN', 'https://www.cdn.xxx.com') . '/wechat/image/' . $filename;

            // 转发给客服
            if ($user['customerId']) {
                $snowflake = new Snowflake;
                $message = [
                    'toUserName'   => $user['customerId'],
                    'fromUserId'   => $message['FromUserName'],
                    'mediaId'      => $message['MediaId'],
                    'imageUrl'     => $imageUrl,
                    'id'           => (int)$snowflake->id(),
                    'send'         => 'customer',
                    'createdAt'    => Carbon::now()->toDateTimeString(),
                    'msgType'      => WebSocketMessage::IMAGE_MESSAGE,
                ];
                Redis::publish(SubscriberEnum::REDIS_SUBSCRIBER_WECHAT_CHAT_CHANNEL, json_encode($message, JSON_THROW_ON_ERROR));
            }

            // todo 记录客服的消息到mongo
            $DTO = CallbackAssembler::attributesToImageDTO($message);
            $this->mongoMessageRecordDomain->insertImageMessageRecord($DTO);
        }, Message::IMAGE);
    }
}
