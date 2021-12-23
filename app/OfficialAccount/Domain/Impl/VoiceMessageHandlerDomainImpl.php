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
     * @param int                                     $officialAccountId
     * @param \EasyWeChat\OfficialAccount\Application $application
     *
     * @throws \EasyWeChat\Kernel\Exceptions\InvalidArgumentException
     * @throws ReflectionException
     */
    public function voiceMessage(int $officialAccountId, Application $application): void
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
            $message = $this->buildAudioMessage($user['customerId'], $message['FromUserName'], $message['FromUserName'], $message['MediaId'], $voiceUrl);
            $this->customerServiceHttpClient
                ->httpClient()
                ->post('wechat/message', [
                    'json' => $message
                ]);

            // todo 记录客服的消息到mongo
            $DTO = CallbackAssembler::attributesToVoiceDTO($message);
            $this->mongoMessageRecordDomain->insertVideoMessageRecord($DTO);
        }, Message::VOICE);
    }

    /**
     * 构建文本消息的格式
     *
     * @param string $toUserName   客服的uuid
     * @param string $fromUserId   粉丝的openid
     * @param string $fromUserName 粉丝的昵称
     * @param string $mediaId
     * @param string $voiceUrl
     *
     * @return array
     */
    public function buildAudioMessage(string $toUserName, string $fromUserId, string $fromUserName, string $mediaId, string $voiceUrl): array
    {
        $snowflake = new Snowflake;
        return [
            'toUserName'     => $toUserName,
            'fromUserId'     => $fromUserId,
            'fromUserName'   => $fromUserName,
            'mediaId'        => $mediaId,
            'voiceUrl'       => $voiceUrl,
            'id'             => $snowflake->id(),
            'sender'         => 'user',
            'createTime'     => Carbon::now()->toDateTimeString(),
            'msgType'        => WebSocketMessage::SERVER_VOICE_MESSAGE,
        ];
    }
}
