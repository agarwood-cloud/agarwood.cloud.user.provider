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

use App\OfficialAccount\Interfaces\Rpc\Client\OrderCenter\FansTimelineOrderRpc;
use Agarwood\Rpc\OrderCenter\OrderCenterFansTimelineOrderRpcInterface;
use Swoft\Rpc\Client\Annotation\Mapping\Reference;

/**
 * @\Swoft\Bean\Annotation\Mapping\Bean()
 */
class FansTimelineOrderRpcImpl implements FansTimelineOrderRpc
{
    /**
     *  服务号的 RPC 服务接口
     *
     * @Reference(pool="order.center.pool")
     *
     * @var OrderCenterFansTimelineOrderRpcInterface
     */
    protected OrderCenterFansTimelineOrderRpcInterface $timelineOrderRpc;

    /**
     * 粉丝订单
     *
     * @param string $openid
     *
     * @return array
     */
    public function timelineOrderByOpenid(string $openid): array
    {
        return $this->timelineOrderRpc->timelineOrderByOpenid($openid);
    }
}
