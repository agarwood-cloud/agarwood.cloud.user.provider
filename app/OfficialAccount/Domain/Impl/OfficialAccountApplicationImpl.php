<?php declare(strict_types=1);
/**
 * This file is part of Agarwood Cloud.
 *
 * @link     https://www.agarwood-cloud.com
 * @document https://www.agarwood-cloud.com/docs
 * @contact  676786620@qq.com
 * @author   agarwood
 */

namespace App\OfficialAccount\Domain\Impl;

use App\OfficialAccount\Domain\OfficialAccountApplication;
use EasyWeChat\OfficialAccount\Application;

/**
 * @\Swoft\Bean\Annotation\Mapping\Bean()
 */
class OfficialAccountApplicationImpl implements OfficialAccountApplication
{
    /**
     * EasyWeChat OfficialAccount Application
     *
     * @param int $appId
     *
     * @return \EasyWeChat\OfficialAccount\Application
     */
    public function getOfficialAccount(int $appId): Application
    {
    }
}
