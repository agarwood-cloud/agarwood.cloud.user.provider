<?php declare(strict_types=1);
/**
 * This file is part of Agarwood Cloud.
 *
 * @link     https://www.agarwood-cloud.com
 * @document https://www.agarwood-cloud.com/docs
 * @contact  676786620@qq.com
 * @author   agarwood
 */

namespace App\OfficialAccount\Infrastructure\Cache\Impl;

use App\OfficialAccount\Infrastructure\Cache\Enum\RedisUserCacheEnum;
use App\OfficialAccount\Infrastructure\Cache\RedisUser;
use Swoft\Redis\Redis;

/**
 * @\Swoft\Bean\Annotation\Mapping\Bean()
 */
class RedisUserImpl implements RedisUser
{
    /**
     * 把粉丝的数据缓存到redis
     *
     * @param string $openid
     * @param array  $attributes
     *
     * @return bool
     */
    public function setCacheToRedis(string $openid, array $attributes): bool
    {
        return Redis::hMSet(RedisUserCacheEnum::REDIS_CACHE_PREFIX_KEY . $openid, $attributes);
    }

    /**
     * 读取redis的粉丝缓存数据
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
     * 获取用户的缓存信息
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
     * 删除redis的缓存信息
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
