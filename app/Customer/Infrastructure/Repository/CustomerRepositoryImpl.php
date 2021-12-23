<?php declare(strict_types=1);
/**
 * This file is part of Agarwood Cloud.
 *
 * @link     https://www.agarwood-cloud.com
 * @document https://www.agarwood-cloud.com/docs
 * @contact  676786620@qq.com
 * @author   agarwood
 */

namespace App\Customer\Infrastructure\Repository;

use App\Customer\Domain\Aggregate\Entity\Customer;
use App\Customer\Domain\Aggregate\Repository\CustomerRepository;
use App\Customer\Interfaces\DTO\Customer\LoginDTO;
use Carbon\Carbon;
use Agarwood\Core\Constant\StringConstant;
use Godruoyi\Snowflake\Snowflake;
use Swoft\Db\DB;

/**
 * @\Swoft\Bean\Annotation\Mapping\Bean()
 */
class CustomerRepositoryImpl implements CustomerRepository
{
    /**
     * 服务号管理列表数据
     *
     * @param array $filter
     * @param int   $officialAccountId
     *
     * @return array
     */
    public function index(int $officialAccountId, array $filter): array
    {
        return DB::table(Customer::tableName())
            ->select(
                'id',
                'account',
                'name',
                'status',
                'service_id as serviceUuid',
                'phone',
                'group_id as groupUuid',
                'group_name as groupName',
                'created_at as createdAt',
                'updated_at as updatedAt'
            )->where('deleted_at', '=', StringConstant::DATE_TIME_DEFAULT)  // 未删除
            ->where('service_id', '=', $officialAccountId)
            ->when($filter['name'], function ($query, $name) {
                return $query->where('name', 'like', '%' . $name . '%');
            })
            ->when($filter['account'], function ($query, $account) {
                return $query->where('account', 'like', '%' . $account . '%');
            })
            ->when($filter['status'], function ($query, $param) {
                return $query->where('status', '=', $param);
            })
            ->when($filter['group_name'], function ($query, $param) {
                return $query->where('group_name', 'like', '%' . $param . '%');
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

        return DB::table(Customer::tableName())
            ->insert($attributes);
    }

    /**
     * 删除
     *
     * @param string $ids
     *
     * @return int
     */
    public function delete(string $ids): int
    {
        return DB::table(Customer::tableName())
            ->where('deleted_at', '=', StringConstant::DATE_TIME_DEFAULT)
            ->whereIn('id', explode(',', $ids))
            ->update(['deleted_at' => Carbon::now()->toDateTimeString()]);
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
        return DB::table(Customer::tableName())
            ->where('id', '=', $id)
            ->where('deleted_at', '=', StringConstant::DATE_TIME_DEFAULT)
            ->update($attributes);
    }

    /**
     * 预览
     *
     * @param int $id
     *
     * @return array
     */
    public function view(int $id): array
    {
        return DB::table(Customer::tableName())
            ->where('id', '=', $id)
            ->where('deleted_at', '=', StringConstant::DATE_TIME_DEFAULT)
            ->firstArray();
    }

    /**
     * 登陆
     *
     * @param LoginDTO $DTO
     *
     * @return array
     */
    public function login(LoginDTO $DTO): array
    {
        return DB::table(Customer::tableName())
            ->select(
                'id',
                'account',
                'name',
                'group_id as groupId',
                'phone',
                'status',
                'service_id as serviceId',
                'group_name as groupName',
                'password'
            )
            ->where('service_id', '=', $DTO->getServiceUuid())
            ->where('account', '=', $DTO->getUsername())
            ->where('status', '=', 'usable')
            ->firstArray();
    }
}
