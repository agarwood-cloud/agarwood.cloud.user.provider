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
 *
 */
interface OverviewRpcRepository
{
    /**
     * 获取所有的客服数据
     *
     * @param int $platformId
     * @param array  $filter
     *
     * @return array
     */
    public function customerList(int $platformId, array $filter): array;

    /**
     * 抢粉的数量，按客服分组
     *
     * @param int $platformId
     * @param array  $customerUuid
     * @param string $startAt
     * @param string $endAt
     *
     * @return array
     */
    public function obtainFans(int $platformId, array $customerUuid, string $startAt, string $endAt): array;

    /**
     * 总粉丝数量，包括取消关注的
     *
     * @param int $platformId
     * @param array  $customerUuid
     * @param string $startAt
     * @param string $endAt
     *
     * @return array
     */
    public function fans(int $platformId, array $customerUuid, string $startAt, string $endAt): array;

    /**
     * 取关的人粉丝
     *
     * @param int $platformId
     * @param array  $customerUuid
     * @param string $startAt
     * @param string $endAt
     *
     * @return array
     */
    public function unsubscribe(int $platformId, array $customerUuid, string $startAt, string $endAt): array;

    /**
     * 在xx时间段内关注且有成交的粉丝的openid
     *
     * @param int $platformId
     * @param array  $customerUuid
     * @param array  $openid
     * @param string $startAt
     * @param string $endAt
     *
     * @return array
     */
    public function salesNewFansOpenid(int $platformId, array $customerUuid, array $openid, string $startAt, string $endAt): array;

    /**
     * 在xx时间段内有成交的粉丝的数量
     *
     * @param int $platformId
     * @param array  $customerUuid
     * @param array  $openid
     * @param string $startAt
     * @param string $endAt
     *
     * @return array
     */
    public function newFansCash(int $platformId, array $customerUuid, array $openid, string $startAt, string $endAt): array;
}
