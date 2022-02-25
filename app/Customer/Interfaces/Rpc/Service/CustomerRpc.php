<?php declare(strict_types=1);
/**
 * This file is part of Agarwood Cloud.
 *
 * @link     https://www.agarwood-cloud.com
 * @document https://www.agarwood-cloud.com/docs
 * @contact  676786620@qq.com
 * @author   agarwood
 */

namespace App\Customer\Interfaces\Rpc\Service;

use Agarwood\Rpc\UserCenter\UserCenterCustomerRpcInterface;
use App\Customer\Domain\Aggregate\Repository\CustomerRpcRepository;

/**
 * @\Swoft\Rpc\Server\Annotation\Mapping\Service()
 */
class CustomerRpc implements UserCenterCustomerRpcInterface
{
    /**
     * @\Swoft\Bean\Annotation\Mapping\Inject()
     *
     * @var \App\Customer\Domain\Aggregate\Repository\CustomerRpcRepository
     */
    protected CustomerRpcRepository $customerRpcRepository;

    /**
     * @param int $id
     *
     * @return array
     */
    public function getCustomerRpcRepository(int $id): array
    {
        return [];
    }

    /**
     * 销售圈粉数量
     *
     * @param int    $customerId
     * @param string $startAt
     * @param string $endAt
     *
     * @return array
     */
    public function customerObtainFans(int $customerId, string $startAt, string $endAt): array
    {
        return [];
    }

    public function index(int $tencentId, int $pge = 1, int $perPage = 10): array
    {
        return [];
    }

    public function view(int $id): array
    {
        return [];
    }

    public function customerForFans(string $openid): array
    {
        return [];
    }

    /**
     * login
     *
     * @param int    $tencentId
     * @param string $username
     *
     * @return array
     */
    public function login(int $tencentId, string $username): array
    {
        return $this->customerRpcRepository->login($tencentId, $username);
    }
}
