<?php declare(strict_types=1);
/**
 * This file is part of Agarwood Cloud.
 *
 * @link     https://www.agarwood-cloud.com
 * @document https://www.agarwood-cloud.com/docs
 * @contact  676786620@qq.com
 * @author   agarwood
 */

namespace App\Assign\Domain\Impl;

use App\Assign\Domain\Aggregate\Enum\AssignEnum;
use App\Assign\Domain\Aggregate\Repository\CompetitiveRepository;
use App\Assign\Domain\AssignQueue;
use App\Assign\Domain\BaseAssignStrategy;
use App\Assign\Domain\CompetePower;
use Agarwood\Core\Exception\BusinessException;
use Swoft\Redis\Redis;

/**
 * @\Swoft\Bean\Annotation\Mapping\Bean()
 */
class AssignQueueImpl implements AssignQueue
{
    /**
     * @\Swoft\Bean\Annotation\Mapping\Inject()
     *
     * @var \App\Assign\Domain\BaseAssignStrategy
     */
    protected BaseAssignStrategy $baseAssignStrategy;

    /**
     * @\Swoft\Bean\Annotation\Mapping\Inject()
     *
     * @var \App\Assign\Domain\CompetePower
     */
    protected CompetePower $competePower;

    /**
     * @\Swoft\Bean\Annotation\Mapping\Inject()
     *
     * @var CompetitiveRepository $competitiveRepository
     */
    protected CompetitiveRepository $competitiveRepository;

    /**
     * @inheritDoc
     */
    public function pushQueue(int $officialAccountId, int $customerId): void
    {
        // 可以设置多种分配客户的方法
        $power = $this->competePower->computedPower($customerId);

        // 查找规则
        $customer = $this->competitiveRepository->findByCustomerUuid($customerId);

        // 如果不存在该账号，则直接抛出错误; 如果被限制进粉，则不允许分配粉丝
        if ((!$customer) || ($customer['status'] === 'disabled')) {
            throw new BusinessException('该账号不存在或者被限制抢粉！');
        }

        // 更新综合竞争力
        $this->competitiveRepository->update($customerId, ['power' => $power]);

        //加入抢粉队列
        $this->baseAssignStrategy->assignList($officialAccountId, $customerId, $customer['custom_power'] ?? $power);

        // 其它的抢粉方式 i.e
    }

    /**
     * @inheritDoc
     */
    public function popQueue(int $officialAccountId): int
    {
        // 可以设置多种分配客户的方法
        return $this->baseAssignStrategy->assignCustomer($officialAccountId);
    }

    /**
     * @inheritDoc
     */
    public function status(int $officialAccountId, int $customerId): bool
    {
        return Redis::sIsMember(AssignEnum::OFFICIAL_ACCOUNTS_ONLINE_LIST . $officialAccountId, (string)$customerId);
    }

    /**
     * @inheritDoc
     */
    public function pushSetsStatus(int $officialAccountId, int $customerId): void
    {
        Redis::sAdd(AssignEnum::OFFICIAL_ACCOUNTS_ONLINE_LIST . $officialAccountId, (string)$customerId);
    }

    /**
     * @inheritDoc
     */
    public function popSetsStatus(int $officialAccountId, int $customerId): int
    {
        return Redis::sRem(AssignEnum::OFFICIAL_ACCOUNTS_ONLINE_LIST . $officialAccountId, (string)$customerId);
    }
}
