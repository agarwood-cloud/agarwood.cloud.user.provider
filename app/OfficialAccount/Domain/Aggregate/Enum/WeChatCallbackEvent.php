<?php declare(strict_types=1);
/**
 * This file is part of Agarwood Cloud.
 *
 * @link     https://www.agarwood-cloud.com
 * @document https://www.agarwood-cloud.com/docs
 * @contact  676786620@qq.com
 * @author   agarwood
 */

namespace App\OfficialAccount\Domain\Aggregate\Enum;

class WeChatCallbackEvent
{
    /**
     * 关注事件
     */
    public const SUBSCRIBE = 'subscribe';

    /**
     * 取消关注事件
     */
    public const UNSUBSCRIBE = 'unsubscribe';

    /**
     * 扫码事件
     */
    public const SCAN = 'SCAN';

    /**
     * 点击事件
     */
    public const CLICK = 'CLICK';

    /**
     * 点击菜单跳转链接时的事件推送
     */
    public const VIEW = 'VIEW';
}
