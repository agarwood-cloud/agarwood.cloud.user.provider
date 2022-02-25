<?php declare(strict_types=1);
/**
 * This file is part of Agarwood Cloud.
 *
 * @link     https://www.agarwood-cloud.com
 * @document https://www.agarwood-cloud.com/docs
 * @contact  676786620@qq.com
 * @author   agarwood
 */

namespace App\Customer\Domain\Impl;

use App\Customer\Domain\Aggregate\Repository\CustomerOverviewRepository;
use App\Customer\Domain\CustomerOverviewDomainService;

/**
 * @\Swoft\Bean\Annotation\Mapping\Bean()
 */
class CustomerOverviewDomainServiceImpl implements CustomerOverviewDomainService
{
    /**
     * @\Swoft\Bean\Annotation\Mapping\Inject()
     *
     * @var \App\Customer\Domain\Aggregate\Repository\CustomerOverviewRepository
     */
    public CustomerOverviewRepository $customerOverviewRepository;

    /**
     * @param int $tencentId
     * @param array  $filter
     *
     * @return array
     */
    public function index(int $tencentId, array $filter): array
    {
        return $this->customerOverviewRepository->index($tencentId, $filter);
    }
}
