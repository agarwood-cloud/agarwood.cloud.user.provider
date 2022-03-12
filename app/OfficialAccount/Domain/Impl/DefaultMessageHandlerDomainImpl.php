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

use App\Assign\Domain\AssignQueue;
use App\OfficialAccount\Domain\Aggregate\Repository\UserCommandRepository;
use App\OfficialAccount\Domain\Aggregate\Repository\UserQueryRepository;
use App\OfficialAccount\Domain\DefaultMessageHandlerDomain;
use App\OfficialAccount\Domain\MongoMessageRecordDomain;
use App\Support\CustomerServiceHttpClient;
use EasyWeChat\Kernel\Messages\Message;
use EasyWeChat\OfficialAccount\Application;
use ReflectionException;
use Swoft\Log\Helper\CLog;
use Throwable;

/**
 * @\Swoft\Bean\Annotation\Mapping\Bean()
 */
class DefaultMessageHandlerDomainImpl implements DefaultMessageHandlerDomain
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
     * @\Swoft\Bean\Annotation\Mapping\Inject()
     *
     * @var \App\Assign\Domain\AssignQueue
     */
    protected AssignQueue $assignQueue;

    /**
     * 文件消息
     *
     * @param int                                     $enterpriseId
     * @param int                                     $platformId
     * @param \EasyWeChat\OfficialAccount\Application $application
     *
     * @throws \EasyWeChat\Kernel\Exceptions\InvalidArgumentException
     * @throws ReflectionException
     */
    public function defaultMessage(int $enterpriseId, int $platformId, Application $application): void
    {
        $application->server->push(function ($message) use ($enterpriseId, $platformId, $application) {

            // 查找用户是否存在
            $user = $this->userQueryRepository->findByOpenid($message['FromUserName']);

            // 如果存在则，更新所属的客服
            if ($user && !$user['customer_id']) {
                try {
                    // 这里是通过分粉的机制来分粉
                    $customerId = $this->assignQueue->popQueue($platformId);
                } catch (Throwable $e) {
                    $customerId = 0;
                    CLog::error('AssignQueue Error: %s', $e->getMessage());
                }

                $attributes = [
                    'platform_id' => $platformId,
                    'customer_id' => $customerId,
                    // todo 关联客服信息
                    // 'customer'   =>  $customer;
                ];
                $this->userCommandRepository->updateByOpenid($message['FromUserName'], $attributes);
            }

            // 如果不存在，则创建
            if (count($user) === 0) {
                // 当用户信息不存在数据库时
                try {
                    $attributes =  (array)$application->user->get($message['FromUserName']);

                    // 这里是通过分粉的机制来分粉
                    $customerId = $this->assignQueue->popQueue($platformId);
                } catch (Throwable $e) {
                    $customerId = 0;
                    CLog::error('AssignQueue Error: %s', $e->getMessage());
                }

                // 企业信息
                $attributes['enterprise_id'] = $enterpriseId;

                // todo 关联客服信息
                $attributes['customer_id'] = $customerId;
                // $attributes['customer']    = ''

                // 记录用户信息
                $this->userCommandRepository->addUserFromWeChat($attributes);
            }
        }, Message::ALL);
    }
}
