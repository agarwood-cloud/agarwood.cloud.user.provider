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

class SubscriberEnum
{
    /**
     * Send message to Tencent
     */
    public const REDIS_PUBLISH_WECHAT_CHAT_CHANNEL = 'chat.wechat.to.tencent';

    /**
     * Handle messages sent by Tencent
     */
    public const REDIS_SUBSCRIBER_WECHAT_CHAT_CHANNEL = 'chat.wechat.from.tencent';
}
