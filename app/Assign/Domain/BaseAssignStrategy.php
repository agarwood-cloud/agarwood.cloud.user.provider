<?php declare(strict_types=1);
/**
 * This file is part of Agarwood Cloud.
 *
 * @link     https://www.agarwood-cloud.com
 * @document https://www.agarwood-cloud.com/docs
 * @contact  676786620@qq.com
 * @author   agarwood
 */

namespace App\Assign\Domain;

/**
 * 基础粉丝的分配策略
 *
 * @\Swoft\Bean\Annotation\Mapping\Bean()
 */
interface BaseAssignStrategy
{
    /**
     * 分配客服
     *
     * @param int $officialAccountId
     *
     * @return int
     */
    public function assignCustomer(int $officialAccountId): int;

    /**
     * 加入抢粉（有序集合/集合/队列）
     *
     * @param int $officialAccountId
     * @param int $customerId
     * @param int $power
     *
     * @return bool
     */
    public function assignList(int $officialAccountId, int $customerId, int $power = 0): bool;

    /**
     * 加入抢粉队列
     *    数据结构 - 有序集合
     *
     * @param int   $departmentId
     * @param int   $customerId
     * @param float $power 综合竞争力
     *
     * @return void
     */
    public function pushSets(int $departmentId, int $customerId, float $power): void;

    /**
     * 弹出集合的最大值
     *    数据结构 - 有序集合
     *
     * @param int $departmentId
     *
     * @return array
     */
    public function popSets(int $departmentId): array;

    /**
     * 是否已存在集合
     *
     * @param int $departmentId
     * @param int $customerId
     *
     * @return float|bool
     */
    public function hasSets(int $departmentId, int $customerId): float|bool;

    /**
     * 加入基础抢粉队列
     *
     * @param int $departmentId
     * @param int $customerId
     *
     * @return void
     */
    public function pushQueue(int $departmentId, int $customerId): void;

    /**
     * 加入基础抢粉队列
     *
     * @param int $departmentId
     *
     * @return string|bool
     */
    public function popQueue(int $departmentId): string|bool;

    /**
     * 随机分配
     *
     * @param int $officialAccountId
     *
     * @return int
     */
    public function randomAssign(int $officialAccountId): int;

    /**
     * 标记正在抢粉
     *
     * @param int $officialAccountId
     * @param int $customerId
     */
    public function pushSetsStatus(int $officialAccountId, int $customerId): void;
}
