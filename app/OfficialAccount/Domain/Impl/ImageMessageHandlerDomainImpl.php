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
     * @param int                                     $officialAccountId
     * @param \EasyWeChat\OfficialAccount\Application $application
     *
     * @throws \EasyWeChat\Kernel\Exceptions\InvalidArgumentException
     * @throws ReflectionException
     */
    public function imageMessage(int $officialAccountId, Application $application): void
    {
        $application->server->push(function ($message) use ($application) {

            // 获取到所属的客服
            $user = $this->userQueryRepository->findByOpenid($message['FromUserName']);

            // 保存图片消息文件
            $stream   = $application->media->get($message['MediaId']);
            $filename = '';
            if ($stream instanceof StreamResponse) {
                // 以内容 md5 为文件名存到本地
                $path     = env('MEDIA_SERVER_PATH', '/var/www/www.cdn.xxx.com/');
                $filename = $stream->save($path . '/wechat/media/image/');
            }

            // 文件的路径
            $imageUrl = env('MEDIA_SERVER_DOMAIN', 'https://www.cdn.xxx.com') . '/wechat/media/image/' . $filename;

            // 转发给客服
            $message = $this->buildImageMessage($user['customerId'], $message['FromUserName'], $message['FromUserName'], $message['MediaId'], $imageUrl);
            $this->customerServiceHttpClient
                ->httpClient()
                ->post('wechat/message', [
                    'json' => $message
                ]);

            // todo 记录客服的消息到mongo
            $DTO = CallbackAssembler::attributesToImageDTO($message);
            $this->mongoMessageRecordDomain->insertImageMessageRecord($DTO);
        }, Message::IMAGE);
    }

    /**
     * 构建文本消息的格式
     *
     * @param string $toUserName   客服的uuid
     * @param string $fromUserId   粉丝的openid
     * @param string $fromUserName 粉丝的昵称
     * @param string $mediaId
     * @param string $imageUrl
     *
     * @return array
     */
    public function buildImageMessage(string $toUserName, string $fromUserId, string $fromUserName, string $mediaId, string $imageUrl): array
    {
        $snowflake = new Snowflake;
        return [
            'toUserName'   => $toUserName,
            'fromUserId'   => $fromUserId,
            'fromUserName' => $fromUserName,
            'mediaId'      => $mediaId,
            'imageUrl'     => $imageUrl,
            'id'           => $snowflake->id(),
            'send'         => 'customer',
            'createTime'   => Carbon::now()->toDateTimeString(),
            'msgType'      => WebSocketMessage::SERVER_VOICE_MESSAGE,
        ];
    }
}
