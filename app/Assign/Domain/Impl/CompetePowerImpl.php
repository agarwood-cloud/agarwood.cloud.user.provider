<?php declare(strict_types=1);
/**
 * This file is part of Agarwood Cloud.
 *
 * @link     https://www.agarwood-cloud.com
 * @document https://www.agarwood-cloud.com/docs
 * @contact  676786620@qq.com
 * @author   agarwood
 */

namespace App\Assign\Domain\Impl;

use App\Assign\Domain\Aggregate\Repository\AssignRepository;
use App\Assign\Domain\CompetePower;
use App\OfficialAccount\Interfaces\Rpc\Client\OrderCenter\CompetitiveRpc;
use Carbon\Carbon;

/**
 * @\Swoft\Bean\Annotation\Mapping\Bean()
 */
class CompetePowerImpl implements CompetePower
{
    /**
     * @\Swoft\Bean\Annotation\Mapping\Inject()
     *
     * @var CompetitiveRpc
     */
    protected CompetitiveRpc $competitiveRpc;

    /**
     * @\Swoft\Bean\Annotation\Mapping\Inject()
     *
     * @var \App\Assign\Domain\Aggregate\Repository\AssignRepository
     */
    protected AssignRepository $assignRepository;

    /**
     * 计算单个客服的综合竞争力
     *      综合竞争力 = 5天业绩 * 0.65 - 5天新粉 * 粉丝单价 - 1000
     *
     * @inheritDoc
     */
    public function computedPower(int $customerId, int $fansPrice = 100, int $days = 5): int
    {
        //综合竞争力 = 5天业绩 * 0.65 - 5天新粉 * 粉丝单价 - 1000
        // 计算该客服的 5天业绩 该客服5天的业绩
        $trade = $this->competitiveRpc->daysTrade($customerId, $days);
        $trade /= 100;   // 将数据除以 100

        // 时间
        $startAt = Carbon::now()->subDays($days)->toDateTimeString();
        $endAt   = Carbon::now()->toDateTimeString();

        // 客服5天新进来的粉丝
        $fans = $this->assignRepository->daysFans($customerId, $startAt, $endAt);

        // 综合竞争力 = 5天业绩 * 0.65 - 5天新粉 * 粉丝单价 - 1000
        $power = $trade * 0.65 - $fans * $fansPrice - 1000;
        return (int)$power;
    }
}
