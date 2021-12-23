<?php declare(strict_types=1);
/**
 * This file is part of Agarwood Cloud.
 *
 * @link     https://www.agarwood-cloud.com
 * @document https://www.agarwood-cloud.com/docs
 * @contact  676786620@qq.com
 * @author   agarwood
 */

namespace App\Assign\Infrastructure\MySQL;

use App\Assign\Domain\Aggregate\Entity\CustomerCompetitive;
use App\Assign\Domain\Aggregate\Entity\CustomerObtainFans;
use App\Assign\Domain\Aggregate\Repository\AssignRepository;
use App\Customer\Domain\Aggregate\Entity\Customer;
use App\Customer\Domain\Aggregate\Entity\CustomerCompetitiveDepartment;
use App\Customer\Domain\Aggregate\Entity\CustomerGroup;
use App\OfficialAccount\Domain\Aggregate\Entity\User;
use Swoft\Db\DB;

/**
 *
 * @\Swoft\Bean\Annotation\Mapping\Bean()
 */
class AssignRepositoryImpl implements AssignRepository
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
     * @param int    $customerId
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
     * @param int $officialAccountId
     *
     * @return array
     */
    public function getCustomerUuidByServiceUuid(int $officialAccountId): array
    {
        // 优先查找有设置分组的
        $customerIds = DB::table(CustomerCompetitive::tableName())
            ->select('customer_id as id')
            ->where('service_id', '=', $officialAccountId)
            ->where('status', '=', 'usable')
            ->get()
            ->toArray();

        if ($customerIds) {
            return $customerIds;
        }

        // 如果没有设置，再随机分配
        return DB::table(Customer::tableName())
            ->select('id')
            ->where('service_id', '=', $officialAccountId)
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

    /**
     * 某个时间段内圈粉数量
     *
     * @param int    $customerId
     * @param string $startAt
     * @param string $endAt
     *
     * @return int
     */
    public function obtainFansBetweenTime(int $customerId, string $startAt, string $endAt): int
    {
        return DB::table(CustomerObtainFans::tableName())
            ->where('customer_id', '=', $customerId)
            ->whereBetween('created_at', [$startAt, $endAt])
            ->count();
    }

    /**
     * 部门在某个时间段内圈粉数量
     *
     * @param int    $departmentId
     * @param string $startAt
     * @param string $endAt
     *
     * @return int
     */
    public function obtainFansBetweenTimeByDepartment(int $departmentId, string $startAt, string $endAt): int
    {
        return DB::table(CustomerObtainFans::tableName())
            ->where('department_id', '=', $departmentId)
            ->whereBetween('created_at', [$startAt, $endAt])
            ->count();
    }

    /**
     * 查找该公众号最后一个抢粉的信息
     *
     * @param int $officialAccountId
     *
     * @return array
     */
    public function lastOfficialAccountObtainFans(int $officialAccountId): array
    {
        // select *
        // from `user_center_customer_obtain_fans` as `user_center_co`
        //         left join `user_center_customer_competitive_department` as `user_center_ccd`
        //                   on `user_center_co`.`department_id` = `user_center_ccd`.`id`
        // where `user_center_co`.`service_id` = '52ad3f27-f47c-47b1-a240-5cec30fe6086'
        //  and `user_center_co`.`obtain_status` = 'obtain'
        //  and `user_center_co`.`department_id` != ''
        //  and `user_center_ccd`.`rate` > 0
        // order by `user_center_co`.`id` desc
        // limit 1
        return DB::table(CustomerObtainFans::tableName() . ' as co')
            ->select('co.rate', 'co.department_id')
            ->leftJoin(CustomerCompetitiveDepartment::tableName() . ' as ccd', 'co.department_id', '=', 'ccd.id')
            ->where('co.service_id', '=', $officialAccountId)
            ->where('co.obtain_status', '=', 'obtain')
            ->where('co.department_id', '!=', '')
            ->where('ccd.rate', '>', 0)
            ->orderByDesc('co.id')
            ->firstArray();
    }

    /**
     * 查找部门最后一个抢粉的信息
     *
     * @param int $departmentId
     *
     * @return array
     */
    public function lastDepartmentObtainFans(int $departmentId): array
    {
        return DB::table(CustomerObtainFans::tableName())
            ->where('department_id', '=', $departmentId)
            ->where('obtain_status', '=', 'obtain')
            ->orderByDesc('id')
            ->firstArray();
    }
}
