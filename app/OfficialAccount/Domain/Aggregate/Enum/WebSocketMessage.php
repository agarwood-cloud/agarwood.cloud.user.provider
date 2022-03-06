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

class WebSocketMessage
{
    /**
     * 文本消息
     */
    public const TEXT_MESSAGE = 'text.message';

    /**
     * 视频消息
     */
    public const VIDEO_MESSAGE = 'video.message';

    /**
     * 声音消息
     */
    public const VOICE_MESSAGE = 'voice.message';

    /**
     * 图片消息
     */
    public const IMAGE_MESSAGE = 'image.message';

    /**
     * 图文消息
     */
    public const NEWS_ITEM_MESSAGE = 'news.item.message';

    /**
     * 错误提示消息
     */
    public const ERROR_MESSAGE = 'error.message';

    /**
     * 系统消息
     */
    public const SYSTEM_MESSAGE = 'system.message';

    /**
     * 坐标信息
     */
    public const LOCATION_MESSAGE = 'location.message';

    /**
     * 链接消息
     */
    public const LINK_MESSAGE = 'link.message';
}
