<?php declare(strict_types=1);
/**
 * This file is part of Agarwood Cloud.
 *
 * @link     https://www.agarwood-cloud.com
 * @document https://www.agarwood-cloud.com/docs
 * @contact  676786620@qq.com
 * @author   agarwood
 */

namespace App\Customer\Infrastructure\Redis\Enum;

class RedisUserCacheEnum
{
    /**
     * 粉丝的缓存信息 前缀
     */
    public const REDIS_CACHE_PREFIX_KEY = 'OfficialAccount.user.info.';
}
