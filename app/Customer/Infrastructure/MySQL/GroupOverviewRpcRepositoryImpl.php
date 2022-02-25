<?php declare(strict_types=1);
/**
 * This file is part of Agarwood Cloud.
 *
 * @link     https://www.agarwood-cloud.com
 * @document https://www.agarwood-cloud.com/docs
 * @contact  676786620@qq.com
 * @author   agarwood
 */

namespace App\Customer\Infrastructure\MySQL;

use App\Customer\Domain\Aggregate\Entity\Customer;
use App\Customer\Domain\Aggregate\Entity\User;
use App\Customer\Domain\Aggregate\Repository\GroupOverviewRpcRepository;
use Swoft\Db\DB;

/**
 * @\Swoft\Bean\Annotation\Mapping\Bean()
 */
class GroupOverviewRpcRepositoryImpl implements GroupOverviewRpcRepository
{
    /**
     * 分组下的所有客服信息
     *
     * @param int   $tencentId
     * @param array $filter
     *
     * @return array
     */
    public function groupForCustomer(int $tencentId, array $filter): array
    {
        return DB::table(Customer::tableName())
            ->select(
                'id as customerId',
                'group_name as groupName',
                'group_id as groupId',
            )
            ->when($filter['group_name'], function ($query, $groupName) {
                return $query->where('group_name', 'like', '%' . $groupName . '%');
            })
            ->where('service_id', '=', $tencentId)
            ->get()
            ->toArray();
    }

    /**
     * 时间段内的新增粉丝
     *
     * @param int    $tencentId
     * @param array  $customerId
     * @param string $startAt
     * @param string $endAt
     *
     * @return array
     */
    public function groupForCustomerOpenid(int $tencentId, array $customerId, string $startAt, string $endAt): array
    {
        return DB::table(User::tableName())
            ->select(
                'customer_id as customerId',
                // 'group_id as groupId', // 这里数据有些问题，group_id 没有记录到
                'openid'
            )
            ->where('service_id', '=', $tencentId)
            ->whereBetween('subscribe_at', [$startAt, $endAt])
            ->whereIn('customer_id', $customerId)
            ->get()
            ->toArray();
    }

    /**
     * 每个小组的新增粉丝数量 【新粉数量】
     *
     * @param int    $tencentId
     * @param array  $customerId
     * @param string $startAt
     * @param string $endAt
     *
     * @return array
     */
    public function groupForNewFansSum(int $tencentId, array $customerId, string $startAt, string $endAt): array
    {
        return DB::table(User::tableName())
            ->select(
                'customer_id as customerId',
                // 'group_id as groupId',
            )
            ->selectRaw('COUNT(`openid`) as newFansNum')
            ->where('service_id', '=', $tencentId)
            ->whereBetween('subscribe_at', [$startAt, $endAt])
            ->whereIn('customer_id', $customerId)
            ->groupBy(['customer_id'])
            ->get()
            ->toArray();
    }

    /**
     * 新粉成交数量
     *
     * @param int    $tencentId
     * @param array  $customerId
     * @param array  $openid
     * @param string $startAt
     * @param string $endAt
     *
     * @return array
     */
    public function groupFromSalesFansSum(int $tencentId, array $customerId, array $openid, string $startAt, string $endAt): array
    {
        return DB::table(User::tableName())
            ->select(
                'customer_id as customerId',
                // 'group_id as groupId',
            )
            ->selectRaw('COUNT(`openid`) as newFansSalesNum')
            ->where('service_id', '=', $tencentId)
            ->whereBetween('subscribe_at', [$startAt, $endAt])
            ->whereIn('customer_id', $customerId)
            ->whereIn('openid', $openid)
            ->groupBy(['customer_id'])
            ->get()
            ->toArray();
    }
}
