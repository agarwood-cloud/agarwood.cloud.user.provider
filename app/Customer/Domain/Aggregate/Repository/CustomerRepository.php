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

use App\Customer\Interfaces\DTO\Customer\LoginDTO;

/**
 * @\Swoft\Bean\Annotation\Mapping\Bean()
 */
interface CustomerRepository
{
    /**
     * 服务号管理列表数据
     *
     * @param array $filter
     * @param int   $officialAccountId
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
     * 删除
     *
     * @param string $ids
     *
     * @return int
     */
    public function delete(string $ids): int;

    /**
     * @param int   $id
     * @param array $attributes
     *
     * @return int
     */
    public function update(int $id, array $attributes): int;

    /**
     * @param int $id
     *
     * @return array
     */
    public function view(int $id): array;

    /**
     * @param LoginDTO $DTO
     *
     * @return array|null
     */
    public function login(LoginDTO $DTO): ?array;
}
