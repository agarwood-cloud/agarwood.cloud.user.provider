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
use App\OfficialAccount\Domain\Aggregate\Repository\UserQueryRepository;
use Swoft\Db\DB;

/**
 * @\Swoft\Bean\Annotation\Mapping\Bean()
 */
class UserQueryRepositoryImpl implements UserQueryRepository
{
    /**
     * find user info by openid.
     *
     * @param string $openid
     *
     * @return array
     */
    public function findByOpenid(string $openid): array
    {
        return DB::table(User::tableName())
            ->select(
                'id',
                'oa_id as officialAccountId',
                'openid',
                'customer_id as customerId',
                'customer',
                'nickname',
                'head_img_url as headImgUrl',
                'subscribe_at as subscribeAt',
                'unsubscribe_at as unsubscribeAt',
                'subscribe',
                'subscribe_scene as subscribeScene',
                'created_at as createdAt',
                'updated_at as updatedAt'
            )
            ->where('openid', '=', $openid)
            ->firstArray();
    }

    /**
     * User List Query Builder
     *
     * @param int   $officialAccountId
     * @param array $filter
     *
     * @return array
     */
    public function index(int $officialAccountId, array $filter): array
    {
        return DB::table(User::tableName())
            ->selectRaw(
                '`id`,
                `openid`,
                `union_id` as `unionId`,
                `customer_id` as `customerId`,
                `customer`,
                `nickname`,
                `head_img_url` as `headImgUrl`,
                `subscribe_at` as `subscribeAt`,
                `unsubscribe_at` as `unsubscribeAt`,
                `subscribe`,
                `subscribe_scene` as `subscribeScene`,
                `created_at` as `createdAt`,
                `updated_at` as `updatedAt`'
            )
            ->where('deleted_at', '=', StringConstant::DATE_TIME_DEFAULT)
            ->where('oa_id', '=', $officialAccountId)
            ->orderByDesc('id')
            ->when($filter['openid'], function ($query, $param) {
                return $query->whereIn('openid', $param);
            })
            ->when($filter['subscribe'], function ($query, $param) {
                return $query->where('subscribe', '=', $param);
            })
            ->when($filter['customer'], function ($query, $param) {
                return $query->where('customer', 'like', '%' . $param . '%');
            })
            ->when($filter['nickname'], function ($query, $param) {
                return $query->where('subscribe', '=', '%' . $param . '%');
            })
            ->paginate($filter['page'], $filter['per_page']);
    }
}
