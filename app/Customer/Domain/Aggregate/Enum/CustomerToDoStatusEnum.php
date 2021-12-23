<?php declare(strict_types=1);
/**
 * This file is part of Agarwood Cloud.
 *
 * @link     https://www.agarwood-cloud.com
 * @document https://www.agarwood-cloud.com/docs
 * @contact  676786620@qq.com
 * @author   agarwood
 */

namespace App\Customer\Domain\Aggregate\Enum;

class CustomerToDoStatusEnum
{
    /**
     * 待我处理
     */
    public const STATUS_TODO = 'todo';

    /**
     * 正在处理
     */
    public const STATUS_DOING = 'doing';

    /**
     * 已完成
     */
    public const STATUS_FINISHED = 'finish';
}
