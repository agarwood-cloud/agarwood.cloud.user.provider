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
use App\Customer\Domain\Aggregate\Entity\CustomerCompetitiveDepartment;
use App\Customer\Domain\Aggregate\Entity\CustomerGroup;
use App\Customer\Domain\Aggregate\Repository\DepartmentRepository;
use Godruoyi\Snowflake\Snowflake;
use Swoft\Db\DB;
use Swoft\Db\Exception\DbException;

/**
 * @\Swoft\Bean\Annotation\Mapping\Bean()
 */
class DepartmentRepositoryImpl implements DepartmentRepository
{
    /**
     * 管理员管理列表数据
     *
     * @param int   $officialAccountId
     * @param array $filter
     * @param bool  $isPagination
     *
     * @return array
     */
    public function index(int $officialAccountId, array $filter, bool $isPagination): array
    {
        return DB::table(CustomerCompetitiveDepartment::tableName())
            ->select(
                'id',
                'department',
                'status',
                'leader',
                'service_id as serviceUuid',
                'day_assign as dayAssign',
                'month_assign as monthAssign',
                'sort',
                'rate',
                'created_at as createdAt',
                'updated_at as updatedAt'
            )
            ->where('service_id', '=', $officialAccountId)
            ->when($filter['department'], function ($query, $department) {
                return $query->where('department', 'like', '%' . $department . '%');
            })
            ->when($filter['leader'], function ($query, $leader) {
                return $query->where('leader', 'like', '%' . $leader . '%');
            })
            ->when($filter['status'], function ($query, $status) {
                return $query->where('status', '=', $status);
            })
            ->paginate($filter['page'], $filter['per_page']);
    }

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

        return DB::table(CustomerCompetitiveDepartment::tableName())
            ->insert($attributes);
    }

    /**
     * 更新
     *
     * @param int   $id
     * @param array $attributes
     *
     * @return int
     */
    public function update(int $id, array $attributes): int
    {
        return DB::table(CustomerCompetitiveDepartment::tableName())
            ->where('id', '=', $id)
            ->update($attributes);
    }

    /**
     * 查找是否存在
     *
     * @param int $id
     *
     * @return array
     * @throws DbException
     */
    public function findByCustomerUuid(int $id): array
    {
        return DB::table(CustomerCompetitiveDepartment::tableName())
            ->select(CustomerCompetitiveDepartment::tableName() . '.id', CustomerCompetitiveDepartment::tableName() . '.rate')
            ->join(CustomerGroup::tableName(), CustomerCompetitiveDepartment::tableName() . '.id', '=', CustomerGroup::tableName() . '.department_id')
            ->join(Customer::tableName(), Customer::tableName() . '.group_id', '=', CustomerGroup::tableName() . '.id')
            ->where(Customer::tableName() . '.id', '=', $id)
            ->groupBy([Customer::tableName() . '.id'])
            ->firstArray();
    }

    /**
     * 修改状态
     *
     * @param array $ids
     * @param array $attributes
     *
     * @return int
     */
    public function changeStatus(array $ids, array $attributes): int
    {
        return DB::table(CustomerCompetitiveDepartment::tableName())
            ->whereIn('id', $ids)
            ->update($attributes);
    }

    /**
     * 查找该分配粉丝的部门及相关参数部
     *      Tips: 门分配粉丝为0的，不分配粉丝
     *
     * @param int $officialAccountId
     *
     * @return array
     */
    public function getDepartments(int $officialAccountId): array
    {
        //  select *
        //      from `user_center_customer_competitive_department`
        //  where `service_id` = '52ad3f27-f47c-47b1-a240-5cec30fe6086'
        //  and `rate` > 0
        //  order by `sort` asc
        return DB::table(CustomerCompetitiveDepartment::tableName())
            ->where('service_id', '=', $officialAccountId)
            ->where('rate', '>', 0) // 进粉速率必须0
            ->where('status', '=', 'usable')
            ->orderBy('sort')
            ->get()
            ->toArray();
    }

    /**
     * 所有的部门，包括不抢粉的部门
     *
     * @param int $officialAccountId
     *
     * @return array
     */
    public function getAllDepartments(int $officialAccountId): array
    {
        return DB::table(CustomerCompetitiveDepartment::tableName())
            ->where('service_id', '=', $officialAccountId)
            // ->where('rate', '>', 0) // 进粉速率必需大于0
            ->where('status', '=', 'usable')
            ->orderBy('sort')
            ->get()
            ->toArray();
    }
}
