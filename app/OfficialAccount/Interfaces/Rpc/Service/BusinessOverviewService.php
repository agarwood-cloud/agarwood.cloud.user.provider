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
    public function allSubscribeFans(int $tencentId): array
    {
        return $this->userRpcRepository->subscribeFans($tencentId);
    }

    /**
     * 今天粉丝新增粉丝
     *
     * @inheritDoc
     * @throws DbException
     */
    public function theDayFans(int $tencentId, string $startAt, string $endAt): array
    {
        return $this->userRpcRepository->theDayFans($tencentId, $startAt, $endAt);
    }

    /**
     * 当天取消关注的粉丝
     *
     * @inheritDoc
     * @throws DbException
     */
    public function theDayUnsubscribeFans(int $tencentId, string $startAt, string $endAt): array
    {
        return $this->userRpcRepository->theDayUnsubscribeFans($tencentId, $startAt, $endAt);
    }

    /**
     * 时间段内关注粉丝的成交的openid
     *
     * @param int $tencentId
     * @param array  $openid
     * @param string $startAt
     * @param string $endAt
     *
     * @return array
     */
    public function turnoverTimeIntervalOpenid(int $tencentId, array $openid, string $startAt, string $endAt): array
    {
        return $this->userRpcRepository->turnoverTimeIntervalOpenid($tencentId, $openid, $startAt, $endAt);
    }

    /**
     * 时段分析：新增粉丝
     *
     * @param int $tencentId
     * @param string $startAt
     * @param string $endAt
     *
     * @return array
     */
    public function userCenterTurnoverTimeFans(int $tencentId, string $startAt, string $endAt): array
    {
        return $this->userRpcRepository->userCenterTurnoverTimeFans($tencentId, $startAt, $endAt);
    }

    /**
     * 时段分析：新增粉丝
     *
     * @param int $tencentId
     * @param array  $openid
     * @param string $startAt
     * @param string $endAt
     *
     * @return array
     */
    public function userCenterTurnoverTimeBuyFans(int $tencentId, array $openid, string $startAt, string $endAt): array
    {
        return $this->userRpcRepository->userCenterTurnoverTimeBuyFans($tencentId, $openid, $startAt, $endAt);
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
