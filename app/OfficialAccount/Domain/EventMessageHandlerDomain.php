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
interface EventMessageHandlerDomain
{
    /**
     * 关注事件领域服务
     *
     * @param int         $officialAccountId
     * @param Application $application
     *
     * @return void
     */
    public function eventSubscribe(int $officialAccountId, Application $application): void;

    /**
     * 取消关注事件领域服务
     *
     * @param int         $officialAccountId
     * @param Application $application
     *
     * @return void
     */
    public function eventUnsubscribe(int $officialAccountId, Application $application): void;

    /**
     * 关注扫码事件领域服务
     *
     * @param int         $officialAccountId
     * @param Application $application
     *
     * @return void
     */
    public function eventScan(int $officialAccountId, Application $application): void;

    /**
     * 点击菜单拉取消息时的事件推送
     *
     * @param int         $officialAccountId
     * @param Application $application
     *
     * @return void
     */
    public function eventClick(int $officialAccountId, Application $application): void;

    /**
     * 点击菜单跳转链接时的事件推送
     *
     * @param int         $officialAccountId
     * @param Application $application
     *
     * @return void
     */
    public function eventView(int $officialAccountId, Application $application): void;
}
