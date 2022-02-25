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

use App\Assign\Application\CompetitiveApplication;
use App\Assign\Domain\CompetitiveDomainService;
use App\Assign\Interfaces\DTO\Competitive\ChangeStatusDTO;
use App\Assign\Interfaces\DTO\Competitive\CreateDTO;
use App\Assign\Interfaces\DTO\Competitive\IndexDTO;
use App\Assign\Interfaces\DTO\Competitive\UpdateDTO;
use Ramsey\Uuid\Uuid;
use Swoft\Stdlib\Collection;

/**
 * @\Swoft\Bean\Annotation\Mapping\Bean()
 */
class CompetitiveApplicationImpl implements CompetitiveApplication
{
    /**
     * 分组领域服务
     *
     * @\Swoft\Bean\Annotation\Mapping\Inject()
     *
     * @var CompetitiveDomainService
     */
    protected CompetitiveDomainService $domain;

    /**
     * @inheritDoc
     */
    public function indexProvider(int $tencentId, IndexDTO $DTO): array
    {
        return $this->domain->index($tencentId, $DTO->toArrayNotEmpty([], true));
    }

    /**
     * @inheritDoc
     */
    public function createProvider(int $tencentId, CreateDTO $DTO): Collection
    {
        $attributes                 = $DTO->toArrayLine();
        $attributes['service_uuid'] = $tencentId;
        $attributes['uuid']         = Uuid::uuid4()->toString();
        $this->domain->create($attributes);
        //这里可以设置更多的返回值
        return Collection::make($DTO);
    }

    /**
     * @inheritDoc
     */
    public function updateProvider(int $id, UpdateDTO $DTO): Collection
    {
        $update = $this->domain->update($id, $DTO);
        return Collection::make($update);
    }

    /**
     * @inheritDoc
     */
    public function changeStatusProvider(int $id, ChangeStatusDTO $DTO): Collection
    {
        $update = $this->domain->changeStatus($id, $DTO);
        return Collection::make($update);
    }

    /**
     * @inheritDoc
     */
    public function obtainFansProvider(int $tencentId, int $customerId): int
    {
        return $this->domain->obtainFans($tencentId, $customerId);
    }
}
