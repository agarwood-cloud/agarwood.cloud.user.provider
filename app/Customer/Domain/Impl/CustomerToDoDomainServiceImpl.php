<?php declare(strict_types=1);
/**
 * This file is part of Agarwood Cloud.
 *
 * @link     https://www.agarwood-cloud.com
 * @document https://www.agarwood-cloud.com/docs
 * @contact  676786620@qq.com
 * @author   agarwood
 */

namespace App\Customer\Domain\Impl;

use App\Customer\Domain\Aggregate\Repository\CustomerToDoRepository;
use App\Customer\Domain\CustomerToDoDomainService;
use App\Customer\Interfaces\DTO\CustomerToDo\UpdateDTO;

/**
 * @\Swoft\Bean\Annotation\Mapping\Bean()
 */
class CustomerToDoDomainServiceImpl implements CustomerToDoDomainService
{
    /**
     * @\Swoft\Bean\Annotation\Mapping\Inject()
     *
     * @var CustomerToDoRepository
     */
    protected CustomerToDoRepository $customerToDoRepository;

    /**
     * @param int   $platformId
     * @param int   $customerId
     * @param array $filter
     *
     * @return array
     */
    public function index(int $platformId, int $customerId, array $filter): array
    {
        return $this->customerToDoRepository->index($platformId, $customerId, $filter);
    }

    /**
     * @param array $attributes
     *
     * @return bool
     */
    public function create(array $attributes): bool
    {
        return $this->customerToDoRepository->create($attributes);
    }

    /**
     * @param int       $id
     * @param UpdateDTO $DTO
     *
     * @return int
     */
    public function update(int $id, UpdateDTO $DTO): int
    {
        return $this->customerToDoRepository->update($id, $DTO->toArrayNotNull([], true));
    }

    /**
     * @param string $uuid
     *
     * @return int
     */
    public function delete(string $uuid): int
    {
        return $this->customerToDoRepository->delete($uuid);
    }
}
