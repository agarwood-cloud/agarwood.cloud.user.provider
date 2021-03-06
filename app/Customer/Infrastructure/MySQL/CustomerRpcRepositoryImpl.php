<?php declare(strict_types=1);
/**
 * This file is part of Agarwood Cloud.
 *
 * @link     https://www.agarwood-cloud.com
 * @document https://www.agarwood-cloud.com/docs
 * @contact  676786620@qq.com
 * @author   agarwood
 */

namespace App\Customer\Infrastructure\MySQL;

use App\Customer\Domain\Aggregate\Entity\Customer;
use App\Customer\Domain\Aggregate\Enum\CustomerStatusEnum;
use App\Customer\Domain\Aggregate\Repository\CustomerRpcRepository;
use Swoft\Db\DB;

/**
 * @\Swoft\Bean\Annotation\Mapping\Bean()
 */
class CustomerRpcRepositoryImpl implements CustomerRpcRepository
{
    /**
     * @param int    $platformId
     * @param string $username
     *
     * @return array
     */
    public function login(int $platformId, string $username): array
    {
        return DB::table(Customer::tableName())
            ->select(
                'id',
                'enterprise_id as enterpriseId',
                'platform_id as platformId',
                'name',
                'account',
                'phone',
                'group_name as groupName',
                'group_id as groupId',
                'created_at as createdAt',
                'password',
                'status'
            )
            ->where('account', '=', $username)
            ->where('platform_id', '=', $platformId)
            ->where('status', '=', CustomerStatusEnum::USABLE)
            ->firstArray();
    }
}
