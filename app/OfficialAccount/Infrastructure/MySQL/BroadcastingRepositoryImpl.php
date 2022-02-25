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

use App\OfficialAccount\Domain\Aggregate\Entity\Broadcasting;
use App\OfficialAccount\Domain\Aggregate\Entity\FansGroup;
use App\OfficialAccount\Domain\Aggregate\Entity\User;
use App\OfficialAccount\Domain\Aggregate\Repository\BroadcastingRepository;
use Agarwood\Core\Constant\StringConstant;
use Godruoyi\Snowflake\Snowflake;
use Swoft\Db\DB;

/**
 * @\Swoft\Bean\Annotation\Mapping\Bean()
 */
class BroadcastingRepositoryImpl implements BroadcastingRepository
{
    /**
     * 群发消息列表
     *
     * @param int   $tencentId
     * @param array $filter
     *
     * @return array
     */
    public function index(int $tencentId, array $filter): array
    {
        return DB::table(Broadcasting::tableName())
            ->select(
                'id',
                'message_type as messageType',
                'content',
                'group_id as groupId',
                'group_name as groupName',
                'total_count as totalCount',
                'filter_count as filterCount',
                'sent_count as sentCount',
                'error_count as errorCount',
                'article_url as articleUrl',
                'status',
                'created_at as createdAt'
            )
            ->where('service_id', '=', $tencentId)
            ->when($filter['content'], function ($query, $param) {
                return $query->where('content', 'like', '%' . $param . '%');
            })
            ->when($filter['group_name'], function ($query, $param) {
                return $query->where('group_name', 'like', '%' . $param . '%');
            })
            ->when($filter['status'], function ($query, $param) {
                return $query->where('status', '=', $param);
            })
            ->orderByDesc('id')
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
        return DB::table(Broadcasting::tableName())
            ->insert($attributes);
    }

    /**
     * @param int   $msgId
     * @param array $attributes
     *
     * @return int
     */
    public function update(int $msgId, array $attributes): int
    {
        return DB::table(Broadcasting::tableName())
            ->where('msg_id', '=', $msgId)
            ->update($attributes);
    }

    /**
     * 查找某个粉丝分组的openid
     *
     * @param int $id
     *
     * @return array
     */
    public function findGroupByUuid(int $id): array
    {
        return DB::table(User::tableName())
            ->select('openid')
            ->where('group_id', '=', $id)
            ->pluck('openid')
            ->toArray();
    }

    /**
     * 分组列表
     *
     * @param int   $tencentId
     * @param array $filter
     *
     * @return array
     */
    public function fansGroup(int $tencentId, array $filter): array
    {
        return DB::table(FansGroup::tableName() . ' as fg')
            ->select(
                'fg.id as groupId',
                'fg.group_name as groupName',
            )
            ->selectRaw('COUNT(*) as `number`')
            ->join(User::tableName() . ' as u', 'u.group_id', '=', 'fg.id')
            ->where('u.subscribe', '=', 'subscribe')
            ->where('fg.service_id', '=', $tencentId)
            ->where('fg.deleted_at', '=', StringConstant::DATE_TIME_DEFAULT)
            ->groupBy(['fg.id'])
            ->when($filter['group_name'], function ($query, $groupName) {
                return $query->where('group_name', 'like', '%' . $groupName . '%');
            })
            ->paginate($filter['page'], $filter['per_page']);
    }
}
