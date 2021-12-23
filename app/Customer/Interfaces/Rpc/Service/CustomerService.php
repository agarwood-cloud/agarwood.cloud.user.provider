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

use App\Customer\Domain\Aggregate\Repository\CustomerRepository;
use Agarwood\Rpc\UserCenter\UserCenterCustomerRpcInterface;
use Swoft\Rpc\Server\Annotation\Mapping\Service;

/**
 * @Service()
 */
class CustomerService implements UserCenterCustomerRpcInterface
{
    /**
     * @\Swoft\Bean\Annotation\Mapping\Inject()
     *
     * @var CustomerRepository
     */
    protected CustomerRepository $customer;

    public function getCustomer(int $id): array
    {
        return $this->customer->view($id);
    }

    /**
     * 销售圈粉数量
     *
     * @param int $customerId
     * @param string $startAt
     * @param string $endAt
     *
     * @return array
     */
    public function customerObtainFans(int $customerId, string $startAt, string $endAt): array
    {
        return $this->customer->obtainFans($customerId, $startAt, $endAt);
    }

    public function index(int $officialAccountId, int $pge = 1, int $perPage = 10): array
    {
        return ['暂时未实现'];
    }

    public function view(int $id): array
    {
        return ['暂时未实现'];
    }

    public function customerForFans(string $openid): array
    {
        // TODO: Implement customerForFans() method.
    }
}
