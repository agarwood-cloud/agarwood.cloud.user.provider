<?php declare(strict_types=1);
/**
 * This file is part of Agarwood Cloud.
 *
 * @link     https://www.agarwood-cloud.com
 * @document https://www.agarwood-cloud.com/docs
 * @contact  676786620@qq.com
 * @author   agarwood
 */

namespace App\Customer\Application\Impl;

use App\Customer\Application\CustomerGroupApplication;
use App\Customer\Domain\GroupDomainService;
use App\Customer\Interfaces\DTO\Group\CustomerGroupCreateDTO;
use App\Customer\Interfaces\DTO\Group\CustomerGroupIndexDTO;
use App\Customer\Interfaces\DTO\Group\CustomerGroupUpdateDTO;
use Swoft\Stdlib\Collection;

/**
 * @\Swoft\Bean\Annotation\Mapping\Bean()
 */
class CustomerGroupApplicationImpl implements CustomerGroupApplication
{
    /**
     * 分组领域服务
     *
     * @\Swoft\Bean\Annotation\Mapping\Inject()
     *
     * @var \App\Customer\Domain\GroupDomainService
     */
    public GroupDomainService $domain;

    /**
     * @inheritDoc
     */
    public function indexProvider(int $platformId, CustomerGroupIndexDTO $DTO): array
    {
        return $this->domain->customerIndex($platformId, $DTO->toArrayLine(), $isPagination);
    }

    /**
     * @inheritDoc
     */
    public function createProvider(int $platformId, CustomerGroupCreateDTO $DTO): Collection
    {
        //增加部分系统自己添加的参数 i.e: uuid
        $attributes                 = $DTO->toArrayLine();
        $attributes['service_uuid'] = $platformId;
        $this->domain->customerCreate($attributes);
        //这里可以设置更多的返回值
        return Collection::make($DTO);
    }

    /**
     * @inheritDoc
     */
    public function deleteProvider(string $uuids): ?bool
    {
        return $this->domain->customerDelete($uuids);
    }

    /**
     * @inheritDoc
     */
    public function updateProvider(int $id, CustomerGroupUpdateDTO $DTO): Collection
    {
        $result = $this->domain->customerUpdate($id, $DTO);
        return Collection::make($result);
    }

    /**
     * @inheritDoc
     */
    public function viewProvider(int $id): array
    {
        return $this->domain->customerView($id);
    }
}
