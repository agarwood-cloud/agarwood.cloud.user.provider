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

use App\OfficialAccount\Domain\Aggregate\Entity\CustomerAutoReply;
use App\OfficialAccount\Domain\Aggregate\Enum\ReplyEnum;
use App\OfficialAccount\Domain\Aggregate\Repository\AutoReplyRepository;
use Carbon\Carbon;
use Agarwood\Core\Constant\StringConstant;
use Godruoyi\Snowflake\Snowflake;
use Swoft\Db\DB;

/**
 * @\Swoft\Bean\Annotation\Mapping\Bean()
 */
class AutoReplyRepositoryImpl implements AutoReplyRepository
{
    /**
     * 自动回复的数据
     *
     * @param int $officialAccountId
     * @param int $customerId
     *
     * @return array
     */
    public function auto(int $officialAccountId, int $customerId): array
    {
        return DB::table(CustomerAutoReply::tableName())
            ->select(
                'id',
                'content',
                'auto_type as autoType',
                'created_at as createdAt',
                'updated_at as updatedAt'
            )
            ->where('service_id', '=', $officialAccountId)
            ->where('customer_id', '=', $customerId)
            ->where('auto_type', '=', 'auto')
            ->where('deleted_at', '=', StringConstant::DATE_TIME_DEFAULT)  // 未删除
            ->firstArray();
    }

    /**
     * 列表数据 (快捷回复)
     *
     * @param int   $officialAccountId
     * @param int   $customerId
     * @param array $filter
     *
     * @return array
     */
    public function index(int $officialAccountId, int $customerId, array $filter): array
    {
        return DB::table(CustomerAutoReply::tableName())
            ->select(
                'id',
                'content',
                'auto_type as autoType',
                'created_at as createdAt',
                'updated_at as updatedAt'
            )
            ->where('service_id', '=', $officialAccountId)
            ->where('customer_id', '=', $customerId)
            ->where('auto_type', '=', 'quick')
            ->where('deleted_at', '=', StringConstant::DATE_TIME_DEFAULT) // 未删除
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
        return DB::table(CustomerAutoReply::tableName())
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
        return DB::table(CustomerAutoReply::tableName())
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
        return DB::table(CustomerAutoReply::tableName())
            ->where('deleted_at', '=', StringConstant::DATE_TIME_DEFAULT)
            ->where('id', '=', $id)
            ->update($attributes);
    }

    /**
     * 自动回复
     *
     * @param int $officialAccountId
     * @param int $customerId
     *
     * @return array
     */
    public function autoReplyMessage(int $officialAccountId, int $customerId): array
    {
        return DB::table(CustomerAutoReply::tableName())
            ->select()
            ->where('service_id', '=', $officialAccountId)
            ->where('customer_id', '=', $customerId)
            ->where('auto_type', '=', ReplyEnum::AUTO_REPLY_TYPE)
            ->where('event_key', '=', ReplyEnum::EVENT_KEY)
            ->firstArray();
    }

    /**
     * 创建保存
     *
     * @param array $attributes
     * @param array $value
     *
     * @return \App\OfficialAccount\Domain\Aggregate\Entity\CustomerAutoReply
     */
    public function updateOrCreate(array $attributes, array $value): CustomerAutoReply
    {
        return CustomerAutoReply::updateOrCreate($attributes, $value);
    }
}
