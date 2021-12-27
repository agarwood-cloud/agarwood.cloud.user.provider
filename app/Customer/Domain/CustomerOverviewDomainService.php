<?php declare(strict_types=1);
/**
 * This file is part of Agarwood Cloud.
 *
 * @link     https://www.agarwood-cloud.com
 * @document https://www.agarwood-cloud.com/docs
 * @contact  676786620@qq.com
 * @author   agarwood
 */

namespace App\Customer\Domain;

/**
 * @\Swoft\Bean\Annotation\Mapping\Bean()
 */
interface CustomerOverviewDomainService
{
    /**
     * 领域服务接口： 获取列表
     *
     * @param int   $officialAccountId
     * @param array $filter 过滤条件
     *
     * @return array
     */
    public function index(int $officialAccountId, array $filter): array;
}
