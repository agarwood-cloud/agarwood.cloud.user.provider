<?php declare(strict_types=1);
/**
 * This file is part of Agarwood Cloud.
 *
 * @link     https://www.agarwood-cloud.com
 * @document https://www.agarwood-cloud.com/docs
 * @contact  676786620@qq.com
 * @author   agarwood
 */

namespace App\Assign\Domain;

/**
 * 计算综合竞争力
 *
 * @\Swoft\Bean\Annotation\Mapping\Bean()
 */
interface CompetePower
{
    /**
     * 计算单个客服的综合竞争力
     *      综合竞争力 = 5天业绩 * 0.65 - 5天新粉 * 粉丝单价 - 1000
     *
     * @param int $customerId
     * @param int $fansPrice
     * @param int $days
     *
     * @return int
     */
    public function computedPower(int $customerId, int $fansPrice = 100, int $days = 5): int;
}
