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

use App\Customer\Application\CustomerInspectApplication;
use App\Customer\Interfaces\DTO\Customer\CustomerServiceIndexDTO;

/**
 * @\Swoft\Bean\Annotation\Mapping\Bean()
 */
class CustomerInspectApplicationImpl implements CustomerInspectApplication
{
    /**
     * @inheritDoc
     */
    public function indexProvider(CustomerServiceIndexDTO $DTO, bool $isPagination = true): array
    {
        return [];
    }

    /**
     * @inheritDoc
     */
    public function viewProvider(string $uuid): array
    {
        return [];
    }
}
