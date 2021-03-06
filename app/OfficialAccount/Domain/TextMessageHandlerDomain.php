<?php declare(strict_types=1);
/**
 * This file is part of Agarwood Cloud.
 *
 * @link     https://www.agarwood-cloud.com
 * @document https://www.agarwood-cloud.com/docs
 * @contact  676786620@qq.com
 * @author   agarwood
 */

namespace App\OfficialAccount\Domain;

use EasyWeChat\OfficialAccount\Application;

/**
 * @\Swoft\Bean\Annotation\Mapping\Bean()
 */
interface TextMessageHandlerDomain
{
    /**
     * @param int                                     $platformId
     * @param \EasyWeChat\OfficialAccount\Application $application
     */
    public function textMessage(int $platformId, Application $application): void;
}
