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
     * 系统消息
     */
    public const SYSTEM_MESSAGE = '【系统消息】';

    /**
     * 文本消息
     */
    public const SERVER_TEXT_MESSAGE = 'server.text.message';

    /**
     * 视频消息
     */
    public const SERVER_VIDEO_MESSAGE = 'server.video.message';

    /**
     * 声音消息
     */
    public const SERVER_VOICE_MESSAGE = 'server.voice.message';

    /**
     * 图片消息
     */
    public const SERVER_IMAGE_MESSAGE = 'server.image.message';

    /**
     * 图文消息
     */
    public const SERVER_NEWS_ITEM_MESSAGE = 'server.news.item.message';

    /**
     * 错误提示消息
     */
    public const SERVER_ERROR_MESSAGE = 'server.error.message';
}
