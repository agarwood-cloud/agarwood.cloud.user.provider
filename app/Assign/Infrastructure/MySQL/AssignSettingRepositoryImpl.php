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
use App\Assign\Domain\Aggregate\Entity\CustomerCompetitiveDepartment;
use App\Assign\Domain\Aggregate\Entity\CustomerGroup;
use App\Assign\Domain\Aggregate\Entity\CustomerObtainFans;
use App\Assign\Domain\Aggregate\Repository\AssignSettingRepository;
use Agarwood\Core\Constant\StringConstant;
use Godruoyi\Snowflake\Snowflake;
use Swoft\Db\DB;

/**
 * @\Swoft\Bean\Annotation\Mapping\Bean()
 */
class AssignSettingRepositoryImpl implements AssignSettingRepository
{
    /**
     * 记录抢粉的信息
     *
     * @param int $platformId
     * @param int $customerId
     * @param string $openid
     * @param string $obtainStatus
     *
     * @return bool
     */
    public function recordAssignFans(int $platformId, int $customerId, string $openid, string $obtainStatus = 'obtain'): bool
    {
        $snowflake                   = new Snowflake;
        $attributes['id']            = (int)$snowflake->id();
        $attributes['platform_id']   = $platformId;
        $attributes['customer_id']   = $customerId;
        $attributes['openid']        = $openid;
        $attributes['obtain_status'] = $obtainStatus;

        return DB::table(CustomerObtainFans::tableName())
            ->insert($attributes);
    }

    /**
     * 是否已设置抢粉的信息
     *
     * @param int $customerId
     *
     * @return array
     */
    public function hasSettingAssign(int $customerId): array
    {
        return DB::table(CustomerCompetitive::tableName())
            ->select()
            ->where('customer_id', '=', $customerId)
            ->firstArray();
    }

    /**
     * 查找该分配粉丝的部门及相关参数部
     *      Tips: 门分配粉丝为0的，不分配粉丝
     *
     * @param int $platformId
     *
     * @return array
     */
    public function getDepartments(int $platformId): array
    {
        //  select *
        //      from `user_center_customer_competitive_department`
        //  where `platform_id` = '52ad3f27-f47c-47b1-a240-5cec30fe6086'
        //  and `rate` > 0
        //  order by `sort` asc
        return DB::table(CustomerCompetitiveDepartment::tableName())
            ->where('platform_id', '=', $platformId)
            ->where('rate', '>', 0) // 进粉速率必须0
            ->where('status', '=', 'usable')
            ->orderBy('sort')
            ->get()
            ->toArray();
    }

    /**
     * 组别信息
     *
     * @param string $id
     *
     * @return array
     */
    public function customerGroup(string $id): array
    {
        return DB::table(CustomerGroup::tableName())
            ->select()
            ->where('deleted_at', '=', StringConstant::DATE_TIME_DEFAULT)
            ->where('id', '=', $id)
            ->firstArray();
    }

    /**
     * 抢粉部门设置
     *
     * @param string $id
     *
     * @return array
     */
    public function customerCompetitiveDepartment(string $id): array
    {
        return DB::table(CustomerCompetitiveDepartment::tableName())
            ->where('id', '=', $id)
            ->firstArray();
    }
}
