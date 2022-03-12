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
use App\OfficialAccount\Domain\LocationMessageHandlerDomain;
use App\OfficialAccount\Domain\MongoMessageRecordDomain;
use App\OfficialAccount\Interfaces\Assembler\CallbackAssembler;
use App\Support\CustomerServiceHttpClient;
use Carbon\Carbon;
use EasyWeChat\Kernel\Messages\Message;
use EasyWeChat\OfficialAccount\Application;
use Godruoyi\Snowflake\Snowflake;
use ReflectionException;
use Swoft\Redis\Redis;

/**
 * @\Swoft\Bean\Annotation\Mapping\Bean()
 */
class LocationMessageHandlerDomainImpl implements LocationMessageHandlerDomain
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
     * @param int                                     $platformId
     * @param \EasyWeChat\OfficialAccount\Application $application
     *
     * @throws \EasyWeChat\Kernel\Exceptions\InvalidArgumentException
     * @throws ReflectionException
     */
    public function locationMessage(int $platformId, Application $application): void
    {
        $application->server->push(function ($message) {

            // 获取到所属的客服
            $user = $this->userQueryRepository->findByOpenid($message['FromUserName']);

            // 转发给客服
            if ($user['customerId']) {
                $snowflake = new Snowflake;
                $message   = [
                    'toUserName'   => (string)$user['customerId'],
                    'fromUserName' => $message['FromUserName'],
                    'locationX'    => $message['Location_X'],
                    'locationY'    => $message['Location_Y'],
                    'scale'        => $message['Scale'],
                    'label'        => $message['Label'],
                    'id'           => (int)$snowflake->id(),
                    'sender'       => 'user',
                    'createdAt'    => Carbon::now()->toDateTimeString(),
                    'msgType'      => WebSocketMessage::LOCATION_MESSAGE,
                ];

                Redis::publish(SubscriberEnum::REDIS_SUBSCRIBER_WECHAT_CHAT_CHANNEL, json_encode($message, JSON_THROW_ON_ERROR));
            }

            // 记录客服的消息到mongo
            $DTO = CallbackAssembler::attributesToLocationDTO($message);
            $this->mongoMessageRecordDomain->insertLocationMessageRecord($DTO);
        }, Message::LOCATION);
    }
}
