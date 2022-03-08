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
 * @deprecated 暂时不用
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
    public function allSubscribeFans(int $platformId): array
    {
        return $this->userRpcRepository->subscribeFans($platformId);
    }

    /**
     * 今天粉丝新增粉丝
     *
     * @inheritDoc
     * @throws DbException
     */
    public function theDayFans(int $platformId, string $startAt, string $endAt): array
    {
        return $this->userRpcRepository->theDayFans($platformId, $startAt, $endAt);
    }

    /**
     * 当天取消关注的粉丝
     *
     * @inheritDoc
     * @throws DbException
     */
    public function theDayUnsubscribeFans(int $platformId, string $startAt, string $endAt): array
    {
        return $this->userRpcRepository->theDayUnsubscribeFans($platformId, $startAt, $endAt);
    }

    /**
     * 时间段内关注粉丝的成交的openid
     *
     * @param int $platformId
     * @param array  $openid
     * @param string $startAt
     * @param string $endAt
     *
     * @return array
     */
    public function turnoverTimeIntervalOpenid(int $platformId, array $openid, string $startAt, string $endAt): array
    {
        return $this->userRpcRepository->turnoverTimeIntervalOpenid($platformId, $openid, $startAt, $endAt);
    }

    /**
     * 时段分析：新增粉丝
     *
     * @param int $platformId
     * @param string $startAt
     * @param string $endAt
     *
     * @return array
     */
    public function userCenterTurnoverTimeFans(int $platformId, string $startAt, string $endAt): array
    {
        return $this->userRpcRepository->userCenterTurnoverTimeFans($platformId, $startAt, $endAt);
    }

    /**
     * 时段分析：新增粉丝
     *
     * @param int $platformId
     * @param array  $openid
     * @param string $startAt
     * @param string $endAt
     *
     * @return array
     */
    public function userCenterTurnoverTimeBuyFans(int $platformId, array $openid, string $startAt, string $endAt): array
    {
        return $this->userRpcRepository->userCenterTurnoverTimeBuyFans($platformId, $openid, $startAt, $endAt);
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
