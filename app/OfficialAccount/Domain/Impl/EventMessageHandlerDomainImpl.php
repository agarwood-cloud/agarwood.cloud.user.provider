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
     * ????????????????????????
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
        // ?????????????????????
        $application->server->push(function ($message) use ($enterpriseId, $platformId, $application) {
            $DTO = CallbackAssembler::attributesToEventDTO((array)$message);

            // ????????????
            if ($DTO->getEvent() === WeChatCallbackEvent::SUBSCRIBE) {
                // ????????????????????????
                $user = $this->userQueryRepository->findByOpenid($DTO->getFromUserName());

                // ??????????????????
                $attributes                  = (array)$application->user->get($DTO->getFromUserName());
                $attributes['platform_id']   = $platformId;
                $attributes['enterprise_id'] = $enterpriseId;

                if (empty($user)) {
                    if ($DTO->getEventKey()) {
                        // ???????????????, qrscene_?????????????????????????????????????????? i.e: rqscan_from_customer_xxx
                        // ????????????????????????????????????
                        $attributes['customerId'] = str_replace(UserEnum::SCAN_FROM_CUSTOMER_UNSUBSCRIBE, '', $DTO->getEventKey());
                    } else {
                        try {
                            // ???????????????????????????????????????
                            $attributes['customerId'] = $this->assignQueue->popQueue($platformId);

                            // ????????????????????????????????????????????????
                            $this->assignSettingRepository->recordAssignFans($platformId, $attributes['customerId'], $DTO->getFromUserName());
                        } catch (Throwable $e) {
                            $attributes['customerId'] = 0;
                            CLog::error('Assign error: ' . $e->getMessage());
                        }
                    }

                    // todo ??????????????????

                    // ??????????????????
                    $this->userCommandRepository->addUserFromWeChat($attributes);
                } else {
                    // ??????????????????????????????????????????????????????????????????
                    if (empty($user['customer_id'])) {
                        try {
                            // ???????????????????????????????????????
                            $attributes['customerId'] = $this->assignQueue->popQueue($platformId);

                            // ????????????????????????????????????????????????
                            $this->assignSettingRepository->recordAssignFans($platformId, $attributes['customerId'], $DTO->getFromUserName());
                        } catch (Throwable $e) {
                            $attributes['customerId'] = 0;
                            CLog::error('Assign error: ' . $e->getMessage());
                        }

                        //  todo ??????????????????
                    }

                    // ??????????????????
                    $this->userCommandRepository->updateByOpenidFromWeChat($DTO->getFromUserName(), $attributes);
                }

                // message will be sending to customer service
                $content = 'User has subscribed to the official account!';

                // ???????????????
                if (isset($user['customerId'])) {
                    $this->publishTextMessage(
                        $user['customerId'],
                        $message['FromUserName'],
                        $content
                    );
                }

                // ????????????
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
     * ??????????????????????????????
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
                // ??????????????????
                $attributes = [
                    'platform_id'    => $platformId,
                    'subscribe'      => WeChatCallbackEvent::UNSUBSCRIBE,
                    'unsubscribe_at' => Carbon::now()->toDateTimeString(),
                    'enterprise_id'  => $enterpriseId,
                    'updated_at'     => Carbon::now()->toDateTimeString(),
                ];

                try {
                    // ???????????????????????????????????????????????????
                    $this->userCommandRepository->updateByOpenid($DTO->getFromUserName(), $attributes);
                } catch (Throwable $e) {
                    CLog::error('Update Error: ' . $e->getMessage());
                }
                $this->userCommandRepository->updateByOpenid($DTO->getFromUserName(), $attributes);

                // todo ??????????????????
                $user = $this->userQueryRepository->findByOpenid($DTO->getFromUserName());

                // ???????????????????????????
                if (!$user) {
                    return;
                }

                $content = 'User has unsubscribed from the official account!';

                // ???????????????
                if (isset($user['customerId'])) {
                    $this->publishTextMessage(
                        (string)$user['customerId'],
                        $message['FromUserName'],
                        $content
                    );
                }

                // ????????????
                $this->mongoMessageRecordDomain->insertOneMessage(
                    $DTO->getFromUserName(),
                    (int)$user['customerId'],
                    'user',
                    WebSocketMessage::TEXT_MESSAGE,
                    ['content' => $content]
                );
            }
        }, Message::EVENT);
    }

    /**
     * ??????????????????????????????
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
        $application->server->push(function ($message) use ($enterpriseId, $platformId, $application) {
            $DTO = CallbackAssembler::attributesToEventDTO((array)$message);
            if ($DTO->getEvent() === WeChatCallbackEvent::SCAN) {
                // ???????????????????????????????????????
                //??????????????????????????????????????????????????????????????????????????????????????????????????????
                $customerId = str_replace(UserEnum::SCAN_FROM_CUSTOMER_SUBSCRIBE, '', (string)$DTO->getEventKey());

                $content = 'User triggered scan event!';
                $this->insertOrUpdateUserForEvent($DTO->getToUserName(), $enterpriseId, $platformId, $application, $content, (int)$customerId);
                // todo: ???????????????
            }
        }, Message::EVENT);
    }

    /**
     * ??????????????????????????????????????????
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
        $application->server->push(function ($message) use ($enterpriseId, $platformId, $application) {
            $DTO = CallbackAssembler::attributesToEventDTO((array)$message);
            if ($DTO->getEvent() === WeChatCallbackEvent::CLICK) {
                $content = 'User triggered click event!';
                $this->insertOrUpdateUserForEvent($DTO->getToUserName(), $enterpriseId, $platformId, $application, $content);
                // todo: ???????????????
            }
        }, Message::EVENT);
    }

    /**
     * ??????????????????????????????????????????
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
        $application->server->push(function ($message) use ($enterpriseId, $platformId, $application) {
            $DTO = CallbackAssembler::attributesToEventDTO((array)$message);
            if ($DTO->getEvent() === WeChatCallbackEvent::VIEW) {
                $content = 'User triggered view event!';
                $this->insertOrUpdateUserForEvent($DTO->getToUserName(), $enterpriseId, $platformId, $application, $content);

                // todo: ???????????????
            }
        }, Message::EVENT);
    }

    /**
     * ???????????????????????????????????????redis channel
     *
     * @param int|string $toUserName ?????????uuid
     * @param string     $fromUserId ?????????openid
     * @param string     $content    ???????????????
     * @param string     $sender
     *
     * @return int
     * @throws JsonException
     */
    public function publishTextMessage(int|string $toUserName, string $fromUserId, string $content, string $sender = 'user'): int
    {
        $snowflake = new Snowflake;
        $message   = [
            'toUserName' => $toUserName,
            'fromUserId' => $fromUserId,
            'content'    => $content,
            'id'         => (int)$snowflake->id(),
            'sender'     => $sender,
            'createdAt'  => Carbon::now()->toDateTimeString(),
            'msgType'    => WebSocketMessage::TEXT_MESSAGE,
        ];

        return Redis::publish(SubscriberEnum::REDIS_SUBSCRIBER_WECHAT_CHAT_CHANNEL, json_encode($message, JSON_THROW_ON_ERROR));
    }

    /**
     * 1. ???????????????????????????????????????
     * 2. ???????????????????????????????????????
     * 3. ????????????????????????????????????mongo
     *
     * @param string                                  $openid
     * @param int                                     $enterpriseId
     * @param int                                     $platformId
     * @param \EasyWeChat\OfficialAccount\Application $application
     * @param string                                  $content
     * @param int|null                                $customer
     *
     * @return void
     * @throws \EasyWeChat\Kernel\Exceptions\InvalidConfigException
     * @throws JsonException
     */
    protected function insertOrUpdateUserForEvent(string $openid, int $enterpriseId, int $platformId, Application $application, string $content, ?int $customer = 0): void
    {
        // ???????????????????????????????????????
        //??????????????????????????????????????????????????????????????????????????????????????????????????????
        $user = $this->userQueryRepository->findByOpenid($openid);

        if ($user && !$user['customer_id']) {
            try {
                // ???????????????????????????????????????
                $customerId = $customer ?? $this->assignQueue->popQueue($platformId);
            } catch (Throwable $e) {
                $customerId = 0;
                CLog::error('AssignQueue error:' . $e->getMessage());
            }

            $attributes = [
                'platform_id' => $platformId,
                'customer_id' => $customerId,
                // todo ??????????????????
                // 'customer'   =>  $customer;
            ];
            $this->userCommandRepository->updateByOpenid($openid, $attributes);
        }

        if (empty($user)) {
            // ????????????????????????????????????
            $attributes = (array)$application->user->get($openid);
            try {
                // ???????????????????????????????????????
                $customerId = $this->assignQueue->popQueue($platformId);
            } catch (Throwable $e) {
                $customerId = 0;
                CLog::error('AssignQueue Error: %s', $e->getMessage());
            }

            // ????????????
            $attributes['enterprise_id'] = $enterpriseId;

            // todo ??????????????????
            $attributes['customer_id'] = $customerId;
            // $attributes['customer']    = ''

            // ??????????????????
            $this->userCommandRepository->addUserFromWeChat($attributes);
        }

        // ??????????????????????????? redis???channel?????????
        if (isset($user['customerId'])) {
            $this->publishTextMessage(
                $user['customerId'],
                $openid,
                $content
            );
        }

        // ????????????
        $this->mongoMessageRecordDomain->insertOneMessage(
            $openid,
            $user['customerId'] ?? 0,
            'user',
            WebSocketMessage::TEXT_MESSAGE,
            ['content' => $content]
        );
    }
}
