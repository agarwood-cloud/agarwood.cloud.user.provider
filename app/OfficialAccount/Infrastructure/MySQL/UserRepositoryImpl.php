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

use Agarwood\Core\Constant\StringConstant;
use App\OfficialAccount\Domain\Aggregate\Entity\User;
use App\OfficialAccount\Domain\Aggregate\Repository\UserRepository;
use Carbon\Carbon;
use Godruoyi\Snowflake\Snowflake;
use Swoft\Db\DB;

/**
 * @\Swoft\Bean\Annotation\Mapping\Bean()
 */
class UserRepositoryImpl implements UserRepository
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
        return DB::table(User::tableName())
            ->insert($attributes);
    }

    /**
     * Delete User Table Data
     *
     * @param string $openid
     *
     * @return int
     */
    public function delete(string $openid): int
    {
        return DB::table(User::tableName())
            ->where('deleted_at', '=', StringConstant::DATE_TIME_DEFAULT)
            ->whereIn('openid', explode(',', $openid))
            ->update(['deleted_at' => Carbon::now()->toDateTimeString()]);
    }

    /**
     * Update Data
     *
     * @param string $openid
     * @param array  $attributes
     *
     * @return int
     */
    public function update(string $openid, array $attributes): int
    {
        return User::where([
            ['deleted_at', '=', StringConstant::DATE_TIME_DEFAULT],
            ['openid', '=', $openid],
        ])->update($attributes);
    }

    /**
     * View
     *
     * @param string $openid
     *
     * @return array
     */
    public function view(string $openid): array
    {
        return DB::table(User::tableName())
        ->where('deleted_at', '=', StringConstant::DATE_TIME_DEFAULT)
        ->where('openid', '=', $openid)
        ->firstArray();
    }

    /**
     * check has user
     *
     * @param string $openid
     *
     * @return array
     */
    public function findOpenid(string $openid): array
    {
        return DB::table(User::tableName())
            ->where('openid', '=', $openid)
            ->firstArray();
    }

    /**
     * 粉丝列表数据
     *
     * @param array $filter
     *
     * @return array
     */
    public function indexV3(array $filter): array
    {
        return DB::table(User::tableName())
            ->select(
                'customer_id as customerId',
                'head_img_url as headImgUrl',
                'nickname',
                'openid'
            )
            ->whereIn('openid', $filter['openid'])
            ->orderByDesc('id')
            ->paginate($filter['page'], $filter['per_page']);
    }

    /**
     * 查找用户信息
     *
     * @param string $openid
     *
     * @return array
     */
    public function findByOpenid(string $openid): array
    {
        return DB::table(User::tableName())
            ->where('openid', '=', $openid)
            ->firstArray();
    }
}
