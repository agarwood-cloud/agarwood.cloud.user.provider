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
     * @param int $tencentId
     * @param array  $filter
     *
     * @return array
     */
    public function customerList(int $tencentId, array $filter): array
    {
        return $this->dao->customerList($tencentId, $filter);
    }

    /**
     * 圈粉的数量
     *
     * @param int $tencentId
     * @param array  $customerId
     * @param string $startAt
     * @param string $endAt
     *
     * @return array
     */
    public function obtainFans(int $tencentId, array $customerId, string $startAt, string $endAt): array
    {
        return $this->dao->obtainFans($tencentId, $customerId, $startAt, $endAt);
    }

    /**
     * 总粉丝数量，包括取消关注的
     *
     * @param int $tencentId
     * @param array  $customerId
     * @param string $startAt
     * @param string $endAt
     *
     * @return array
     */
    public function fans(int $tencentId, array $customerId, string $startAt, string $endAt): array
    {
        return $this->dao->fans($tencentId, $customerId, $startAt, $endAt);
    }

    /**
     * 取关的人粉丝
     *
     * @param int $tencentId
     * @param array  $customerId
     * @param string $startAt
     * @param string $endAt
     *
     * @return array
     */
    public function unsubscribe(int $tencentId, array $customerId, string $startAt, string $endAt): array
    {
        return $this->dao->unsubscribe($tencentId, $customerId, $startAt, $endAt);
    }

    /**
     * 在xx 时间段内 关注 且 有成交 的粉丝的 openid
     *
     * @param int $tencentId
     * @param array  $customerId
     * @param array  $openid
     * @param string $startAt
     * @param string $endAt
     *
     * @return array
     */
    public function salesNewFansOpenid(int $tencentId, array $customerId, array $openid, string $startAt, string $endAt): array
    {
        return $this->dao->salesNewFansOpenid($tencentId, $customerId, $openid, $startAt, $endAt);
    }

    /**
     * 在xx 时间段内 关注 且 有成交 的粉丝的数量
     *
     * @param int $tencentId
     * @param array  $customerId
     * @param array  $openid
     * @param string $startAt
     * @param string $endAt
     *
     * @return array
     */
    public function newFansCash(int $tencentId, array $customerId, array $openid, string $startAt, string $endAt): array
    {
        return $this->dao->newFansCash($tencentId, $customerId, $openid, $startAt, $endAt);
    }
}
