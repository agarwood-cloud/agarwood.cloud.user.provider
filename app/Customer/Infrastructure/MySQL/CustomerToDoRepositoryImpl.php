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

use App\Customer\Domain\Aggregate\Entity\CustomerToDo;
use App\Customer\Domain\Aggregate\Repository\CustomerToDoRepository;
use Carbon\Carbon;
use Agarwood\Core\Constant\StringConstant;
use Godruoyi\Snowflake\Snowflake;
use Swoft\Db\DB;

/**
 * @\Swoft\Bean\Annotation\Mapping\Bean()
 */
class CustomerToDoRepositoryImpl implements CustomerToDoRepository
{
    /**
     * 列表数据
     *
     * @param int   $tencentId
     * @param int   $customerId
     * @param array $filter
     *
     * @return array
     */
    public function index(int $tencentId, int $customerId, array $filter): array
    {
        return DB::table(CustomerToDo::tableName())
            ->select(
                'uuid',
                'content',
                'openid',
                'nickname',
                'customer_uuid as customerId',
                'deadline_at as deadlineAt',
                'created_at as createdAt',
                'updated_at as updatedAt',
                'remark'
            )
            ->orderBy('deadline_at')
            ->where('service_uuid', '=', $tencentId)
            ->where('customer_uuid', '=', $customerId)
            ->when($filter['status'], function ($query, $status) {
                return $query->where('status', '=', $status);
            })
            ->where('deleted_at', '=', StringConstant::DATE_TIME_DEFAULT)  // 未删除
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

        return DB::table(CustomerToDo::tableName())
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
        return DB::table(CustomerToDo::tableName())
            ->where('deleted_at', '=', StringConstant::DATE_TIME_DEFAULT)
            ->whereIn('id', explode(',', $ids))
            ->update(['deleted_at' => Carbon::now()->toDateTimeString()]);
    }

    /**
     * @param int   $id
     * @param array $attributes
     *
     * @return int
     */
    public function update(int $id, array $attributes): int
    {
        return DB::table(CustomerToDo::tableName())
            ->where('id', '=', $id)
            ->where('deleted_at', '=', StringConstant::DATE_TIME_DEFAULT)
            ->update($attributes);
    }

    /**
     * 关联粉丝的跟进事项
     *
     * @param string $openid
     *
     * @return array
     */
    public function toDoListEvent(string $openid): array
    {
        return DB::table(CustomerToDo::tableName())
            ->select()
            ->where('openid', '=', $openid)
            ->get()
            ->toArray();
    }
}
