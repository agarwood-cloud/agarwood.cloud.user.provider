<?php declare(strict_types=1);
/**
 * This file is part of Agarwood Cloud.
 *
 * @link     https://www.agarwood-cloud.com
 * @document https://www.agarwood-cloud.com/docs
 * @contact  676786620@qq.com
 * @author   agarwood
 */

namespace App\OfficialAccount\Infrastructure\MySQL;

use App\OfficialAccount\Domain\Aggregate\Entity\Customer;
use App\OfficialAccount\Domain\Aggregate\Entity\CustomerObtainFans;
use App\OfficialAccount\Domain\Aggregate\Entity\User;
use Agarwood\Core\Constant\StringConstant;
use Swoft\Db\DB;

/**
 * @\Swoft\Bean\Annotation\Mapping\Bean()
 *
 */
class OverviewRpcRepository
{
    /**
     * 获取所有的客服数据
     *
     * @param int $officialAccountId
     * @param array  $filter
     *
     * @return array
     */
    public function customerList(int $officialAccountId, array $filter): array
    {
        return DB::table(Customer::tableName())
            ->select(
                'uuid',
                'name',
                'account',
                'phone',
                'status',
                'service_uuid as serviceUuid',
                'group_name as groupName',
                'group_uuid as groupUuid',
                'created_at as createdAt',
                'updated_at as updatedAt'
            )
            ->where('service_uuid', '=', $officialAccountId)
            ->where('deleted_at', '=', StringConstant::DATE_TIME_DEFAULT)
            ->when($filter['name'], function ($query, $name) {
                return $query->where('name', 'like', '%' . $name . '%');
            })
            ->when($filter['account'], function ($query, $account) {
                return $query->where('account', 'like', '%' . $account . '%');
            })
            ->get()
            ->toArray();
    }

    /**
     * 抢粉的数量，按客服分组
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
        return DB::table(CustomerObtainFans::tableName())
            ->selectRaw(
                'COUNT(`id`) as `obtainFansNum`,
                `customer_uuid` as `customerUuid`,
                `service_uuid` as `serviceUuid`'
            )
            ->where('service_uuid', '=', $tencentId)
            ->whereBetween('created_at', [$startAt, $endAt])
            ->whereIn('customer_uuid', $customerId)
            ->groupBy(['customer_uuid'])
            ->get()
            ->toArray();
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
        return DB::table(User::tableName())
            ->selectRaw(
                '`customer_uuid` as `customerUuid`,
                `service_uuid` as `serviceUuid`,
                COUNT(`id`) as `fansNum`'
            )
            ->where('service_uuid', '=', $tencentId)
            //这里做关注时间也可以统计未关注的，因为关注时间取关后不会消失的
            ->whereBetween('subscribe_at', [$startAt, $endAt])
            ->whereIn('customer_uuid', $customerId)
            ->groupBy(['customer_uuid'])
            ->get()
            ->toArray();
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
        return DB::table(User::tableName())
            ->selectRaw(
                '`customer_uuid` as `customerUuid`,
                `service_uuid` as `serviceUuid`,
                COUNT(`id`) as `unsubFansNum`'
            )
            ->where('service_uuid', '=', $tencentId)
            //取消关注的时间
            ->whereBetween('unsubscribed_at', [$startAt, $endAt])
            ->whereIn('customer_uuid', $customerId)
            ->groupBy(['customer_uuid'])
            ->get()
            ->toArray();
    }

    /**
     * 在xx时间段内关注且有成交的粉丝的openid
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
        return DB::table(User::tableName())
            ->select(
                'openid',
                'customer_uuid as customerUuid'
            )
            ->where('service_uuid', '=', $tencentId)
            ->whereIn('openid', $openid)
            ->whereIn('customer_uuid', $customerId)
            ->whereBetween('subscribe_at', [$startAt, $endAt])
            ->get()
            ->toArray();
    }

    /**
     * 在xx时间段内有成交的粉丝的数量
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
        return DB::table(User::tableName())
            ->selectRaw(
                'COUNT(`openid`) as `newFansCashNum`,
                `customer_uuid` as `customerUuid`'
            )
            ->where('service_uuid', '=', $tencentId)
            ->whereIn('openid', $openid)
            ->whereIn('customer_uuid', $customerId)
            ->whereBetween('subscribe_at', [$startAt, $endAt])
            ->groupBy(['customer_uuid'])
            ->get()
            ->toArray();
    }
}
