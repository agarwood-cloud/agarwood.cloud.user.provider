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
use App\OfficialAccount\Domain\Aggregate\Repository\UserRpcRepository;

/**
 * @\Swoft\Rpc\Server\Annotation\Mapping\Service()
 */
class CustomerForFansService implements UserCenterCustomerRpcInterface
{
    /**
     * @\Swoft\Bean\Annotation\Mapping\Inject()
     *
     * @var UserRpcRepository
     */
    protected UserRpcRepository $userRpcDao;

    /**
     * 获取fans对应的customer的详细信息
     *
     * @param string $openid
     *
     * @return array
     */
    public function customerForFans(string $openid): array
    {
        return $this->userRpcDao->customerForFans($openid);
    }

    public function customerObtainFans(int $customerId, string $startAt, string $endAt): array
    {
        // TODO: Implement customerObtainFans() method.
    }

    public function index(int $officialAccountId, int $pge = 1, int $perPage = 10): array
    {
        // TODO: Implement index() method.
    }

    public function view(int $id): array
    {
        // TODO: Implement view() method.
    }
}
