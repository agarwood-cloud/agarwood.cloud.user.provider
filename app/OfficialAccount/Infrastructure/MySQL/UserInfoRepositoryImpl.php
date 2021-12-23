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

use App\OfficialAccount\Domain\Aggregate\Entity\UserInfo;
use App\OfficialAccount\Domain\Aggregate\Repository\UserInfoRepository;
use Carbon\Carbon;
use Agarwood\Core\Constant\StringConstant;
use Godruoyi\Snowflake\Snowflake;
use Swoft\Db\DB;
use Swoft\Db\Exception\DbException;

/**
 * @\Swoft\Bean\Annotation\Mapping\Bean()
 */
class UserInfoRepositoryImpl implements UserInfoRepository
{
    /**
     * 列表数据
     *
     * @param array $filter
     *
     * @return array
     * @throws DbException
     */
    public function index(array $filter): array
    {
        return DB::table(UserInfo::tableName())
            ->selectRaw(
                '`openid`,
                `city`,
                `country`,
                `province`,
                `language`,
                `remark`,
                `tag_id_list` as `tagIdList`,
                `phone`,
                `birthday`,
                `created_at` as `createdAt`'
            )
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
        return DB::table(UserInfo::tableName())
            ->insert($attributes);
    }

    /**
     * 删除
     *
     * @param string $openid
     *
     * @return int
     */
    public function delete(string $openid): int
    {
        return DB::table(UserInfo::tableName())
            ->where('deleted_at', '=', StringConstant::DATE_TIME_DEFAULT)
            ->whereIn('openid', explode(',', $openid))
            ->update(['deleted_at' => Carbon::now()->toDateTimeString()]);
    }

    /**
     * @param string $openid
     * @param array  $attributes
     *
     * @return int
     */
    public function update(string $openid, array $attributes): int
    {
        return DB::table(UserInfo::tableName())
            ->where('deleted_at', '=', StringConstant::DATE_TIME_DEFAULT)
            ->where('openid', '=', $openid)
            ->update($attributes);
    }

    /**
     * @param string $openid
     *
     * @return array
     */
    public function view(string $openid): array
    {
        return DB::table(UserInfo::tableName())
            ->where('deleted_at', '=', StringConstant::DATE_TIME_DEFAULT)
            ->where('openid', '=', $openid)
            ->firstArray();
    }

    /**
     * 检查用户是否存在
     *
     * @param string $openid
     *
     * @return array
     */
    public static function findOpenid(string $openid): array
    {
        return DB::table(UserInfo::tableName())
            ->where('openid', '=', $openid)
            ->firstArray();
    }
}
