<?php declare(strict_types=1);
/**
 * This file is part of Agarwood Cloud.
 *
 * @link     https://www.agarwood-cloud.com
 * @document https://www.agarwood-cloud.com/docs
 * @contact  676786620@qq.com
 * @author   agarwood
 */

namespace App\OfficialAccount\Infrastructure\NoSQL\Enum;

class MongoDBEnum
{
    /**
     * 聊天记录的集合前缀
     */
    public const MONGODB_COLLECTION_PREFIX = 'month_';

    /**
     * 聊天记录的文档集合前缀
     */
    public const MONGODB_DOCUMENT_PREFIX = 'chat_';
}
