<?php declare(strict_types=1);
/**
 * This file is part of Agarwood Cloud.
 *
 * @link     https://www.agarwood-cloud.com
 * @document https://www.agarwood-cloud.com/docs
 * @contact  676786620@qq.com
 * @author   agarwood
 */

namespace App\Assign\Application\Impl;

use App\Assign\Application\CompetitiveDepartmentApplication;
use App\Assign\Domain\CompetitiveDepartmentDomainService;
use App\Assign\Interfaces\DTO\Department\ChangeStatusDTO;
use App\Assign\Interfaces\DTO\Department\CreateDTO;
use App\Assign\Interfaces\DTO\Department\IndexDTO;
use App\Assign\Interfaces\DTO\Department\UpdateDTO;
use Swoft\Stdlib\Collection;

/**
 * @\Swoft\Bean\Annotation\Mapping\Bean()
 */
class CompetitiveDepartmentApplicationImpl implements CompetitiveDepartmentApplication
{
    /**
     * 部门的领域服务
     *
     * @\Swoft\Bean\Annotation\Mapping\Inject()
     *
     * @var CompetitiveDepartmentDomainService
     */
    protected CompetitiveDepartmentDomainService $domain;

    /**
     * @inheritDoc
     */
    public function indexProvider(int $tencentId, IndexDTO $DTO, bool $isPagination = true): array
    {
        return $this->domain->index($tencentId, $DTO->toArrayNotEmpty([], true), $isPagination);
    }

    /**
     * @inheritDoc
     */
    public function createProvider(int $tencentId, CreateDTO $DTO): Collection
    {
        $attributes                 = $DTO->toArrayLine();
        $attributes['service_uuid'] = $tencentId;
        $this->domain->create($attributes);
        //这里可以设置更多的返回值
        return Collection::make($DTO);
    }

    /**
     * @inheritDoc
     */
    public function updateProvider(string $uuid, UpdateDTO $DTO): Collection
    {
        $update = $this->domain->update($uuid, $DTO);
        return Collection::make($update);
    }

    /**
     * @inheritDoc
     */
    public function changeStatusProvider(array $uuids, ChangeStatusDTO $DTO): Collection
    {
        $update = $this->domain->changeStatus($uuids, $DTO);
        return Collection::make($update);
    }
}
