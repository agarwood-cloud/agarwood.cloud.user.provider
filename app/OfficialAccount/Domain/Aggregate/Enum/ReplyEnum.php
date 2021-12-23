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

/**
 * Class ReplyEnum
 *
 * @package App\Model\Enum
 */
class ReplyEnum
{
    /**
     * 自动回复
     */
    public const AUTO_REPLY_TYPE = 'auto';

    /**
     * 快捷回复
     */
    public const QUICK_REPLY_TYPE = 'quick';

    /**
     * 自动回复的 event_key
     */
    public const EVENT_KEY = 'LOOKING_FOR_HELP';
}
