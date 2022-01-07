<?php declare(strict_types=1);
/**
 * This file is part of Agarwood Cloud.
 *
 * @link     https://www.agarwood-cloud.com
 * @document https://www.agarwood-cloud.com/docs
 * @contact  676786620@qq.com
 * @author   agarwood
 */

namespace App\OfficialAccount\Infrastructure\Redis\Impl;

use App\OfficialAccount\Infrastructure\Redis\Enum\RedisUserCacheEnum;
use App\OfficialAccount\Infrastructure\Redis\RedisUser;
use Swoft\Redis\Redis;

/**
 * @\Swoft\Bean\Annotation\Mapping\Bean()
 */
class RedisUserImpl implements RedisUser
{
    /**
     * set user info to redis
     *
     * @param string $openid
     * @param array  $attributes
     * @param int    $ttl seconds
     *
     * @return void
     */
    public function setCacheToRedis(string $openid, array $attributes, int $ttl = 0): void
    {
        Redis::hMSet(RedisUserCacheEnum::REDIS_CACHE_PREFIX_KEY . $openid, $attributes);

        if ($ttl > 0) {
            Redis::expire(RedisUserCacheEnum::REDIS_CACHE_PREFIX_KEY . $openid, $ttl);
        }
    }

    /**
     * get user info from redis
     *
     * @param string $openid
     *
     * @return array
     */
    public function getCacheFromRedis(string $openid): array
    {
        return Redis::hGetAll(RedisUserCacheEnum::REDIS_CACHE_PREFIX_KEY . $openid);
    }

    /**
     * get users info from redis
     *
     * @param array $openid
     *
     * @return array
     */
    public function getUsersCacheFromRedis(array $openid): array
    {
        $userInfo = [];
        foreach ($openid as $item) {
            $redisOpenid = Redis::hGetAll(RedisUserCacheEnum::REDIS_CACHE_PREFIX_KEY . $item);
            if ($redisOpenid) {
                $userInfo[] = $redisOpenid;
            }
        }
        return $userInfo;
    }

    /**
     * delete user info from redis
     *
     * @param string $openid
     *
     * @return int
     */
    public function deleteCacheFromRedis(string $openid): int
    {
        return Redis::del(RedisUserCacheEnum::REDIS_CACHE_PREFIX_KEY . $openid);
    }
}
