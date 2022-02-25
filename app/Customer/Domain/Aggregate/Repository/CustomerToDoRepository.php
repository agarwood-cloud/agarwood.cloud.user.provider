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

/**
 * @\Swoft\Bean\Annotation\Mapping\Bean()
 */
interface CustomerToDoRepository
{
    /**
     * 列表数据
     *
     * @param int   $tencentId
     * @param int   $customerId
     * @param array $filter
     *
     * @return array
     */
    public function index(int $tencentId, int $customerId, array $filter): array;

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
     * 关联粉丝的跟进事项
     *
     * @param string $openid
     *
     * @return array
     */
    public function toDoListEvent(string $openid): array;
}
