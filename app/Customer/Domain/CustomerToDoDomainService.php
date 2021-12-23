<?php declare(strict_types=1);
/**
 * This file is part of Agarwood Cloud.
 *
 * @link     https://www.agarwood-cloud.com
 * @document https://www.agarwood-cloud.com/docs
 * @contact  676786620@qq.com
 * @author   agarwood
 */

namespace App\Customer\Domain;

use App\Customer\Interfaces\DTO\CustomerToDo\UpdateDTO;

interface CustomerToDoDomainService
{
    /**
     *
     * @param int   $officialAccountId
     * @param int   $customerId
     * @param array $filter 过滤条件
     *
     * @return array
     */
    public function index(int $officialAccountId, int $customerId, array $filter): array;

    /**
     * 新建
     *
     * @param array $attributes
     *
     * @return bool
     */
    public function create(array $attributes): bool;

    /**
     * 更新
     *
     * @param int       $id 分组uuid
     * @param UpdateDTO $DTO
     *
     * @return int
     */
    public function update(int $id, UpdateDTO $DTO): int;

    /**
     * 删除
     *
     * @param string $uuid
     *
     * @return int
     */
    public function delete(string $uuid): int;
}
