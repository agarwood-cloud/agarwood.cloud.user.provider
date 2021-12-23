<?php declare(strict_types=1);
/**
 * This file is part of Agarwood Cloud.
 *
 * @link     https://www.agarwood-cloud.com
 * @document https://www.agarwood-cloud.com/docs
 * @contact  676786620@qq.com
 * @author   agarwood
 */

namespace App\Customer\Interfaces\Rpc\Service;

use App\Customer\Domain\Aggregate\Repository\OverviewRpcRepository;
use Agarwood\Rpc\UserCenter\UserCenterCustomerOverviewRpcInterface;
use Swoft\Rpc\Server\Annotation\Mapping\Service;

/**
 * @Service()
 */
class CustomerOverviewService implements UserCenterCustomerOverviewRpcInterface
{
    /**
     * @\Swoft\Bean\Annotation\Mapping\Inject()
     *
     * @var OverviewRpcRepository
     */
    protected OverviewRpcRepository $dao;

    /**
     * 获取所有客服的数据
     *
     * @param int $officialAccountsId
     * @param array  $filter
     *
     * @return array
     */
    public function customerList(int $officialAccountsId, array $filter): array
    {
        return $this->dao->customerList($officialAccountsId, $filter);
    }

    /**
     * 圈粉的数量
     *
     * @param int $officialAccountsId
     * @param array  $customerId
     * @param string $startAt
     * @param string $endAt
     *
     * @return array
     */
    public function obtainFans(int $officialAccountsId, array $customerId, string $startAt, string $endAt): array
    {
        return $this->dao->obtainFans($officialAccountsId, $customerId, $startAt, $endAt);
    }

    /**
     * 总粉丝数量，包括取消关注的
     *
     * @param int $officialAccountsId
     * @param array  $customerId
     * @param string $startAt
     * @param string $endAt
     *
     * @return array
     */
    public function fans(int $officialAccountsId, array $customerId, string $startAt, string $endAt): array
    {
        return $this->dao->fans($officialAccountsId, $customerId, $startAt, $endAt);
    }

    /**
     * 取关的人粉丝
     *
     * @param int $officialAccountsId
     * @param array  $customerId
     * @param string $startAt
     * @param string $endAt
     *
     * @return array
     */
    public function unsubscribe(int $officialAccountsId, array $customerId, string $startAt, string $endAt): array
    {
        return $this->dao->unsubscribe($officialAccountsId, $customerId, $startAt, $endAt);
    }

    /**
     * 在xx 时间段内 关注 且 有成交 的粉丝的 openid
     *
     * @param int $officialAccountsId
     * @param array  $customerId
     * @param array  $openid
     * @param string $startAt
     * @param string $endAt
     *
     * @return array
     */
    public function salesNewFansOpenid(int $officialAccountsId, array $customerId, array $openid, string $startAt, string $endAt): array
    {
        return $this->dao->salesNewFansOpenid($officialAccountsId, $customerId, $openid, $startAt, $endAt);
    }

    /**
     * 在xx 时间段内 关注 且 有成交 的粉丝的数量
     *
     * @param int $officialAccountsId
     * @param array  $customerId
     * @param array  $openid
     * @param string $startAt
     * @param string $endAt
     *
     * @return array
     */
    public function newFansCash(int $officialAccountsId, array $customerId, array $openid, string $startAt, string $endAt): array
    {
        return $this->dao->newFansCash($officialAccountsId, $customerId, $openid, $startAt, $endAt);
    }
}
