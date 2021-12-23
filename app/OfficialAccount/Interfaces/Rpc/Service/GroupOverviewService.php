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
     * @param int   $officialAccountsId
     * @param array $filter
     *
     * @return array
     */
    public function groupForCustomer(int $officialAccountsId, array $filter): array
    {
        return $this->groupOverviewRpcDao->groupForCustomer($officialAccountsId, $filter);
    }

    /**
     * 时间段内的新增粉丝
     *
     * @param int    $officialAccountsId
     * @param array  $customerUuid
     * @param string $startAt
     * @param string $endAt
     *
     * @return array
     */
    public function groupForCustomerOpenid(int $officialAccountsId, array $customerUuid, string $startAt, string $endAt): array
    {
        return $this->groupOverviewRpcDao->groupForCustomerOpenid($officialAccountsId, $customerUuid, $startAt, $endAt);
    }

    /**
     * 每个小组的新增粉丝数量 【新粉数量】
     *
     * @param int    $officialAccountsId
     * @param array  $customerUuid
     * @param string $startAt
     * @param string $endAt
     *
     * @return array
     */
    public function groupForNewFansSum(int $officialAccountsId, array $customerUuid, string $startAt, string $endAt): array
    {
        return $this->groupOverviewRpcDao->groupForNewFansSum($officialAccountsId, $customerUuid, $startAt, $endAt);
    }

    /**
     * 新粉成交数量
     *
     * @param int    $officialAccountsId
     * @param array  $customerUuid
     * @param array  $openid
     * @param string $startAt
     * @param string $endAt
     *
     * @return array
     */
    public function groupFromSalesFansSum(int $officialAccountsId, array $customerUuid, array $openid, string $startAt, string $endAt): array
    {
        return $this->groupOverviewRpcDao->groupFromSalesFansSum($officialAccountsId, $customerUuid, $openid, $startAt, $endAt);
    }
}
