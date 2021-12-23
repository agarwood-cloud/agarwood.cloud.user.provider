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
interface WelcomeSubscribeDomain
{
    /**
     * 点击菜单自动回复
     *
     * @param int                                     $officialAccountId
     * @param \EasyWeChat\OfficialAccount\Application $application
     */
    public function autoReply(int $officialAccountId, Application $application): void;

    /**
     * 欢迎关注语
     *
     * @param int                                     $officialAccountId
     * @param \EasyWeChat\OfficialAccount\Application $application
     */
    public function welcomeSubscribe(int $officialAccountId, Application $application): void;
}
