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

use Agarwood\Core\Constant\StringConstant;
use App\Customer\Domain\Aggregate\Entity\Customer;
use App\Customer\Domain\Aggregate\Repository\CustomerCommandRepository;
use Carbon\Carbon;
use Godruoyi\Snowflake\Snowflake;
use Swoft\Db\DB;

/**
 * @\Swoft\Bean\Annotation\Mapping\Bean()
 */
class CustomerCommandRepositoryImpl implements CustomerCommandRepository
{
    /**
     * 创建客服信息
     *
     * @param int   $platformId
     * @param array $attributes
     *
     * @return bool
     */
    public function create(int $platformId, array $attributes): bool
    {
        // id
        $attributes['platform_id'] = $platformId;

        // 密码加密
        $attributes['password'] = password_hash($attributes['password'], PASSWORD_DEFAULT);

        // 加入id
        $snowflake        = new Snowflake;
        $attributes['id'] = (int)$snowflake->id();

        // 创建时间
        $attributes['created_at'] = Carbon::now()->toDateTimeString();
        $attributes['updated_at'] = Carbon::now()->toDateTimeString();

        return DB::table(Customer::tableName())
            ->insert($attributes);
    }

    /**
     * 删除客服信息
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
     * 更新客服信息
     *
     * @param int   $id
     * @param array $attributes
     *
     * @return int
     */
    public function update(int $id, array $attributes): int
    {
        // 如果有密码，可以加入密码修复的功能
        if (isset($attributes['password'])) {
            $attributes['password'] = password_hash($attributes['password'], PASSWORD_DEFAULT);
        }

        // 更新时间
        $attributes['updated_at'] = Carbon::now()->toDateTimeString();

        return DB::table(Customer::tableName())
            ->where('id', '=', $id)
            ->where('deleted_at', '=', StringConstant::DATE_TIME_DEFAULT)
            ->update($attributes);
    }
}
