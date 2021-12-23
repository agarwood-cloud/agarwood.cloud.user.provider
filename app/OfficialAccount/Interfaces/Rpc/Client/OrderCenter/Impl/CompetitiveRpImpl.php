<?php declare(strict_types=1);
/**
 * This file is part of Agarwood Cloud.
 *
 * @link     https://www.agarwood-cloud.com
 * @document https://www.agarwood-cloud.com/docs
 * @contact  676786620@qq.com
 * @author   agarwood
 */

namespace App\OfficialAccount\Interfaces\Rpc\Client\OrderCenter\Impl;

use Agarwood\Rpc\OrderCenter\OrderCenterCustomerOverviewRpcInterface;
use App\OfficialAccount\Interfaces\Rpc\Client\OrderCenter\CompetitiveRpc;
use Swoft\Rpc\Client\Annotation\Mapping\Reference;

/**
 * @\Swoft\Bean\Annotation\Mapping\Bean()
 */
class CompetitiveRpImpl implements CompetitiveRpc
{
    /**
     *  服务号的 RPC 服务接口
     *
     * @Reference(pool="order.center.pool")
     *
     * @var OrderCenterCustomerOverviewRpcInterface
     */
    protected OrderCenterCustomerOverviewRpcInterface $serviceRpc;

    /**
     * 客服xx天的销售业绩
     *
     * @param int $customerId
     * @param int    $days
     *
     * @return array
     */
    public function daysTrade(int $customerId, int $days): array
    {
        return $this->serviceRpc->customerDaysTrade($customerId, $days);
    }
}
