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
use App\OfficialAccount\Domain\TextMessageHandlerDomain;
use App\OfficialAccount\Interfaces\Assembler\CallbackAssembler;
use App\Support\CustomerServiceHttpClient;
use Carbon\Carbon;
use EasyWeChat\Kernel\Messages\Message;
use EasyWeChat\OfficialAccount\Application;
use Godruoyi\Snowflake\Snowflake;
use ReflectionException;

/**
 * @\Swoft\Bean\Annotation\Mapping\Bean()
 */
class TextMessageHandlerDomainImpl implements TextMessageHandlerDomain
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
     * 文件消息
     *
     * @param int                                     $officialAccountId
     * @param \EasyWeChat\OfficialAccount\Application $application
     *
     * @throws \EasyWeChat\Kernel\Exceptions\InvalidArgumentException
     * @throws ReflectionException
     */
    public function textMessage(int $officialAccountId, Application $application): void
    {
        $application->server->push(function ($payload) {
            // todo 获取到所属的客服
            $user = $this->userQueryRepository->findByOpenid($payload['FromUserName']);

            // 转发给客服
            $message = $this->buildTextMessage($user['customerId'], $payload['FromUserName'], $payload['FromUserName'], $payload['Content']);
            $this->customerServiceHttpClient
                ->httpClient()
                ->post('wechat/message', [
                    'json' => $message
                ]);

            // 记录客服的消息到mongo
            $DTO = CallbackAssembler::attributesToTextDTO((array)$payload);
            $this->mongoMessageRecordDomain->insertTextMessageRecord($DTO);
        }, Message::TEXT);
    }

    /**
     * 构建文本消息的格式
     *
     * @param string $toUserName   客服的uuid
     * @param string $fromUserId   粉丝的openid
     * @param string $fromUserName 粉丝的昵称
     * @param string $content      转发的消息
     *
     * @return array
     */
    public function buildTextMessage(string $toUserName, string $fromUserId, string $fromUserName, string $content): array
    {
        $snowflake = new Snowflake;
        return [
            'toUserName'   => $toUserName,
            'fromUserId'   => $fromUserId,
            'fromUserName' => $fromUserName,
            'content'      => $content,
            'id'           => $snowflake->id(),
            'sender'       => 'user',
            'createTime'   => Carbon::now()->toDateTimeString(),
            'msgType'      => WebSocketMessage::SERVER_TEXT_MESSAGE,
        ];
    }
}
