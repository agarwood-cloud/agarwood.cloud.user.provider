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
interface CustomerQueryRepository
{
    /**
     * 服务号管理列表数据
     *
     * @param array $filter
     * @param int   $platformId
     *
     * @return array
     */
    public function index(int $platformId, array $filter): array;

    /**
     * @param int $id
     *
     * @return array
     */
    public function view(int $id): array;
}
