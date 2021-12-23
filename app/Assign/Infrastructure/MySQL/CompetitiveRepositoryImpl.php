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
use App\Assign\Domain\Aggregate\Repository\CompetitiveRepository;
use App\Customer\Domain\Aggregate\Entity\Customer;
use Godruoyi\Snowflake\Snowflake;
use Swoft\Db\DB;

/**
 * @\Swoft\Bean\Annotation\Mapping\Bean()
 */
class CompetitiveRepositoryImpl implements CompetitiveRepository
{
    /**
     * 管理员管理列表数据
     *
     * @param int   $officialAccountId
     * @param array $filter
     *
     * @return array
     */
    public function index(int $officialAccountId, array $filter): array
    {
        return DB::table(Customer::tableName() . ' as c')
            ->select(
                'co.id',
                'c.account',
                'c.id as customerId',
                'c.name',
                'co.power',
                'co.custom_power as customPower',
                'co.status',
                'co.base_fans as baseFans',
                'co.fans_price as fansPrice',
                'co.day_assign as dayAssign',
                'co.month_assign as monthAssign',
                'co.created_at as createdAt',
                'co.updated_at as updateAt',
                'co.cost',
                'co.profit_rate as profitRate'
            )
            ->leftJoin(CustomerCompetitive::tableName() . ' as co', 'c.id', '=', 'co.customer_id')
            ->where('c.service_id', '=', $officialAccountId)
            ->when($filter['name'], function ($query, $name) {
                return $query->where('name', 'like', '%' . $name . '%');
            })
            ->when($filter['account'], function ($query, $account) {
                return $query->where('name', 'like', '%' . $account . '%');
            })
            ->when($filter['status'], function ($query, $status) {
                return $query->where('status', 'like', '%' . $status . '%');
            })
            ->orderByDesc('co.power')
            ->groupBy(['c.id'])
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
        return DB::table(CustomerCompetitive::tableName())
            ->insert($attributes);
    }

    /**
     * @param int   $id
     * @param array $attributes
     *
     * @return int|null
     */
    public function update(int $id, array $attributes): ?int
    {
        // 以下更新支持null 值操作
        return DB::table(CustomerCompetitive::tableName())
            ->where('customer_id', '=', $id)
            ->update($attributes);
    }

    /**
     * @param int   $id
     * @param array $attributes
     *
     * @return int
     */
    public function changeStatus(int $id, array $attributes): int
    {
        return DB::table(CustomerCompetitive::tableName())
            ->where('id', '=', $id)
            ->update($attributes);
    }

    /**
     * @param int $id
     *
     * @return array
     */
    public function findByCustomerUuid(int $id): array
    {
        return DB::table(CustomerCompetitive::tableName())
            ->where('customer_id', '=', $id)
            ->firstArray();
    }
}
