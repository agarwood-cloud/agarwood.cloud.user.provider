<?php declare(strict_types=1);
/**
 * This file is part of Agarwood Cloud.
 *
 * @link     https://www.agarwood-cloud.com
 * @document https://www.agarwood-cloud.com/docs
 * @contact  676786620@qq.com
 * @author   agarwood
 */

namespace App\OfficialAccount\Infrastructure\NoSQL;

use MongoDB\Client;

class MongoClient
{
    /**
     * @var Client|null
     */
    protected static ?Client $singleton = null;

    /**
     * MongoClient constructor.
     */
    public static function getInstance(): Client
    {
        if (!self::$singleton instanceof Client) {
            self::$singleton = new Client(
                // todo  这里暂时没有加上账号密码
                sprintf(
                    'mongodb://%s:%s',
                    env('MONGODB_HOST', '127.0.0.1'),
                    env('MONGODB_PORT', '27017')
                ),
//                [
//                    'username' => env('MONGODB_USERNAME', 'admin'),
//                    'password' => env('MONGODB_PASSWORD', ''),
//                ]
            );
        }
        return self::$singleton;
    }
}
