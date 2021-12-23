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

use App\OfficialAccount\Domain\Aggregate\Entity\CustomerAutoReply;

/**
 * @\Swoft\Bean\Annotation\Mapping\Bean()
 */
interface AutoReplyRepository
{
    /**
     * 自动回复的数据
     *
     * @param int $officialAccountId
     * @param int $customerId
     *
     * @return array
     */
    public function auto(int $officialAccountId, int $customerId): array;

    /**
     * 列表数据 (快捷回复)
     *
     * @param int $officialAccountId
     * @param int $customerId
     * @param array  $filter
     *
     * @return array
     */
    public function index(int $officialAccountId, int $customerId, array $filter): array;

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
     * @param int $id
     * @param array  $attributes
     *
     * @return int|null
     */
    public function update(int $id, array $attributes): ?int;

    /**
     * 自动回复
     *
     * @param int $officialAccountId
     * @param int $customerId
     *
     * @return array
     */
    public function autoReplyMessage(int $officialAccountId, int $customerId): array;

    /**
     * 创建保存
     *
     * @param array $attributes
     * @param array $value
     *
     * @return \App\OfficialAccount\Domain\Aggregate\Entity\CustomerAutoReply
     */
    public function updateOrCreate(array $attributes, array $value): CustomerAutoReply;
}
