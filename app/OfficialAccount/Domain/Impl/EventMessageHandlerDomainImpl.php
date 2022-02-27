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

use App\Assign\Domain\Aggregate\Repository\AssignSettingRepository;
use App\Assign\Domain\AssignQueue;
use App\OfficialAccount\Domain\Aggregate\Enum\SubscriberEnum;
use App\OfficialAccount\Domain\Aggregate\Enum\WebSocketMessage;
use App\OfficialAccount\Domain\Aggregate\Enum\WeChatCallbackEvent;
use App\OfficialAccount\Domain\Aggregate\Repository\UserCommandRepository;
use App\OfficialAccount\Domain\Aggregate\Repository\UserQueryRepository;
use App\OfficialAccount\Domain\EventMessageHandlerDomain;
use App\OfficialAccount\Domain\MongoMessageRecordDomain;
use App\OfficialAccount\Infrastructure\Enum\UserEnum;
use App\OfficialAccount\Interfaces\Assembler\CallbackAssembler;
use App\OfficialAccount\Interfaces\Rpc\Client\MallCenter\OfficialAccountsRpc;
use App\Support\CustomerServiceHttpClient;
use Carbon\Carbon;
use EasyWeChat\Kernel\Messages\Message;
use EasyWeChat\OfficialAccount\Application;
use Godruoyi\Snowflake\Snowflake;
use JsonException;
use ReflectionException;
use Swoft\Log\Helper\CLog;
use Swoft\Redis\Redis;
use Throwable;

/**
 * @\Swoft\Bean\Annotation\Mapping\Bean()
 */
class EventMessageHandlerDomainImpl implements EventMessageHandlerDomain
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
     * @var \App\Assign\Domain\AssignQueue
     */
    protected AssignQueue $assignQueue;

    /**
     * @\Swoft\Bean\Annotation\Mapping\Inject()
     *
     * @var \App\Assign\Domain\Aggregate\Repository\AssignSettingRepository
     */
    public AssignSettingRepository $assignSettingRepository;

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
     * 关注事件领域服务
     *
     * @param int         $enterpriseId
     * @param int         $platformId
     * @param Application $application
     *
     * @return void
     * @throws \EasyWeChat\Kernel\Exceptions\InvalidArgumentException
     * @throws ReflectionException
     */
    public function eventSubscribe(int $enterpriseId, int $platformId, Application $application): void
    {
        // 记录用户的信息
        $application->server->push(function ($message) use ($enterpriseId, $platformId, $application) {
            $DTO = CallbackAssembler::attributesToEventDTO((array)$message);

            // 关注事件
            if ($DTO->getEvent() === WeChatCallbackEvent::SUBSCRIBE) {
                // 用户信息是否存在
                $user = $this->userQueryRepository->findByOpenid($DTO->getFromUserName());

                // 获取用户信息
                $attributes                  = (array)$application->user->get($DTO->getFromUserName());
                $attributes['platform_id']   = $platformId;
                $attributes['enterprise_id'] = $enterpriseId;

                if (empty($user)) {
                    if ($DTO->getEventKey()) {
                        // 未关注扫码, qrscene_为前缀，后面为二维码的参数值 i.e: rqscan_from_customer_xxx
                        // 扫码过来的，不算是抢粉的
                        $attributes['customerId'] = str_replace(UserEnum::SCAN_FROM_CUSTOMER_UNSUBSCRIBE, '', $DTO->getEventKey());
                    } else {
                        // 这里是通过分粉的机制来分粉
                        try {
                            $attributes['customerId'] = $this->assignQueue->popQueue($platformId);
                        } catch (Throwable $e) {
                            $attributes['customerId'] = 0;
                            CLog::error('Assign error: ' . $e->getMessage());
                        }

                        // 重新分配也算是抢粉，记录抢粉信息
                        $this->assignSettingRepository->recordAssignFans($platformId, $attributes['customerId'], $DTO->getFromUserName());
                    }

                    // todo 关联客服信息

                    // 记录用户信息
                    $this->userCommandRepository->addUserFromWeChat($attributes);
                } else {
                    // 如果已关注的，且没有分配客服，则重新分配客服
                    if (empty($user['customer_id'])) {
                        // 这里是通过分粉的机制来分粉
                        try {
                            $attributes['customerId'] = $this->assignQueue->popQueue($platformId);
                        } catch (Throwable $e) {
                            $attributes['customerId'] = 0;
                            CLog::error('Assign error: ' . $e->getMessage());
                        }

                        //  todo 关联客服信息

                        // 重新分配也算是抢粉，记录抢粉信息
                        $this->assignSettingRepository->recordAssignFans($platformId, $attributes['customerId'], $DTO->getFromUserName());
                    }

                    // 更新用户信息
                    $this->userCommandRepository->updateByOpenidFromWeChat($DTO->getFromUserName(), $attributes);
                }

                // message will be sending to customer service
                $content = 'User has subscribed to the official account!';

                // 转发给客服
                if (isset($user['customerId'])) {
                    $this->publishTextMessage(
                        $user['customerId'],
                        $message['FromUserName'],
                        $content
                    );
                }

                // 记录消息
                $this->mongoMessageRecordDomain->insertOneMessage(
                    $DTO->getFromUserName(),
                    $user['customerId'] ?? 0,
                    'user',
                    WebSocketMessage::TEXT_MESSAGE,
                    ['content' => $content]
                );
            }
        }, Message::EVENT);
    }

    /**
     * 取消关注事件领域服务
     *
     * @param int         $enterpriseId
     * @param int         $platformId
     * @param Application $application
     *
     * @return void
     * @throws \EasyWeChat\Kernel\Exceptions\InvalidArgumentException
     * @throws ReflectionException
     */
    public function eventUnsubscribe(int $enterpriseId, int $platformId, Application $application): void
    {
        $application->server->push(function ($message) use ($enterpriseId, $platformId) {
            $DTO = CallbackAssembler::attributesToEventDTO((array)$message);
            if ($DTO->getEvent() === WeChatCallbackEvent::UNSUBSCRIBE) {
                // 取消关注事件
                $attributes = [
                    'platform_id'    => $platformId,
                    'subscribe'      => 'unsubscribe',
                    'unsubscribe_at' => Carbon::now()->toDateTimeString(),
                    'enterprise_id'  => $enterpriseId,
                ];
                $this->userCommandRepository->updateByOpenid($DTO->getFromUserName(), $attributes);

                // todo 获取用户信息
                $user = $this->userQueryRepository->findByOpenid($DTO->getFromUserName());

                // 如果不存在用户信息
                if (!$user) {
                    return;
                }

                $content = 'User has unsubscribed from the official account!';

                // 转发给客服
                if (isset($user['customerId'])) {
                    $this->publishTextMessage(
                        $user['customerId'],
                        $message['FromUserName'],
                        $content
                    );
                }

                // 消息记录
                $this->mongoMessageRecordDomain->insertOneMessage(
                    $DTO->getFromUserName(),
                    $user['customerId'] ?? 0,
                    'user',
                    WebSocketMessage::TEXT_MESSAGE,
                    ['content' => $content]
                );
            }
        }, Message::EVENT);
    }

    /**
     * 关注扫码事件领域服务
     *
     * @param int         $enterpriseId
     * @param int         $platformId
     * @param Application $application
     *
     * @return void
     * @throws \EasyWeChat\Kernel\Exceptions\InvalidArgumentException
     * @throws ReflectionException
     */
    public function eventScan(int $enterpriseId, int $platformId, Application $application): void
    {
        $application->server->push(function ($message) use ($platformId, $application) {
            $DTO = CallbackAssembler::attributesToEventDTO((array)$message);
            if ($DTO->getEvent() === WeChatCallbackEvent::SCAN) {
                // 如果存在则，更新所属的客服
                //这里是记录，这里要注意，如果有多种扫码事件，我们就应该要有不同的处理
                $customerId = str_replace(UserEnum::SCAN_FROM_CUSTOMER_SUBSCRIBE, '', (string)$DTO->getEventKey());

                $user = $this->userQueryRepository->findByOpenid($DTO->getFromUserName());

                if ($user) {
                    $attributes = [
                        'platform_id' => $platformId,
                        'customer_id' => (int)$customerId,
                        // todo 关联客服信息 'customer'   =>  $customer;
                    ];
                    $this->userCommandRepository->updateByOpenid($DTO->getFromUserName(), $attributes);
                } else {
                    // 当用户信息不存在数据库时
                    $attributes = (array)$application->user->get($DTO->getFromUserName());

                    // todo 关联客服信息
                    $attributes['customer_id'] = (int)$customerId;
                    // $attributes['customer']    = ''

                    // 记录用户信息
                    $this->userCommandRepository->addUserFromWeChat($attributes);
                }

                $content = 'User subscribes to the official account by scanning the code!';

                // 转发给客服
                if (isset($user['customerId'])) {
                    $this->publishTextMessage(
                        $user['customerId'],
                        $message['FromUserName'],
                        $content
                    );
                }
                // 消息记录
                $this->mongoMessageRecordDomain->insertOneMessage(
                    $DTO->getFromUserName(),
                    $user['customerId'] ?? 0,
                    'user',
                    WebSocketMessage::TEXT_MESSAGE,
                    ['content' => $content],
                );
            }
        }, Message::EVENT);
    }

    /**
     * 点击菜单拉取消息时的事件推送
     *
     * @param int         $enterpriseId
     * @param int         $platformId
     * @param Application $application
     *
     * @return void
     * @throws \EasyWeChat\Kernel\Exceptions\InvalidArgumentException
     * @throws ReflectionException
     */
    public function eventClick(int $enterpriseId, int $platformId, Application $application): void
    {
        $application->server->push(function ($message) use ($platformId, $application) {
            $DTO = CallbackAssembler::attributesToEventDTO((array)$message);
            if ($DTO->getEvent() === WeChatCallbackEvent::CLICK) {
                // 如果存在则，更新所属的客服
                //这里是记录，这里要注意，如果有多种扫码事件，我们就应该要有不同的处理
                $user = $this->userQueryRepository->findByOpenid($DTO->getFromUserName());
                if ($user && $user['customer_id']) {
                    // 这里是通过分粉的机制来分粉
                    $customerId = $this->assignQueue->popQueue($platformId);

                    $attributes = [
                        'platform_id' => $platformId,
                        'customer_id' => $customerId,
                        // todo 关联客服信息 'customer'   =>  $customer;
                    ];
                    $this->userCommandRepository->updateByOpenid($DTO->getFromUserName(), $attributes);
                } else {
                    // 当用户信息不存在数据库时
                    $attributes = (array)$application->user->get($DTO->getFromUserName());
                    $customerId = $this->assignQueue->popQueue($platformId);

                    // todo 关联客服信息
                    $attributes['customer_id'] = $customerId;
                    // $attributes['customer']    = ''

                    // 记录用户信息
                    $this->userCommandRepository->addUserFromWeChat($attributes);
                }

                $content = 'User clicks on the official account menu!';

                // 转发给客服
                if (isset($user['customerId'])) {
                    $this->publishTextMessage(
                        $user['customerId'],
                        $message['FromUserName'],
                        $content
                    );
                }

                // 消息记录
                $this->mongoMessageRecordDomain->insertOneMessage(
                    $DTO->getFromUserName(),
                    $user['customerId'] ?? 0,
                    'user',
                    WebSocketMessage::TEXT_MESSAGE,
                    ['content' => $content]
                );
            }
        }, Message::EVENT);
    }

    /**
     * 点击菜单跳转链接时的事件推送
     *
     * @param int         $enterpriseId
     * @param int         $platformId
     * @param Application $application
     *
     * @return void
     * @throws \EasyWeChat\Kernel\Exceptions\InvalidArgumentException
     * @throws ReflectionException
     */
    public function eventView(int $enterpriseId, int $platformId, Application $application): void
    {
        $application->server->push(function ($message) use ($platformId, $application) {
            $DTO = CallbackAssembler::attributesToEventDTO((array)$message);
            if ($DTO->getEvent() === WeChatCallbackEvent::VIEW) {
                // 如果存在则，更新所属的客服
                //这里是记录，这里要注意，如果有多种扫码事件，我们就应该要有不同的处理
                $user = $this->userQueryRepository->findByOpenid($DTO->getFromUserName());

                if ($user && $user['customer_id']) {

                    // 这里是通过分粉的机制来分粉
                    $customerId = $this->assignQueue->popQueue($platformId);

                    $attributes = [
                        'platform_id' => $platformId,
                        'customer_id' => $customerId,
                        // todo 关联客服信息 'customer'   =>  $customer;
                    ];
                    $this->userCommandRepository->updateByOpenid($DTO->getFromUserName(), $attributes);
                } else {
                    // 当用户信息不存在数据库时
                    $attributes = (array)$application->user->get($DTO->getFromUserName());
                    $customerId = $this->assignQueue->popQueue($platformId);

                    // todo 关联客服信息
                    $attributes['customer_id'] = $customerId;
                    // $attributes['customer']    = ''

                    // 记录用户信息
                    $this->userCommandRepository->addUserFromWeChat($attributes);
                }

                $content = 'User browses the contents of the official account menu!';

                // 转发给客服，写入到 redis的channel里面去
                if (isset($user['customerId'])) {
                    $this->publishTextMessage(
                        $user['customerId'],
                        $message['FromUserName'],
                        $content
                    );
                }

                // 消息记录
                $this->mongoMessageRecordDomain->insertOneMessage(
                    $DTO->getFromUserName(),
                    $user['customerId'] ?? 0,
                    'user',
                    WebSocketMessage::TEXT_MESSAGE,
                    ['content' => $content]
                );
            }
        }, Message::EVENT);
    }

    /**
     * 构建文本消息的格式，推送到redis channel
     *
     * @param string $toUserName 客服的uuid
     * @param string $fromUserId 粉丝的openid
     * @param string $content    转发的消息
     *
     * @return int
     * @throws JsonException
     */
    public function publishTextMessage(string $toUserName, string $fromUserId, string $content): int
    {
        $snowflake = new Snowflake;
        $message   = [
            'toUserName' => $toUserName,
            'fromUserId' => $fromUserId,
            'content'    => $content,
            'id'         => (int)$snowflake->id(),
            'sender'     => 'user',
            'createdAt'  => Carbon::now()->toDateTimeString(),
            'msgType'    => WebSocketMessage::TEXT_MESSAGE,
        ];

        return Redis::publish(SubscriberEnum::REDIS_SUBSCRIBER_WECHAT_CHAT_CHANNEL, json_encode($message, JSON_THROW_ON_ERROR));
    }
}
