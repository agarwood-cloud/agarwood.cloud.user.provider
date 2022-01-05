<?php declare(strict_types=1);
/**
 * This file is part of Agarwood Cloud.
 *
 * @link     https://www.agarwood-cloud.com
 * @document https://www.agarwood-cloud.com/docs
 * @contact  676786620@qq.com
 * @author   agarwood
 */

namespace App\OfficialAccount\Infrastructure\Redis;

/**
 * @\Swoft\Bean\Annotation\Mapping\Bean()
 */
interface RedisUser
{
    /**
     * Set cache to redis
     *
     * @param string $openid
     * @param array  $attributes
     *
     * @return bool
     */
    public function setCacheToRedis(string $openid, array $attributes): bool;

    /**
     * Get a User Cache from Redis
     *
     * @param string $openid
     *
     * @return array
     */
    public function getCacheFromRedis(string $openid): array;

    /**
     * Get Users Cache from Redis
     *
     * @param array $openid
     *
     * @return array
     */
    public function getUsersCacheFromRedis(array $openid): array;

    /**
     * delete user cache from redis
     *
     * @param string $openid
     *
     * @return int
     */
    public function deleteCacheFromRedis(string $openid): int;
}
