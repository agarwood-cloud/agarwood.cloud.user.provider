<?php declare(strict_types=1);
/**
 * This file is part of Agarwood Cloud.
 *
 * @link     https://www.agarwood-cloud.com
 * @document https://www.agarwood-cloud.com/docs
 * @contact  676786620@qq.com
 * @author   agarwood
 */

namespace App\Customer\Domain\Aggregate\Repository;

/**
 * @\Swoft\Bean\Annotation\Mapping\Bean()
 */
interface GroupOverviewRpcRepository
{
    /**
     * 分组下的所有客服信息
     *
     * @param int   $tencentId
     * @param array $filter
     *
     * @return array
     */
    public function groupForCustomer(int $tencentId, array $filter): array;

    /**
     * 时间段内的新增粉丝
     *
     * @param int    $tencentId
     * @param array  $customerId
     * @param string $startAt
     * @param string $endAt
     *
     * @return array
     */
    public function groupForCustomerOpenid(int $tencentId, array $customerId, string $startAt, string $endAt): array;

    /**
     * 每个小组的新增粉丝数量 【新粉数量】
     *
     * @param int    $tencentId
     * @param array  $customerId
     * @param string $startAt
     * @param string $endAt
     *
     * @return array
     */
    public function groupForNewFansSum(int $tencentId, array $customerId, string $startAt, string $endAt): array;

    /**
     * 新粉成交数量
     *
     * @param int    $tencentId
     * @param array  $customerId
     * @param array  $openid
     * @param string $startAt
     * @param string $endAt
     *
     * @return array
     */
    public function groupFromSalesFansSum(int $tencentId, array $customerId, array $openid, string $startAt, string $endAt): array;
}
