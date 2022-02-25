<?php declare(strict_types=1);
/**
 * This file is part of Agarwood Cloud.
 *
 * @link     https://www.agarwood-cloud.com
 * @document https://www.agarwood-cloud.com/docs
 * @contact  676786620@qq.com
 * @author   agarwood
 */

namespace App\Assign\Domain\Impl;

use App\Assign\Domain\CompetitiveDepartmentDomainService;
use App\Assign\Interfaces\DTO\Department\ChangeStatusDTO;
use App\Assign\Interfaces\DTO\Department\UpdateDTO;
use App\Assign\Domain\Aggregate\Repository\DepartmentRepository;

/**
 * @\Swoft\Bean\Annotation\Mapping\Bean()
 */
class CompetitiveDepartmentDomainServiceImpl implements CompetitiveDepartmentDomainService
{
    /**
     * @\Swoft\Bean\Annotation\Mapping\Inject()
     *
     * @var DepartmentRepository $departmentRepository
     */
    protected DepartmentRepository $departmentRepository;

    /**
     * @param int $tencentId
     * @param array  $filter
     *
     * @return array
     */
    public function index(int $tencentId, array $filter): array
    {
        return $this->departmentRepository->index($tencentId, $filter);
    }

    /**
     * @param array $attributes
     *
     * @return bool
     */
    public function create(array $attributes): bool
    {
        return $this->departmentRepository->create($attributes);
    }

    /**
     * @param int       $id
     * @param UpdateDTO $DTO
     *
     * @return array
     */
    public function update(int $id, UpdateDTO $DTO): array
    {
        //如果请求参数中不存在，则恢复为默认值
        $attributes = $DTO->toArrayNotNull([], true);
        $this->departmentRepository->update($id, $attributes);

        //重新查找并返回结果集
        return $this->departmentRepository->view($id);
    }

    /**
     * 更新可分配的状态
     *
     * @param array           $ids
     * @param ChangeStatusDTO $DTO
     *
     * @return int
     */
    public function changeStatus(array $ids, ChangeStatusDTO $DTO): int
    {
        //如果请求参数中不存在，则恢复为默认值
        $attributes = $DTO->toArrayNotNull();
        return $this->departmentRepository->changeStatus($ids, $attributes);
    }
}
