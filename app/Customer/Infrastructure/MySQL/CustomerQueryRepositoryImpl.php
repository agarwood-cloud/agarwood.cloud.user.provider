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
use App\Customer\Domain\Aggregate\Repository\CustomerQueryRepository;
use Swoft\Db\DB;

/**
 * @\Swoft\Bean\Annotation\Mapping\Bean()
 */
class CustomerQueryRepositoryImpl implements CustomerQueryRepository
{
    /**
     * 公众号管理列表数据
     *
     * @param array $filter
     * @param int   $platformId
     *
     * @return array
     */
    public function index(int $platformId, array $filter): array
    {
        return DB::table(Customer::tableName())
            ->select(
                'id',
                'account',
                'name',
                'status',
                'oa_id as officialAccountId',
                'phone',
                'group_id as groupId',
                'group_name as groupName',
                'created_at as createdAt',
                'updated_at as updatedAt'
            )
            ->where('deleted_at', '=', StringConstant::DATE_TIME_DEFAULT)  // 未删除
            ->where('oa_id', '=', $platformId)
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
     * 预览
     *
     * @param int $id
     *
     * @return array
     */
    public function view(int $id): array
    {
        return DB::table(Customer::tableName())
            ->select(
                'id',
                'account',
                'name',
                'status',
                'oa_id as officialAccountId',
                'phone',
                'group_id as groupId',
                'group_name as groupName',
                'created_at as createdAt',
                'updated_at as updatedAt'
            )
            ->where('id', '=', $id)
            ->where('deleted_at', '=', StringConstant::DATE_TIME_DEFAULT)
            ->firstArray();
    }
}
