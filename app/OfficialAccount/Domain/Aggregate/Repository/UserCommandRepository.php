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
 */
interface UserCommandRepository
{
    /**
     * 新建用户
     *
     * @param array $attributes
     *
     * @return bool
     */
    public function addUserFromWeChat(array $attributes): bool;

    /**
     * 更新用户信息
     *
     * @param string $openid
     * @param array  $attributes
     *
     * @return int
     */
    public function updateByOpenidFromWeChat(string $openid, array $attributes): int;

    /**
     * 更新用户信息
     *
     * @param string $openid
     * @param array  $attributes
     *
     * @return int
     */
    public function updateByOpenid(string $openid, array $attributes): int;
}
