<?php declare(strict_types=1);
/**
 * This file is part of Agarwood Cloud.
 *
 * @link     https://www.agarwood-cloud.com
 * @document https://www.agarwood-cloud.com/docs
 * @contact  676786620@qq.com
 * @author   agarwood
 */

namespace App\OfficialAccount\Infrastructure\MySQL;

use App\OfficialAccount\Domain\Aggregate\Entity\Customer;
use App\OfficialAccount\Domain\Aggregate\Entity\User;
use App\OfficialAccount\Domain\Aggregate\Repository\UserRpcRepository;
use App\OfficialAccount\Infrastructure\Redis\RedisUser;
use Swoft\Db\DB;
use Swoft\Db\Exception\DbException;

/**
 * @\Swoft\Bean\Annotation\Mapping\Bean()
 */
class UserRpcRepositoryImpl implements UserRpcRepository
{
    /**
     * @\Swoft\Bean\Annotation\Mapping\Inject()
     *
     * @var RedisUser
     */
    public RedisUser $redisUser;

    /**
     * 关注的所有粉丝
     *
     * @param int $platformId
     *
     * @return array
     */
    public function subscribeFans(int $platformId): array
    {
        return DB::table(User::tableName())
            ->selectRaw('COUNT(`id`) as fans')
            ->where([
                ['subscribe', '=', 'subscribe'],
                ['platform_id', '=', $platformId]
            ])->firstArray();
    }

    /**
     * 当天关注的粉丝(包括取消关注的粉丝)
     *
     * @param int    $platformId
     * @param string $startAt
     * @param string $endAt
     *
     * @return array
     */
    public function theDayFans(int $platformId, string $startAt, string $endAt): array
    {
        return DB::table(User::tableName())
            ->selectRaw('COUNT(`id`) as `theDayFans`')
            ->where('platform_id', '=', $platformId)
            ->whereBetween('subscribe_at', [$startAt, $endAt])
            ->firstArray();
    }

    /**
     * 当天取消关注的粉丝
     *
     * @param int $platformId
     * @param string $startAt
     * @param string $endAt
     *
     * @return array
     */
    public function theDayUnsubscribeFans(int $platformId, string $startAt, string $endAt): array
    {
        return DB::table(User::tableName())
            ->selectRaw('COUNT(`id`) as `theDayUnsubscribeFans`')
            ->where('subscribe', '=', 'unsubscribe')
            ->where('platform_id', '=', $platformId)
            ->whereBetween('unsubscribed_at', [$startAt, $endAt])
            ->firstArray();
    }

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
    public function theDayTurnoverFansOpenid(array $openid, string $startAt, string $endAt): array
    {
        return DB::table(User::tableName())
            ->select('openid')
            ->whereIn('openid', $openid)
            ->whereBetween('subscribe_at', [$startAt, $endAt])
            ->pluck('openid')
            ->toArray();
    }

    /**
     * 获取粉丝的基本信息
     *
     * @param string $openid
     *
     * @return array
     */
    public function getFansBase(string $openid): array
    {
        // 这里加入缓存信息
        $fans = $this->redisUser->getCacheFromRedis($openid);

        if ($fans) {
            return $fans;
        }

        return DB::table(User::tableName())
            ->select()
            ->where('openid', '=', $openid)
            ->firstArray();
    }

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
    public function turnoverTimeIntervalOpenid(int $platformId, array $openid, string $startAt, string $endAt): array
    {
        return DB::table(User::tableName())
            ->select('openid')
            ->selectRaw('date_format(`created_at`, \'%m-%d %H\') as `time`')
            ->where('platform_id', '=', $platformId)
            ->whereBetween('subscribe_at', [$startAt, $endAt])
            ->whereIn('openid', $openid)
            ->get()
            ->toArray();
    }

    /**
     * 新增粉丝
     *
     * @param int    $platformId
     * @param string $startAt
     * @param string $endAt
     *
     * @return array
     */
    public function userCenterTurnoverTimeFans(int $platformId, string $startAt, string $endAt): array
    {
        return DB::table(User::tableName())
            ->selectRaw('date_format(`created_at`, \'%m-%d %H\') as `time`, count(`openid`) as `value`, "新增粉丝" as category')
            ->where('platform_id', '=', $platformId)
            ->whereBetween('subscribe_at', [$startAt, $endAt])
            ->groupBy(['time'])
            ->orderBy('time')
            ->get()
            ->toArray();
    }

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
    public function userCenterTurnoverTimeBuyFans(int $platformId, array $openid, string $startAt, string $endAt): array
    {
        return DB::table(User::tableName())
            ->selectRaw('date_format(`created_at`, \'%m-%d %H\') as `time`, count(`openid`) as `value`, "成交粉丝" as category')
            ->where('platform_id', '=', $platformId)
            ->whereBetween('subscribe_at', [$startAt, $endAt])
            ->whereIn('openid', $openid)
            ->groupBy(['time'])
            ->orderBy('time')
            ->get()
            ->toArray();
    }

    /**
     * 粉丝关联的客服信息
     *
     * @param string $openid
     *
     * @return array
     */
    public function customerForFans(string $openid): array
    {
        return DB::table(User::tableName() . ' as u')
            ->select('u.customer', 'u.customer_id', 'c.group_name', 'c.group_id')
            ->join(Customer::tableName() . ' as c', 'c.id', '=', 'u.customer_id')
            ->where('u.openid', '=', $openid)
            ->limit(1)
            ->firstArray();
    }
}
