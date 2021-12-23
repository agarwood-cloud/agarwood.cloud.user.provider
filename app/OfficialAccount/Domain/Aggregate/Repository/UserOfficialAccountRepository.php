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
interface UserOfficialAccountRepository
{
    /**
     * @param array $attributes
     *
     * @return array
     */
    public function addUserFromCode(array $attributes): array;

    /**
     * 更新已存在的粉丝信息
     *
     * @param string $openid
     * @param array  $attributes
     *
     * @return array
     */
    public function updateUserByOpenid(string $openid, array $attributes): array;
}
