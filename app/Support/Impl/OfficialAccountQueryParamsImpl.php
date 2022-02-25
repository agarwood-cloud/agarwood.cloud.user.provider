<?php declare(strict_types=1);
/**
 * This file is part of Agarwood Cloud.
 *
 * @link     https://www.agarwood-cloud.com
 * @document https://www.agarwood-cloud.com/docs
 * @contact  676786620@qq.com
 * @author   agarwood
 */

namespace App\Support\Impl;

use App\Support\OfficialAccountQueryParams;

/**
 * @\Swoft\Bean\Annotation\Mapping\Bean()
 */
class OfficialAccountQueryParamsImpl implements OfficialAccountQueryParams
{
    /**
     * @return int|null
     */
    public function getOfficialAccountId(): int|null
    {
        // bugfix: 前端发整型，但接收的变为字符串
        $platformId = context()->getRequest()->get('officialAccountId');
        return is_numeric($platformId) ? (int)$platformId : null;
    }
}
