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

use Swoft\Db\Exception\DbException;

/**
 * @\Swoft\Bean\Annotation\Mapping\Bean()
 */
interface UserRpcRepository
{
    /**
     * 关注的所有粉丝
     *
     * @param int $platformId
     *
     * @return array
     */
    public function subscribeFans(int $platformId): array;

    /**
     * 当天关注的粉丝(包括取消关注的粉丝)
     *
     * @param int    $platformId
     * @param string $startAt
     * @param string $endAt
     *
     * @return array
     */
    public function theDayFans(int $platformId, string $startAt, string $endAt): array;

    /**
     * 当天取消关注的粉丝
     *
     * @param int    $platformId
     * @param string $startAt
     * @param string $endAt
     *
     * @return array
     */
    public function theDayUnsubscribeFans(int $platformId, string $startAt, string $endAt): array;

    /**
     * 在xx时间段内成交的粉丝的 openid
     *
     * @param array  $openid
     * @param string $startAt
     * @param string $endAt
     *
     * @return array
     * @throws DbException
     */
    public function theDayTurnoverFansOpenid(array $openid, string $startAt, string $endAt): array;

    /**
     * 获取粉丝的基本信息
     *
     * @param string $openid
     *
     * @return array
     */
    public function getFansBase(string $openid): array;

    /**
     * 时间段内关注的openid
     *
     * @param int    $platformId
     * @param array  $openid
     * @param string $startAt
     * @param string $endAt
     *
     * @return array
     */
    public function turnoverTimeIntervalOpenid(int $platformId, array $openid, string $startAt, string $endAt): array;

    /**
     * 新增粉丝
     *
     * @param int    $platformId
     * @param string $startAt
     * @param string $endAt
     *
     * @return array
     */
    public function userCenterTurnoverTimeFans(int $platformId, string $startAt, string $endAt): array;

    /**
     * 时段分析：成交粉丝
     *
     * @param int    $platformId
     * @param array  $openid
     * @param string $startAt
     * @param string $endAt
     *
     * @return array
     */
    public function userCenterTurnoverTimeBuyFans(int $platformId, array $openid, string $startAt, string $endAt): array;

    /**
     * 粉丝关联的客服信息
     *
     * @param string $openid
     *
     * @return array
     */
    public function customerForFans(string $openid): array;
}
