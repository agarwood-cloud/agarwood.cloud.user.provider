<?php declare(strict_types=1);
/**
 * This file is part of Agarwood Cloud.
 *
 * @link     https://www.agarwood-cloud.com
 * @document https://www.agarwood-cloud.com/docs
 * @contact  676786620@qq.com
 * @author   agarwood
 */

namespace App\Customer\Application\Impl;

use App\Customer\Application\CustomerOverviewApplication;
use App\Customer\Domain\CustomerOverviewDomainService;
use App\Customer\Interfaces\DTO\CustomerOverview\IndexDTO;

/**
 * @\Swoft\Bean\Annotation\Mapping\Bean()
 */
class CustomerOverviewApplicationImpl implements CustomerOverviewApplication
{
    /**
     * 领域服务
     *
     * @\Swoft\Bean\Annotation\Mapping\Inject()
     *
     * @var \App\Customer\Domain\CustomerOverviewDomainService
     */
    public CustomerOverviewDomainService $domain;

    /**
     * @inheritDoc
     */
    public function indexProvider(int $tencentId, IndexDTO $DTO): array
    {
        // todo: 待加入其它的数据统计信息
        return $this->domain->index($tencentId, $DTO->toArrayLine());
    }
}
