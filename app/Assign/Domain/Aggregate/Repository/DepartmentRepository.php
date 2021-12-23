<?php declare(strict_types=1);
/**
 * This file is part of Agarwood Cloud.
 *
 * @link     https://www.agarwood-cloud.com
 * @document https://www.agarwood-cloud.com/docs
 * @contact  676786620@qq.com
 * @author   agarwood
 */

namespace App\Assign\Domain\Aggregate\Repository;

use Swoft\Db\Exception\DbException;

/**
 * @\Swoft\Bean\Annotation\Mapping\Bean()
 */
interface DepartmentRepository
{
    /**
     * 管理员管理列表数据
     *
     * @param int   $officialAccountId
     * @param array $filter
     *
     * @return array
     */
    public function index(int $officialAccountId, array $filter): array;

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
     * 预览
     *
     * @param int $id
     *
     * @return array
     */
    public function view(int $id): array;

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
     * @param int $officialAccountId
     *
     * @return array
     */
    public function getDepartments(int $officialAccountId): array;

    /**
     * 所有的部门，包括不抢粉的部门
     *
     * @param int $officialAccountId
     *
     * @return array
     */
    public function getAllDepartments(int $officialAccountId): array;
}
