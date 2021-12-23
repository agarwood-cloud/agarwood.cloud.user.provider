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
use ReflectionException;

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
     * @param int         $officialAccountId
     * @param Application $application
     *
     * @return void
     * @throws \EasyWeChat\Kernel\Exceptions\InvalidArgumentException
     * @throws ReflectionException
     */
    public function eventSubscribe(int $officialAccountId, Application $application): void
    {
        // 记录用户的信息
        $application->server->push(function ($message) use ($officialAccountId, $application) {
            $DTO = CallbackAssembler::attributesToEventDTO((array)$message);

            // 关注事件
            if ($DTO->getEvent() === WeChatCallbackEvent::SUBSCRIBE) {
                // 用户信息是否存在
                $user = $this->userQueryRepository->findByOpenid($DTO->getFromUserName());

                $attributes          = (array)$application->user->get($DTO->getFromUserName());
                $attributes['oa_id'] = $officialAccountId;

                if (empty($user)) {
                    if ($DTO->getEventKey()) {
                        // 未关注扫码, qrscene_为前缀，后面为二维码的参数值 i.e: rqscan_from_customer_xxx
                        // 扫码过来的，不算是抢粉的
                        $attributes['customerId'] = str_replace(UserEnum::SCAN_FROM_CUSTOMER_UNSUBSCRIBE, '', $DTO->getEventKey());
                    } else {
                        // 这里是通过分粉的机制来分粉
                        $attributes['customerId'] = $this->assignQueue->popQueue($officialAccountId);

                        // 重新分配也算是抢粉，记录抢粉信息
                        $this->assignSettingRepository->recordAssignFans($officialAccountId, $attributes['customerId'], $DTO->getFromUserName());
                    }

                    // todo 关联客服信息

                    // $attributes['customerId'] && $attributes['customer'] = $this->customerExtendsRepository->findByUuid($attributes['customerUuid'])->getName();

                    // 记录用户信息
                    $this->userCommandRepository->addUserFromWeChat($attributes);
                } else {
                    // 如果已关注的，且没有分配客服，则重新分配客服
                    if (empty($user['customer_id'])) {
                        // 这里是通过分粉的机制来分粉
                        $attributes['customerId'] = $this->assignQueue->popQueue($officialAccountId);

                        //  todo 关联客服信息
                        // $attributes['customerId'] && $attributes['customer'] = $this->customerExtendsRepository->findByUuid($attributes['customerId'])->getName();

                        // 重新分配也算是抢粉，记录抢粉信息
                        $this->assignSettingRepository->recordAssignFans($officialAccountId, $attributes['customerId'], $DTO->getFromUserName());
                    }

                    // 更新用户信息
                    $this->userCommandRepository->updateByOpenidFromWeChat($DTO->getFromUserName(), $attributes);
                }

                $content = 'The user has subscribed to the official account!';

                // 转发给客服, todo $user['customerId'] 可能不存在
                $message = $this->buildTextMessage(
                    $user['customerId'],
                    $message['FromUserName'],
                    $message['FromUserName'],
                    $content
                );
                $this->customerServiceHttpClient
                    ->httpClient()
                    ->post('wechat/message', [
                        'json' => $message
                    ]);

                // 记录消息
                $this->mongoMessageRecordDomain->insertOneMessage(
                    $DTO->getFromUserName(),
                    $user['customerId'],
                    'user',
                    WebSocketMessage::SERVER_TEXT_MESSAGE,
                    ['content' => $content],
                    Carbon::now()->toDateTimeString(),
                    false
                );
            }
        }, Message::EVENT);
    }

    /**
     * 取消关注事件领域服务
     *
     * @param int         $officialAccountId
     * @param Application $application
     *
     * @return void
     * @throws \EasyWeChat\Kernel\Exceptions\InvalidArgumentException
     * @throws ReflectionException
     */
    public function eventUnsubscribe(int $officialAccountId, Application $application): void
    {
        $application->server->push(function ($message) use ($officialAccountId) {
            $DTO = CallbackAssembler::attributesToEventDTO((array)$message);
            if ($DTO->getEvent() === WeChatCallbackEvent::UNSUBSCRIBE) {
                // 取消关注事件
                $attributes = [
                    'oa_id'          => $officialAccountId,
                    'subscribe'      => 'unsubscribe',
                    'unsubscribe_at' => Carbon::now()->toDateTimeString()
                ];
                $this->userCommandRepository->updateByOpenid($DTO->getFromUserName(), $attributes);

                // todo 获取用户信息
                $user = $this->userQueryRepository->findByOpenid($DTO->getFromUserName());

                $content = 'The user has unsubscribed from the official account!';

                // 转发给客服
                if ($user) {
                    $message = $this->buildTextMessage(
                        $user['customerId'],
                        $message['FromUserName'],
                        $message['FromUserName'],
                        $content
                    );
                    $this->customerServiceHttpClient
                        ->httpClient()
                        ->post('wechat/message', [
                            'json' => $message
                        ]);
                }

                // 消息记录
                $this->mongoMessageRecordDomain->insertOneMessage(
                    $DTO->getFromUserName(),
                    $user['customerId'],
                    'user',
                    WebSocketMessage::SERVER_TEXT_MESSAGE,
                    ['content' => $content],
                    Carbon::now()->toDateTimeString(),
                    false
                );
            }
        }, Message::EVENT);
    }

    /**
     * 关注扫码事件领域服务
     *
     * @param int         $officialAccountId
     * @param Application $application
     *
     * @return void
     * @throws \EasyWeChat\Kernel\Exceptions\InvalidArgumentException
     * @throws ReflectionException
     */
    public function eventScan(int $officialAccountId, Application $application): void
    {
        $application->server->push(function ($message) use ($officialAccountId, $application) {
            $DTO = CallbackAssembler::attributesToEventDTO((array)$message);
            if ($DTO->getEvent() === WeChatCallbackEvent::SCAN) {
                // 如果存在则，更新所属的客服
                //这里是记录，这里要注意，如果有多种扫码事件，我们就应该要有不同的处理
                $customerId = str_replace(UserEnum::SCAN_FROM_CUSTOMER_SUBSCRIBE, '', (string)$DTO->getEventKey());

                $user = $this->userQueryRepository->findByOpenid($DTO->getFromUserName());

                if ($user) {
                    $attributes = [
                        'oa_id'       => $officialAccountId,
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

                $content = 'The user subscribes to the official account by scanning the code!';

                // 转发给客服
                $message = $this->buildTextMessage(
                    $user['customerId'],
                    $message['FromUserName'],
                    $message['FromUserName'],
                    $content
                );
                $this->customerServiceHttpClient
                    ->httpClient()
                    ->post('wechat/message', [
                        'json' => $message
                    ]);

                // 消息记录
                $this->mongoMessageRecordDomain->insertOneMessage(
                    $DTO->getFromUserName(),
                    $user['customerId'],
                    'user',
                    WebSocketMessage::SERVER_TEXT_MESSAGE,
                    ['content' => $content],
                    Carbon::now()->toDateTimeString(),
                    false
                );
            }
        }, Message::EVENT);
    }

    /**
     * 点击菜单拉取消息时的事件推送
     *
     * @param int         $officialAccountId
     * @param Application $application
     *
     * @return void
     * @throws \EasyWeChat\Kernel\Exceptions\InvalidArgumentException
     * @throws ReflectionException
     */
    public function eventClick(int $officialAccountId, Application $application): void
    {
        $application->server->push(function ($message) use ($officialAccountId, $application) {
            $DTO = CallbackAssembler::attributesToEventDTO((array)$message);
            if ($DTO->getEvent() === WeChatCallbackEvent::CLICK) {
                // 如果存在则，更新所属的客服
                //这里是记录，这里要注意，如果有多种扫码事件，我们就应该要有不同的处理
                $user = $this->userQueryRepository->findByOpenid($DTO->getFromUserName());
                if ($user && $user['customer_id']) {
                    // 这里是通过分粉的机制来分粉
                    $customerId = $this->assignQueue->popQueue($officialAccountId);

                    $attributes = [
                        'oa_id'       => $officialAccountId,
                        'customer_id' => $customerId,
                        // todo 关联客服信息 'customer'   =>  $customer;
                    ];
                    $this->userCommandRepository->updateByOpenid($DTO->getFromUserName(), $attributes);
                } else {
                    // 当用户信息不存在数据库时
                    $attributes = (array)$application->user->get($DTO->getFromUserName());
                    $customerId = $this->assignQueue->popQueue($officialAccountId);

                    // todo 关联客服信息
                    $attributes['customer_id'] = (int)$customerId;
                    // $attributes['customer']    = ''

                    // 记录用户信息
                    $this->userCommandRepository->addUserFromWeChat($attributes);
                }

                $content = 'The user clicks on the official account menu!';

                // 转发给客服
                $message = $this->buildTextMessage(
                    $user['customerId'],
                    $message['FromUserName'],
                    $message['FromUserName'],
                    $content
                );
                $this->customerServiceHttpClient
                    ->httpClient()
                    ->post('wechat/message', [
                        'json' => $message
                    ]);

                // 消息记录
                $this->mongoMessageRecordDomain->insertOneMessage(
                    $DTO->getFromUserName(),
                    $user['customerId'],
                    'user',
                    WebSocketMessage::SERVER_TEXT_MESSAGE,
                    ['content' => $content],
                    Carbon::now()->toDateTimeString(),
                    false
                );
            }
        }, Message::EVENT);
    }

    /**
     * 点击菜单跳转链接时的事件推送
     *
     * @param int         $officialAccountId
     * @param Application $application
     *
     * @return void
     * @throws \EasyWeChat\Kernel\Exceptions\InvalidArgumentException
     * @throws ReflectionException
     */
    public function eventView(int $officialAccountId, Application $application): void
    {
        $application->server->push(function ($message) use ($officialAccountId, $application) {
            $DTO = CallbackAssembler::attributesToEventDTO((array)$message);
            if ($DTO->getEvent() === WeChatCallbackEvent::VIEW) {
                // 如果存在则，更新所属的客服
                //这里是记录，这里要注意，如果有多种扫码事件，我们就应该要有不同的处理
                $user = $this->userQueryRepository->findByOpenid($DTO->getFromUserName());

                if ($user && $user['customer_id']) {

                    // 这里是通过分粉的机制来分粉
                    $customerId = $this->assignQueue->popQueue($officialAccountId);

                    $attributes = [
                        'oa_id'       => $officialAccountId,
                        'customer_id' => $customerId,
                        // todo 关联客服信息 'customer'   =>  $customer;
                    ];
                    $this->userCommandRepository->updateByOpenid($DTO->getFromUserName(), $attributes);
                } else {
                    // 当用户信息不存在数据库时
                    $attributes = (array)$application->user->get($DTO->getFromUserName());
                    $customerId = $this->assignQueue->popQueue($officialAccountId);

                    // todo 关联客服信息
                    $attributes['customer_id'] = $customerId;
                    // $attributes['customer']    = ''

                    // 记录用户信息
                    $this->userCommandRepository->addUserFromWeChat($attributes);
                }

                $content = 'Use the view to click the official account menu!';

                // 转发给客服
                $message = $this->buildTextMessage(
                    $user['customerId'],
                    $message['FromUserName'],
                    $message['FromUserName'],
                    $content
                );
                $this->customerServiceHttpClient
                    ->httpClient()
                    ->post('wechat/message', [
                        'json' => $message
                    ]);

                // 消息记录
                $this->mongoMessageRecordDomain->insertOneMessage(
                    $DTO->getFromUserName(),
                    $user['customerId'],
                    'user',
                    WebSocketMessage::SERVER_TEXT_MESSAGE,
                    ['content' => $content],
                    Carbon::now()->toDateTimeString(),
                    false
                );
            }
        }, Message::EVENT);
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
