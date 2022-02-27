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

use App\Customer\Domain\Aggregate\Entity\CustomerGroup;
use App\Customer\Domain\Aggregate\Entity\FansGroup;
use App\Customer\Domain\Aggregate\Entity\User;
use App\Customer\Domain\Aggregate\Repository\GroupRepository;
use Carbon\Carbon;
use Agarwood\Core\Constant\StringConstant;
use Agarwood\Core\Exception\SystemErrorException;
use Agarwood\Core\Util\WhereBuilder;
use Swoft\Db\DB;
use Swoft\Db\Eloquent\Builder;
use Swoft\Db\Eloquent\Model;
use Swoft\Db\Exception\DbException;

/**
 * @\Swoft\Bean\Annotation\Mapping\Bean()
 */
class GroupRepositoryImpl implements GroupRepository
{
    /**
     * 粉丝分组列表数据（最多支持三级分类）
     *
     * //第一步，先取出第一页的顶级元素
     * //第二步，把与顶级相关的相关的二级，三级分类取出来（最多支持三级）
     * //第三步，组成树型结构
     *
     * @param int   $platformId
     * @param array $filter
     *
     * @return array
     */
    public function customerGroupFirstPage(int $platformId, array $filter): array
    {
        return DB::table(CustomerGroup::tableName())
            ->select(
                'id',
                'p_id',
                'group_name',
                'p_group_name',
                'department',
                'department_id',
                'remark'
            )
            ->where('deleted_at', '=', StringConstant::DATE_TIME_DEFAULT)  // 未删除
            ->where('platform_id', '=', $platformId)
            ->whereNotNull('p_id') //是顶级元素
            ->when($filter['group_name'], function ($query, $param) {
                return $query->where('group_name', 'like', '%' . $param . '%');
            })
            ->orderByDesc('id')
            ->paginate($filter['page'], $filter['per_page']);
    }

    /**
     * 粉丝分组列表数据（最多支持三级分类）
     *
     * //第一步，先取出第一页的顶级元素
     * //第二步，把与顶级相关的相关的二级，三级分类取出来（最多支持三级）
     * //第三步，组成树型结构
     *
     * @param int   $platformId
     * @param array $filter
     *
     * @return array
     */
    public function fansGroupFirstPage(int $platformId, array $filter): array
    {
        return DB::table(FansGroup::tableName())
            ->select(
                'id',
                'p_id',
                'customer',
                'customer_id',
                'group_name',
                'p_group_name',
                'remark'
            )->where([
                ['deleted_at', '=', StringConstant::DATE_TIME_DEFAULT],  // 未删除
                ['platform_id', '=', $platformId],
                ['p_id', '=', '']
            ]) //是顶级元素
            ->when($filter['group_name'], function ($query, $param) {
                return $query->where('group_name', 'like', '%' . $param . '%');
            })
            ->orderByDesc('id')
            ->paginate($filter['page'], $filter['per_page']);
    }

    /**
     * 权限 pid 获取相关的数据
     *
     * @param array $pid
     *
     * @return array
     * @throws DbException
     */
    public function getCustomerGroupByUUid(array $pid): array
    {
        return DB::table(CustomerGroup::tableName())
            ->whereIn('p_id', $pid)
            ->get([
                'id',
                'p_id',
                'group_name',
                'p_group_name',
                'department',
                'department_id',
                'remark'
            ])
            ->toArray();
    }

    /**
     * 创建
     *
     * @param array $attributes
     *
     * @return CustomerGroup|null
     */
    public function createCustomerGroup(array $attributes): ?CustomerGroup
    {
        try {
            $model = CustomerGroup::new($attributes);
            if (!$model->save()) {
                throw new SystemErrorException('新增客服分组失败');
            }
            return $model;
        } catch (DbException $e) {
            throw new SystemErrorException($e->getMessage());
        }
    }

    /**
     * 删除
     *
     * @param int $id
     *
     * @return bool|null
     */
    public function deleteCustomerGroup(int $id): ?bool
    {
        try {
            // 软删除渠道
            $channel = CustomerGroup::where([
                ['deleted_at', '=', StringConstant::DATE_TIME_DEFAULT],
                ['whereIn', 'id', explode(',', $id)],
            ])->update(['deleted_at' => date('Y-m-d H:i:s')]);

            if (!$channel) {
                throw new SystemErrorException('查无此粉丝或数据没有任何变动');
            }

            return true;
        } catch (DbException $e) {
            throw new SystemErrorException($e->getMessage());
        }
    }

    /**
     * @param int   $id
     * @param array $attributes
     *
     * @return int|null
     */
    public function updateCustomerGroup(int $id, array $attributes): ?int
    {
        try {
            return CustomerGroup::where([
                ['deleted_at', '=', StringConstant::DATE_TIME_DEFAULT],
                ['id', '=', $id],
            ])->update($attributes);
        } catch (DbException $e) {
            throw new SystemErrorException($e->getMessage());
        }
    }

    /**
     * @param int $id
     *
     * @return CustomerGroup|Builder|Model|null
     */
    public function viewCustomerGroup(int $id): ?CustomerGroup
    {
        try {
            return CustomerGroup::where([
                ['deleted_at', '=', StringConstant::DATE_TIME_DEFAULT],
                ['id', '=', $id]
            ])->first();
        } catch (DbException $e) {
            throw new SystemErrorException($e->getMessage());
        }
    }

    /**
     * 检查用户是否存在
     *
     * @param int $id
     *
     * @return object|Builder|Model|null
     * @throws DbException
     */
    public static function findOpenid(int $id): ?User
    {
        return User::where([
            ['id', '=', $id]
        ])->first();
    }

    /**
     * @param int $id
     *
     * @return CustomerGroup|Builder|Model|null
     */
    public function findCustomerGroupByUuid(int $id): ?CustomerGroup
    {
        return CustomerGroup::where('id', '=', $id)
            ->first();
    }

    /**
     * @param int   $platformId
     * @param array $secondUuid
     *
     * @return  array
     */
    public function getFansGroupByUuid(int $platformId, array $secondUuid): array
    {
        return FansGroup::where('p_id', '=', $secondUuid)
            ->where('deleted_at', '=', StringConstant::DATE_TIME_DEFAULT)
            ->where('platform_id', '=', $platformId)
            ->get([
                'id',
                'p_id',
                'customer',
                'customer_id',
                'group_name',
                'p_group_name',
                'remark'
            ])
            ->toArray();
    }

    /**
     * @param int $id
     *
     * @return FansGroup|Builder|Model|null
     */
    public function findFansGroupByUuid(int $id): ?FansGroup
    {
        return FansGroup::where('id', '=', $id)
            ->first();
    }

    /**
     * @param int   $id
     * @param array $attributes
     *
     * @return int
     */
    public function updateFansGroup(int $id, array $attributes): int
    {
        return FansGroup::where([
            ['deleted_at', '=', StringConstant::DATE_TIME_DEFAULT],
            ['id', '=', $id],
        ])->update($attributes);
    }

    /**
     * @param int $id
     *
     * @return bool
     */
    public function deleteFansGroup(int $id): bool
    {
        try {
            $channel = DB::table(FansGroup::tableName())
                ->whereIn('id', explode(',', $id))
                ->update(['deleted_at' => Carbon::now()->toDateTimeString()]);

            if (!$channel) {
                throw new SystemErrorException('查无此分组或分组数据没有任何变动！！！');
            }

            return true;
        } catch (DbException $e) {
            throw new SystemErrorException($e->getMessage());
        }
    }

    /**
     * @param array $attributes
     *
     * @return FansGroup|Model
     */
    public function createFansGroup(array $attributes): ?FansGroup
    {
        try {
            $model = FansGroup::new($attributes);
            if (!$model->save()) {
                throw new SystemErrorException('新增客服分组失败');
            }
            return $model;
        } catch (DbException $e) {
            throw new SystemErrorException($e->getMessage());
        }
    }

    /**
     * @param int $id
     *
     * @return Builder|Model|object|null
     */
    public function viewFansGroup(int $id)
    {
        try {
            return FansGroup::where([
                ['deleted_at', '=', StringConstant::DATE_TIME_DEFAULT],
                ['id', '=', $id]
            ])->first();
        } catch (DbException $e) {
            throw new SystemErrorException($e->getMessage());
        }
    }

    /**
     * 客服粉丝分组列表
     *
     * @param int    $platformId
     * @param int $customerId
     * @param array  $filter
     * @param bool   $isPagination
     *
     * @return array
     */
    public function customerFansGroupFirstPage(int $platformId, int $customerId, array $filter, bool $isPagination): array
    {
        $builder = DB::table(FansGroup::tableName())
            ->select(
                'id',
                'p_id as pid',
                'customer',
                'customer_id as customerid',
                'group_name as groupName',
                'p_group_name as pGroupName',
                'remark'
            )->where([
                ['deleted_at', '=', StringConstant::DATE_TIME_DEFAULT],  // 未删除
                ['platform_id', '=', $platformId],
                ['customer_id', '=', $customerUuid],
                ['p_id', '=', '']
            ]) //是顶级元素
            ->where(
                WhereBuilder::filter($filter)
                    ->where('group_name', 'like')
                    ->build()
            )
            ->orderByDesc('id');

        if ($isPagination) {
            return $builder ? ($builder->paginate($filter['page'], $filter['per_page'])) : [];
        }
        return $builder ? (['list' => $builder->get()->toArray()]) : [];
    }
}
