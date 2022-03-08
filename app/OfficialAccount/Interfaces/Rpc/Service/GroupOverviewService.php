<?php declare(strict_types=1);
/**
 * This file is part of Agarwood Cloud.
 *
 * @link     https://www.agarwood-cloud.com
 * @document https://www.agarwood-cloud.com/docs
 * @contact  676786620@qq.com
 * @author   agarwood
 */

namespace App\OfficialAccount\Interfaces\Rpc\Service;

use Agarwood\Rpc\UserCenter\UserCenterGroupOverviewRpcInterface;
use App\Customer\Domain\Aggregate\Repository\GroupOverviewRpcRepository;

/**
 * @\Swoft\Rpc\Server\Annotation\Mapping\Service()
 * @deprecated 暂时不用
 */
class GroupOverviewService implements UserCenterGroupOverviewRpcInterface
{
    /**
     * @\Swoft\Bean\Annotation\Mapping\Inject()
     *
     * @var GroupOverviewRpcRepository
     */
    protected GroupOverviewRpcRepository $groupOverviewRpcDao;

    /**
     * 分组下的所有客服信息
     *
     * @param int   $platformId
     * @param array $filter
     *
     * @return array
     */
    public function groupForCustomer(int $platformId, array $filter): array
    {
        return $this->groupOverviewRpcDao->groupForCustomer($platformId, $filter);
    }

    /**
     * 时间段内的新增粉丝
     *
     * @param int    $platformId
     * @param array  $customerUuid
     * @param string $startAt
     * @param string $endAt
     *
     * @return array
     */
    public function groupForCustomerOpenid(int $platformId, array $customerUuid, string $startAt, string $endAt): array
    {
        return $this->groupOverviewRpcDao->groupForCustomerOpenid($platformId, $customerUuid, $startAt, $endAt);
    }

    /**
     * 每个小组的新增粉丝数量 【新粉数量】
     *
     * @param int    $platformId
     * @param array  $customerUuid
     * @param string $startAt
     * @param string $endAt
     *
     * @return array
     */
    public function groupForNewFansSum(int $platformId, array $customerUuid, string $startAt, string $endAt): array
    {
        return $this->groupOverviewRpcDao->groupForNewFansSum($platformId, $customerUuid, $startAt, $endAt);
    }

    /**
     * 新粉成交数量
     *
     * @param int    $platformId
     * @param array  $customerUuid
     * @param array  $openid
     * @param string $startAt
     * @param string $endAt
     *
     * @return array
     */
    public function groupFromSalesFansSum(int $platformId, array $customerUuid, array $openid, string $startAt, string $endAt): array
    {
        return $this->groupOverviewRpcDao->groupFromSalesFansSum($platformId, $customerUuid, $openid, $startAt, $endAt);
    }
}
