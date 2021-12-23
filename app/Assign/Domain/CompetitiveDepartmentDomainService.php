<?php declare(strict_types=1);
/**
 * This file is part of Agarwood Cloud.
 *
 * @link     https://www.agarwood-cloud.com
 * @document https://www.agarwood-cloud.com/docs
 * @contact  676786620@qq.com
 * @author   agarwood
 */

namespace App\Assign\Domain;

use App\Assign\Interfaces\DTO\Department\ChangeStatusDTO;
use App\Assign\Interfaces\DTO\Department\UpdateDTO;

/**
 * @\Swoft\Bean\Annotation\Mapping\Bean()
 */
interface CompetitiveDepartmentDomainService
{
    /**
     * 领域服务接口： 获取列表
     *
     * @param int   $officialAccountId
     * @param array $filter 过滤条件
     *
     * @return array
     */
    public function index(int $officialAccountId, array $filter): array;

    /**
     *  领域服务接口： 新建
     *
     * @param array $attributes
     *
     * @return bool
     */
    public function create(array $attributes): bool;

    /**
     *  领域服务接口： 新建
     *
     * @param int       $id
     * @param UpdateDTO $DTO
     *
     * @return array
     */
    public function update(int $id, UpdateDTO $DTO): array;

    /**
     *  领域服务接口： 更新
     *
     * @param array           $ids
     * @param ChangeStatusDTO $DTO 更新字段
     *
     * @return int
     */
    public function changeStatus(array $ids, ChangeStatusDTO $DTO): int;
}
