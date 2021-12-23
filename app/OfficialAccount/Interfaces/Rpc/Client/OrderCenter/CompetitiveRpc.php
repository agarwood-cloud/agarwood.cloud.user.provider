<?php declare(strict_types=1);
/**
 * This file is part of Agarwood Cloud.
 *
 * @link     https://www.agarwood-cloud.com
 * @document https://www.agarwood-cloud.com/docs
 * @contact  676786620@qq.com
 * @author   agarwood
 */

namespace App\OfficialAccount\Interfaces\Rpc\Client\OrderCenter;

/**
 * @\Swoft\Bean\Annotation\Mapping\Bean()
 */
interface CompetitiveRpc
{
    /**
     * 客服xx天销售额
     *
     * @param int $customerId
     * @param int    $days
     *
     * @return array
     */
    public function daysTrade(int $customerId, int $days): array;
}
