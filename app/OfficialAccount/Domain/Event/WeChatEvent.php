<?php declare(strict_types=1);
/**
 * This file is part of Agarwood Cloud.
 *
 * @link     https://www.agarwood-cloud.com
 * @document https://www.agarwood-cloud.com/docs
 * @contact  676786620@qq.com
 * @author   agarwood
 */

namespace App\OfficialAccount\Domain\Event;

/**
 * 微信回调信息事件
  *
 */
class WeChatEvent
{
    /**
     * 微信事件消息 subscribe(订阅)
     */
    public const OFFICIAL_ACCOUNT_EVENT_SUBSCRIBE = 'wechat.event.subscribe';

    /**
     * 微信事件消息 unsubscribe(取消订阅)
     */
    public const OFFICIAL_ACCOUNT_EVENT_UNSUBSCRIBE = 'wechat.event.unsubscribe';

    /**
     * 微信事件消息 CLICK(点击事件)
     */
    public const OFFICIAL_ACCOUNT_EVENT_CLICK = 'wechat.event.click';

    /**
     * 微信事件消息 SCAN(关注扫码事件)
     */
    public const OFFICIAL_ACCOUNT_EVENT_SCAN = 'wechat.event.scan';

    /**
     * 微信事件消息 VIEW(点击菜单事件)
     */
    public const OFFICIAL_ACCOUNT_EVENT_VIEW = 'wechat.event.view';

    /**
     * 微信收到文本消息
     */
    public const OFFICIAL_ACCOUNT_TEXT = 'wechat.text';

    /**
     * 微信图片消息
     */
    public const OFFICIAL_ACCOUNT_IMAGE = 'wechat.image';

    /**
     * 微信语音消息
     */
    public const OFFICIAL_ACCOUNT_VOICE = 'wechat.voice';

    /**
     * 微信视频消息
     */
    public const OFFICIAL_ACCOUNT_VIDEO = 'wechat.video';

    /**
     * 微信坐标消息
     */
    public const OFFICIAL_ACCOUNT_LOCATION = 'wechat.location';

    /**
     * 微信链接消息
     */
    public const OFFICIAL_ACCOUNT_LINK = 'wechat.link';

    /**
     * 微信文件消息
     */
    public const OFFICIAL_ACCOUNT_FILE = 'wechat.file';

    /**
     * 微信默认消息
     */
    public const OFFICIAL_ACCOUNT_DEFAULT = 'wechat.default';
}
