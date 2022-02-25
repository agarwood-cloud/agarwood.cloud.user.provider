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

/**
 * @\Swoft\Bean\Annotation\Mapping\Bean()
 */
interface CompetitiveRepository
{
    /**
     * 管理员管理列表数据
     *
     * @param int   $platformId
     * @param array $filter
     *
     * @return array
     */
    public function index(int $platformId, array $filter): array;

    /**
     * 创建
     *
     * @param array $attributes
     *
     * @return bool
     */
    public function create(array $attributes): bool;

    /**
     * @param int   $id
     * @param array $attributes
     *
     * @return int|null
     */
    public function update(int $id, array $attributes): ?int;

    /**
     * @param int   $id
     * @param array $attributes
     *
     * @return int
     */
    public function changeStatus(int $id, array $attributes): int;

    /**
     * @param int $id
     *
     * @return array
     */
    public function findByCustomerUuid(int $id): array;
}
