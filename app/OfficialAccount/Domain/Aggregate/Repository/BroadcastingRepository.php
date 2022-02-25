<?php declare(strict_types=1);
/**
 * This file is part of Agarwood Cloud.
 *
 * @link     https://www.agarwood-cloud.com
 * @document https://www.agarwood-cloud.com/docs
 * @contact  676786620@qq.com
 * @author   agarwood
 */

namespace App\OfficialAccount\Domain\Aggregate\Repository;

/**
 * @\Swoft\Bean\Annotation\Mapping\Bean()
 */
interface BroadcastingRepository
{
    /**
     * 群发消息列表
     *
     * @param int   $tencentId
     * @param array $filter
     *
     * @return array
     */
    public function index(int $tencentId, array $filter): array;

    /**
     * 创建
     *
     * @param array $attributes
     *
     * @return bool
     */
    public function create(array $attributes): bool;

    /**
     * @param int   $msgId
     * @param array $attributes
     *
     * @return int
     */
    public function update(int $msgId, array $attributes): int;

    /**
     * 查找某个粉丝分组的openid
     *
     * @param int $id
     *
     * @return array
     */
    public function findGroupByUuid(int $id): array;

    /**
     * 分组列表
     *
     * @param int   $tencentId
     * @param array $filter
     *
     * @return array
     */
    public function fansGroup(int $tencentId, array $filter): array;
}
