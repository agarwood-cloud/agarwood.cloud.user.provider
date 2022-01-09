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
     * @param string $username
     *
     * @return array
     */
    public function login(string $username): array
    {
        return DB::table(Customer::tableName())
            ->select()
            ->where('account', '=', $username)
            ->where('status', '=', CustomerStatusEnum::USABLE)
            ->firstArray();
    }
}
