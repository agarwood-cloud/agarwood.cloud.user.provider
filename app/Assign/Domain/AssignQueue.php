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
 * 抢粉队列（集合）
 *
 * @\Swoft\Bean\Annotation\Mapping\Bean()
 */
interface AssignQueue
{
    /**
     * 加入抢粉队列
     *
     * @param int $officialAccountId
     * @param int $customerId
     */
    public function pushQueue(int $officialAccountId, int $customerId): void;

    /**
     * 弹出抢粉队列
     *
     * @param int $officialAccountId
     *
     * @return int
     */
    public function popQueue(int $officialAccountId): int;

    /**
     * 检查是否在抢粉队列里面
     *    数据结构 - 集合
     *
     * @param int $officialAccountId
     * @param int $customerId
     *
     * @return bool
     */
    public function status(int $officialAccountId, int $customerId): bool;

    /**
     * 标记正在抢粉
     *    数据结构 - 集合
     *
     * @param int $officialAccountId
     * @param int $customerId
     *
     * @return void
     */
    public function pushSetsStatus(int $officialAccountId, int $customerId): void;

    /**
     * 删除正在抢粉的标记
     *    数据结构 - 集合
     *
     * @param int $officialAccountId
     * @param int $customerId
     *
     * @return int
     */
    public function popSetsStatus(int $officialAccountId, int $customerId): int;
}
