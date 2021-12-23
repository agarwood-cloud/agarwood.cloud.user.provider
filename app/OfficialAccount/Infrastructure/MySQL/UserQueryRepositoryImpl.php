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

use App\OfficialAccount\Domain\Aggregate\Entity\User;
use App\OfficialAccount\Domain\Aggregate\Repository\UserQueryRepository;
use Swoft\Db\DB;

/**
 * @\Swoft\Bean\Annotation\Mapping\Bean()
 */
class UserQueryRepositoryImpl implements UserQueryRepository
{
    /**
     * @param string $openid
     *
     * @return array
     */
    public function findByOpenid(string $openid): array
    {
        return DB::table(User::tableName())
            ->select()
            ->where('openid', '=', $openid)
            ->firstArray();
    }
}
