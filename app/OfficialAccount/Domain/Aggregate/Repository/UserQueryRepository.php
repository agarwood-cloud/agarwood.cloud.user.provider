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
interface UserQueryRepository
{
    /**
     * @param string $openid
     *
     * @return array
     */
    public function findByOpenid(string $openid): array;
}
