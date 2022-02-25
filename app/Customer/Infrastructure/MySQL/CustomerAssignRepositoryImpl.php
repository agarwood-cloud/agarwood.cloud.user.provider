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
use App\Customer\Domain\Aggregate\Entity\CustomerCompetitive;
use App\Customer\Domain\Aggregate\Entity\CustomerCompetitiveDepartment;
use App\Customer\Domain\Aggregate\Entity\CustomerGroup;
use App\Customer\Domain\Aggregate\Entity\User;
use App\Customer\Domain\Aggregate\Repository\CustomerAssignRepository;
use Swoft\Db\DB;

/**
 * @\Swoft\Bean\Annotation\Mapping\Bean()
 */
class CustomerAssignRepositoryImpl implements CustomerAssignRepository
{
    /**
     * 客服5天内新粉的数量
     *
     * @param int    $id
     * @param string $startAt
     * @param string $endAt
     *
     * @return int
     */
    public function daysFans(int $id, string $startAt, string $endAt): int
    {
        $builder = DB::table(User::tableName())
            ->selectRaw('count(`openid`) as `fansCount`')
            ->where('customer_id', '=', $id)
            ->whereBetween('created_at', [$startAt, $endAt])
            ->whereIn('subscribe', ['subscribe', 'unsubscribe'])
            ->firstArray();

        return $builder['fansCount'];
    }

    /**
     * 获取客服的信息
     *
     * @param int $id
     *
     * @return array
     */
    public function getCustomer(int $id): array
    {
        return DB::table(Customer::tableName())
            ->select()
            ->where('id', '=', $id)
            ->firstArray();
    }

    /**
     * 抢粉数量
     *
     * @param int $customerId
     * @param string $startAt
     * @param string $endAt
     *
     * @return array
     */
    public function obtainFans(int $customerId, string $startAt, string $endAt): array
    {
        return DB::table(User::tableName())
            ->selectRaw('COUNT(`openid`) as `customerObtainFans`')
            ->where('customer_id', '=', $customerId)
            //这里做关注时间也可以统计未关注的，因为关注时间取关后不会消失的
            ->whereBetween('subscribe_at', [$startAt, $endAt])
            ->whereBetween('created_at', [$startAt, $endAt])
            ->limit(1)
            ->firstArray();
    }

    /**
     * 查找可用的该公众号的客服
     *
     * @param int $tencentId
     *
     * @return array
     */
    public function getCustomerUuidByServiceUuid(int $tencentId): array
    {
        // 优先查找有设置分组的
        $customerIds = DB::table(CustomerCompetitive::tableName())
            ->select('customer_id as id')
            ->where('service_id', '=', $tencentId)
            ->where('status', '=', 'usable')
            ->get()
            ->toArray();

        if ($customerIds) {
            return $customerIds;
        }

        // 如果没有设置，再随机分配
        return DB::table(Customer::tableName())
            ->select('id')
            ->where('service_id', '=', $tencentId)
            ->where('status', '=', 'usable')
            ->get()
            ->toArray();
    }

    /**
     * 查找所在的部门
     *
     * @param string $ids
     *
     * @return array
     */
    public function getCustomerDepartment(string $ids): array
    {
        return DB::table(Customer::tableName())
            ->select(CustomerCompetitiveDepartment::tableName() . '.id')
            ->join(CustomerGroup::tableName(), Customer::tableName() . '.group_id', '=', CustomerGroup::tableName() . '.id')
            ->join(CustomerCompetitiveDepartment::tableName(), CustomerCompetitiveDepartment::tableName() . '.id', '=', CustomerGroup::tableName() . '.department_id')
            ->whereIn(Customer::tableName() . '.id', explode(',', $ids))
            ->pluck(CustomerCompetitiveDepartment::tableName() . '.id')
            ->toArray();
    }
}
