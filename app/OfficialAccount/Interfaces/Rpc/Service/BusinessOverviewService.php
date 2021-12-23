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

use App\OfficialAccount\Domain\Aggregate\Repository\UserRpcRepository;
use Agarwood\Rpc\UserCenter\UserCenterBusinessRpcInterface;
use Swoft\Db\Exception\DbException;
use Swoft\Rpc\Server\Annotation\Mapping\Service;

/**
 * @Service()
 */
class BusinessOverviewService implements UserCenterBusinessRpcInterface
{
    /**
     * @\Swoft\Bean\Annotation\Mapping\Inject()
     *
     * @var UserRpcRepository
     */
    protected UserRpcRepository $userRpcRepository;

    /**
     *  当前公众号关注的所有粉丝
     *
     * @inheritDoc
     * @throws DbException
     */
    public function allSubscribeFans(int $officialAccountsId): array
    {
        return $this->userRpcRepository->subscribeFans($officialAccountsId);
    }

    /**
     * 今天粉丝新增粉丝
     *
     * @inheritDoc
     * @throws DbException
     */
    public function theDayFans(int $officialAccountsId, string $startAt, string $endAt): array
    {
        return $this->userRpcRepository->theDayFans($officialAccountsId, $startAt, $endAt);
    }

    /**
     * 当天取消关注的粉丝
     *
     * @inheritDoc
     * @throws DbException
     */
    public function theDayUnsubscribeFans(int $officialAccountsId, string $startAt, string $endAt): array
    {
        return $this->userRpcRepository->theDayUnsubscribeFans($officialAccountsId, $startAt, $endAt);
    }

    /**
     * 时间段内关注粉丝的成交的openid
     *
     * @param int $officialAccountsId
     * @param array  $openid
     * @param string $startAt
     * @param string $endAt
     *
     * @return array
     */
    public function turnoverTimeIntervalOpenid(int $officialAccountsId, array $openid, string $startAt, string $endAt): array
    {
        return $this->userRpcRepository->turnoverTimeIntervalOpenid($officialAccountsId, $openid, $startAt, $endAt);
    }

    /**
     * 时段分析：新增粉丝
     *
     * @param int $officialAccountsId
     * @param string $startAt
     * @param string $endAt
     *
     * @return array
     */
    public function userCenterTurnoverTimeFans(int $officialAccountsId, string $startAt, string $endAt): array
    {
        return $this->userRpcRepository->userCenterTurnoverTimeFans($officialAccountsId, $startAt, $endAt);
    }

    /**
     * 时段分析：新增粉丝
     *
     * @param int $officialAccountsId
     * @param array  $openid
     * @param string $startAt
     * @param string $endAt
     *
     * @return array
     */
    public function userCenterTurnoverTimeBuyFans(int $officialAccountsId, array $openid, string $startAt, string $endAt): array
    {
        return $this->userRpcRepository->userCenterTurnoverTimeBuyFans($officialAccountsId, $openid, $startAt, $endAt);
    }

    /**
     * The openid of fans who sold in a certain period of time
     *
     * @param array  $openid
     * @param string $startAt
     * @param string $endAt
     *
     * @return array
     */
    public function theDayTurnoverFansOpenid(array $openid, string $startAt, string $endAt): array
    {
        return $this->userRpcRepository->theDayTurnoverFansOpenid($openid, $startAt, $endAt);
    }
}
