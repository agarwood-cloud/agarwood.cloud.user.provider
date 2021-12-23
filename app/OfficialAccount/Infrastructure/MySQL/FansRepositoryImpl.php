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

use App\OfficialAccount\Domain\Aggregate\Entity\User;
use App\OfficialAccount\Domain\Aggregate\Repository\FansRepository;
use Agarwood\Core\Constant\StringConstant;
use Swoft\Db\DB;

/**
 * @\Swoft\Bean\Annotation\Mapping\Bean()
 */
class FansRepositoryImpl implements FansRepository
{
    /**
     * 客服对应的粉丝列表
     *
     * @param int   $customerId
     * @param array $filter
     *
     * @return array
     */
    public function index(int $customerId, array $filter): array
    {
        return DB::table(User::tableName())
            ->selectRaw(
                '`openid`,
                `union_id` as `unionId`,
                `customer_id` as `customerId`,
                `customer`,
                `nickname`,
                `head_img_url` as `headImgUrl`,
                `subscribe_at` as `subscribeAt`,
                `unsubscribed_at` as `unsubscribedAt`,
                `subscribe`,
                `subscribe_scene` as `subscribeScene`,
                `created_at` as `createdAt`,
                `updated_at` as `updatedAt`'
            )
            ->where('deleted_at', '=', StringConstant::DATE_TIME_DEFAULT)  // 未删除
            ->where('customer_id', '=', $customerId)
            ->when($filter['nickname'], function ($query, $param) {
                return $query->where('nickname', 'like', '%' . $param . '%');
            })
            ->when($filter['openid'], function ($query, $openid) {
                return $query->whereIn('openid', $openid);
            })
            ->orderByDesc('id')
            ->paginate($filter['page'], $filter['per_page']);
    }

    /**
     * @param string $openid
     * @param array  $attributes
     *
     * @return int
     */
    public function update(string $openid, array $attributes): int
    {
        return DB::table(User::tableName())
            ->where('deleted_at', '=', StringConstant::DATE_TIME_DEFAULT)
            ->where('openid', '=', $openid)
            ->update($attributes);
    }

    /**
     * @param int $id
     *
     * @return array
     */
    public function view(int $id): array
    {
        return DB::table(User::tableName())
            ->where('deleted_at', '=', StringConstant::DATE_TIME_DEFAULT)
            ->where('id', '=', $id)
            ->firstArray();
    }

    /**
     * 客服该分组下的粉丝
     *
     * @param int   $customerId
     * @param array $filter
     *
     * @return array
     */
    public function groupUser(int $customerId, array $filter): array
    {
        return DB::table(User::tableName())
            ->select(
                'openid',
                'union_id as unionId',
                'customer_id as customerId',
                'customer',
                'nickname',
                'head_img_url as headImgUrl',
                'subscribe_at as subscribeAt',
                'unsubscribed_at as unsubscribedAt',
                'subscribe',
                'subscribe_scene as subscribeScene',
                'created_at as createdAt',
                'updated_at as updatedAt'
            )
            ->where('deleted_at', '=', StringConstant::DATE_TIME_DEFAULT)  // 未删除
            ->where('customer_id', '=', $customerId)
            ->whereIn('subscribe', ['subscribe', 'unsubscribe'])
            ->when($filter['group_id'], function ($query, $groupId) {
                return $query->where('group_id', '=', $groupId);
            })
            ->orderByDesc('id')
            ->paginate($filter['page'], $filter['per_page']);
    }

    /**
     * 移动粉丝到分组
     *
     * @param string $openid
     * @param array  $attributes
     *
     * @return int
     */
    public function moveGroup(string $openid, array $attributes): int
    {
        return DB::table(User::tableName())
            ->where('openid', '=', $openid)
            ->update($attributes);
    }

    /**
     * @param string $openid
     *
     * @return array
     */
    public function findByOpenid(string $openid): array
    {
        return DB::table(User::tableName())
            ->select()
            ->where('openid', '=', $openid)
            ->firstArray();
    }
}
