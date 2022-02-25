<?php declare(strict_types=1);
/**
 * This file is part of Agarwood Cloud.
 *
 * @link     https://www.agarwood-cloud.com
 * @document https://www.agarwood-cloud.com/docs
 * @contact  676786620@qq.com
 * @author   agarwood
 */

namespace App\Customer\Application;

use App\Customer\Interfaces\DTO\CustomerOverview\IndexDTO;

/**
 * @\Swoft\Bean\Annotation\Mapping\Bean()
 */
interface CustomerOverviewApplication
{
    /**
     * @param int                                                    $platformId
     * @param \App\Customer\Interfaces\DTO\CustomerOverview\IndexDTO $DTO
     *
     * @return array
     */
    public function indexProvider(int $platformId, IndexDTO $DTO): array;
}
