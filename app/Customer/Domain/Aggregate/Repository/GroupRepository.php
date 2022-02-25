<?php declare(strict_types=1);
/**
 * This file is part of Agarwood Cloud.
 *
 * @link     https://www.agarwood-cloud.com
 * @document https://www.agarwood-cloud.com/docs
 * @contact  676786620@qq.com
 * @author   agarwood
 */

namespace App\Customer\Domain\Aggregate\Repository;

use App\Customer\Domain\Aggregate\Entity\CustomerGroup;
use App\Customer\Domain\Aggregate\Entity\FansGroup;
use App\Customer\Domain\Aggregate\Entity\User;
use Swoft\Db\Eloquent\Builder;
use Swoft\Db\Eloquent\Model;
use Swoft\Db\Exception\DbException;

/**
 * @\Swoft\Bean\Annotation\Mapping\Bean()
 */
interface GroupRepository
{
    /**
     * 粉丝分组列表数据（最多支持三级分类）
     *
     * //第一步，先取出第一页的顶级元素
     * //第二步，把与顶级相关的相关的二级，三级分类取出来（最多支持三级）
     * //第三步，组成树型结构
     *
     * @param int   $tencentId
     * @param array $filter
     *
     * @return array
     */
    public function customerGroupFirstPage(int $tencentId, array $filter): array;

    /**
     * 粉丝分组列表数据（最多支持三级分类）
     *
     * //第一步，先取出第一页的顶级元素
     * //第二步，把与顶级相关的相关的二级，三级分类取出来（最多支持三级）
     * //第三步，组成树型结构
     *
     * @param int   $tencentId
     * @param array $filter
     *
     * @return array
     */
    public function fansGroupFirstPage(int $tencentId, array $filter): array;

    /**
     * 权限 pUuid 获取相关的数据
     *
     * @param array $pid
     *
     * @return array
     * @throws DbException
     */
    public function getCustomerGroupByUuid(array $pid): array;

    /**
     * 创建
     *
     * @param array $attributes
     *
     * @return CustomerGroup|null
     */
    public function createCustomerGroup(array $attributes): ?CustomerGroup;

    /**
     * 删除
     *
     * @param int $id
     *
     * @return bool|null
     */
    public function deleteCustomerGroup(int $id): ?bool;

    /**
     * @param int   $id
     * @param array $attributes
     *
     * @return int|null
     */
    public function updateCustomerGroup(int $id, array $attributes): ?int;

    /**
     * @param int $id
     *
     * @return CustomerGroup|Builder|Model|null
     */
    public function viewCustomerGroup(int $id): ?CustomerGroup;

    /**
     * 检查用户是否存在
     *
     * @param int $id
     *
     * @return object|Builder|Model|null
     * @throws DbException
     */
    public static function findOpenid(int $id): ?User;

    /**
     * @param int $id
     *
     * @return CustomerGroup|Builder|Model|null
     */
    public function findCustomerGroupByUuid(int $id): ?CustomerGroup;

    /**
     * @param int   $tencentId
     * @param array $secondUuid
     *
     * @return  array
     */
    public function getFansGroupByUuid(int $tencentId, array $secondUuid): array;

    /**
     * @param int $id
     *
     * @return FansGroup|Builder|Model|null
     */
    public function findFansGroupByUuid(int $id): ?FansGroup;

    /**
     * @param int   $id
     * @param array $attributes
     *
     * @return int
     */
    public function updateFansGroup(int $id, array $attributes): int;

    /**
     * @param int $id
     *
     * @return bool
     */
    public function deleteFansGroup(int $id): bool;

    /**
     * @param array $attributes
     *
     * @return FansGroup|Model
     */
    public function createFansGroup(array $attributes): ?FansGroup;

    /**
     * @param int $id
     *
     * @return Builder|Model|object|null
     */
    public function viewFansGroup(int $id);

    /**
     * 客服粉丝分组列表
     *
     * @param int    $tencentId
     * @param int $customerId
     * @param array  $filter
     * @param bool   $isPagination
     *
     * @return array
     */
    public function customerFansGroupFirstPage(int $tencentId, int $customerId, array $filter, bool $isPagination): array;
}
