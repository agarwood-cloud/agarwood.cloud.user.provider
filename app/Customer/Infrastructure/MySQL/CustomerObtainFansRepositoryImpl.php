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

use App\Customer\Domain\Aggregate\Entity\CustomerCompetitiveDepartment;
use App\Customer\Domain\Aggregate\Entity\CustomerObtainFans;
use App\Customer\Domain\Aggregate\Repository\CustomerObtainFansRepository;
use Godruoyi\Snowflake\Snowflake;
use Swoft\Db\DB;

/**
 * @\Swoft\Bean\Annotation\Mapping\Bean()
 */
class CustomerObtainFansRepositoryImpl implements CustomerObtainFansRepository
{
    /**
     * 创建
     *
     * @param array $attributes
     *
     * @return bool
     */
    public function create(array $attributes): bool
    {
        $snowflake        = new Snowflake;
        $attributes['id'] = (int)$snowflake->id();

        return DB::table(CustomerObtainFans::tableName())
            ->insert($attributes);
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
            ->where('customer_uuid', '=', $customerId)
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
            ->where('department_uuid', '=', $departmentId)
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
        //                   on `user_center_co`.`department_uuid` = `user_center_ccd`.`uuid`
        // where `user_center_co`.`service_uuid` = '52ad3f27-f47c-47b1-a240-5cec30fe6086'
        //  and `user_center_co`.`obtain_status` = 'obtain'
        //  and `user_center_co`.`department_uuid` != ''
        //  and `user_center_ccd`.`rate` > 0
        // order by `user_center_co`.`id` desc
        // limit 1
        return DB::table(CustomerObtainFans::tableName() . ' as co')
            ->select('co.rate', 'co.department_uuid')
            ->leftJoin(CustomerCompetitiveDepartment::tableName() . ' as ccd', 'co.department_uuid', '=', 'ccd.uuid')
            ->where('co.service_uuid', '=', $officialAccountId)
            ->where('co.obtain_status', '=', 'obtain')
            ->where('co.department_uuid', '!=', '')
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
            ->where('department_uuid', '=', $departmentId)
            ->where('obtain_status', '=', 'obtain')
            ->orderByDesc('id')
            ->firstArray();
    }
}
