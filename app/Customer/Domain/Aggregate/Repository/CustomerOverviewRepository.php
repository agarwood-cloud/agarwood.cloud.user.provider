<?php
declare(strict_types=1);
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
interface CustomerOverviewRepository
{
    /**
     * 管理员管理列表数据
     *
     * @param int   $tencentId
     * @param array $filter
     *
     * @return array
     */
    public function index(int $tencentId, array $filter): array;
}
