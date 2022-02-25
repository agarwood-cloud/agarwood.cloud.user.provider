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

use Swoft\Db\Exception\DbException;

/**
 * @\Swoft\Bean\Annotation\Mapping\Bean()
 */
interface DepartmentRepository
{
    /**
     * 管理员管理列表数据
     *
     * @param int   $platformId
     * @param array $filter
     * @param bool  $isPagination
     *
     * @return array
     */
    public function index(int $platformId, array $filter, bool $isPagination): array;

    /**
     * 创建
     *
     * @param array $attributes
     *
     * @return bool
     */
    public function create(array $attributes): bool;

    /**
     * 更新
     *
     * @param int   $id
     * @param array $attributes
     *
     * @return int
     */
    public function update(int $id, array $attributes): int;

    /**
     * 查找是否存在
     *
     * @param int $id
     *
     * @return array
     * @throws DbException
     */
    public function findByCustomerUuid(int $id): array;

    /**
     * 修改状态
     *
     * @param array $ids
     * @param array $attributes
     *
     * @return int
     */
    public function changeStatus(array $ids, array $attributes): int;

    /**
     * 查找该分配粉丝的部门及相关参数部
     *      Tips: 门分配粉丝为0的，不分配粉丝
     *
     * @param int $platformId
     *
     * @return array
     */
    public function getDepartments(int $platformId): array;

    /**
     * 所有的部门，包括不抢粉的部门
     *
     * @param int $platformId
     *
     * @return array
     */
    public function getAllDepartments(int $platformId): array;
}
