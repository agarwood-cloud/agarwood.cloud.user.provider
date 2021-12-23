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

use App\Customer\Application\CustomerToDoApplication;
use App\Customer\Domain\Aggregate\Enum\CustomerToDoStatusEnum;
use App\Customer\Domain\CustomerToDoDomainService;
use App\Customer\Interfaces\DTO\CustomerToDo\CreateDTO;
use App\Customer\Interfaces\DTO\CustomerToDo\IndexDTO;
use App\Customer\Interfaces\DTO\CustomerToDo\UpdateDTO;
use Exception;
use Swoft\Stdlib\Collection;

/**
 * @\Swoft\Bean\Annotation\Mapping\Bean()
 */
class CustomerToDoApplicationImpl implements CustomerToDoApplication
{
    /**
     * 分组领域服务
     *
     * @\Swoft\Bean\Annotation\Mapping\Inject()
     *
     * @var CustomerToDoDomainService
     */
    protected CustomerToDoDomainService $domain;

    /**
     * @inheritDoc
     * @throws Exception
     */
    public function indexProvider(int $officialAccountId, int $customerId, IndexDTO $DTO): array
    {
        $filter = $DTO->toArrayLine();

        // 待办
        $filter['status'] = $DTO->getStatus() ?: CustomerToDoStatusEnum::STATUS_TODO;

        return $this->domain->index($officialAccountId, $customerId, $filter);
    }

    /**
     * @inheritDoc
     */
    public function createProvider(int $officialAccountId, int $customerId, CreateDTO $DTO): Collection
    {
        //增加部分系统自己添加的参数 i.e: id
        $attributes                  = $DTO->toArrayNotNull([], true);
        $attributes['service_id']    = $officialAccountId;
        $attributes['customer_id']   = $customerId;
        $attributes['status']        = CustomerToDoStatusEnum::STATUS_TODO;
        $collection                  = $this->domain->create($attributes);
        //这里可以设置更多的返回值
        return Collection::make($collection);
    }

    /**
     * @inheritDoc
     */
    public function deleteProvider(string $ids): ?int
    {
        return $this->domain->delete($ids);
    }

    /**
     * @inheritDoc
     */
    public function updateProvider(int $id, UpdateDTO $DTO): Collection
    {
        $result = $this->domain->update($id, $DTO);
        return Collection::make($result);
    }
}
