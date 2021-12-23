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
     * 把粉丝的数据缓存到redis
     *
     * @param string $openid
     * @param array  $attributes
     *
     * @return bool
     */
    public function setCacheToRedis(string $openid, array $attributes): bool;

    /**
     * 读取redis的粉丝缓存数据
     *
     * @param string $openid
     *
     * @return array
     */
    public function getCacheFromRedis(string $openid): array;

    /**
     * 读取redis的粉丝缓存数据
     *
     * @param array $openid
     *
     * @return array
     */
    public function getUsersCacheFromRedis(array $openid): array;

    /**
     * 删除redis的缓存信息
     *
     * @param string $openid
     *
     * @return int
     */
    public function deleteCacheFromRedis(string $openid): int;
}
