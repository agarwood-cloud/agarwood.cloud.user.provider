<?php declare(strict_types=1);

/**
 * This file is part of Agarwood Cloud.
 *
 * @link     https://www.agarwood-cloud.com
 * @document https://www.agarwood-cloud.com/docs
 * @contact  676786620@qq.com
 * @author   agarwood
 */

use Swoft\Crontab\Process\CrontabProcess;
use Swoft\Db\Database;
use Swoft\Http\Server\HttpServer;
use Swoft\Http\Server\Middleware\ValidatorMiddleware;
use Swoft\Log\Handler\FileHandler;
use Swoft\Redis\RedisDb;
use Swoft\Rpc\Client\Client as ServiceClient;
use Swoft\Rpc\Client\Pool as ServicePool;
use Swoft\Rpc\Server\ServiceServer;
use Swoft\Server\SwooleEvent;
use Swoft\Task\Swoole\FinishListener;
use Swoft\Task\Swoole\TaskListener;

return [
    // +------------------------------------------------------
    // | 加载 日志 配置文件
    // +------------------------------------------------------
    // 这里都是默认配置，暂时不作修改
    'lineFormatter'        => [
        'format'     => '%datetime% [%level_name%] [%channel%] [%event%] [tid:%tid%] [cid:%cid%] [traceid:%traceid%] [spanid:%spanid%] [parentid:%parentid%] %messages%',
        'dateFormat' => 'Y-m-d H:i:s',
    ],
    'noticeHandler'        => [
        'class'     => FileHandler::class,
        'logFile'   => '@runtime/logs/notice-%d{Y-m-d}.log',  // 2.0.6 支持日志按时间切割
        'formatter' => \bean('lineFormatter'),
        'levels'    => 'error',
    ],
    'applicationHandler'   => [
        'class'     => FileHandler::class,
        'logFile'   => '@runtime/logs/error.log',
        'formatter' => \bean('lineFormatter'),
        'levels'    => 'error,warning',
    ],
    'logger'               => [
        'flushRequest' => false,
        'enable'       => true,
        'handlers'     => [
            'application' => \bean('applicationHandler'),
            // 'notice'      => \bean('noticeHandler'),
        ],
    ],

    // +------------------------------------------------------
    // | 加载 session 配置文件 官方实现的暂时只是 driver = file
    // +------------------------------------------------------

    // +------------------------------------------------------
    // | 加载 RPC服务端 配置文件
    // +------------------------------------------------------
    'rpcServer'            => [
        'class'    => ServiceServer::class,
        'listener' => [
            //'http' => bean('httpServer'), 这里不能启动，除了单独开 rpc
        ],
        'port'     => env('RPC_SERVER_PORT', 18307),
    ],

    // +------------------------------------------------------
    // | 加载 HTTP服务端 配置文件
    // +------------------------------------------------------
    'httpServer'           => [
        'class'    => HttpServer::class,
        'port'     => env('HTTP_SERVER_PORT', 18306),
        'listener' => [
            'rpc' => bean('rpcServer'),
            // 'rpc' => bean('rpcServer'),
            // 'tcp' => bean('tcpServer'),
        ],
        'process'  => [
            // 'monitor' => bean(\App\Process\MonitorProcess::class)
            // 'crontab' => bean(CrontabProcess::class)
            'crontab'    => bean(CrontabProcess::class),
            // custom process for subscribers
            'subscriber' => bean(\App\OfficialAccount\Domain\Event\Subscriber\ChatSubscriber::class)
        ],
        'on'       => [
            // SwooleEvent::TASK   => bean(SyncTaskListener::class),  // Enable sync task
            SwooleEvent::TASK   => bean(TaskListener::class),  // Enable task must task and finish event
            SwooleEvent::FINISH => bean(FinishListener::class)
        ],
        /* @see HttpServer::$setting */
        'setting'  => [
            'task_worker_num'       => env('HTTP_SERVER_TASK_WORKER_NUM', 12),
            'task_enable_coroutine' => true,
            'worker_num'            => env('HTTP_SERVER_WORKER_NUM', 6),
            // static handle
            // 'enable_static_handler'    => true,
            // 'document_root'            => dirname(__DIR__) . '/public',
        ]
    ],
    'httpDispatcher'       => [
        // Add global http middleware
        'middlewares'      => [
            // \Agarwood\Core\Middleware\GuzzleHeaderMiddleware::class, //Guzzle 支持协程
            // \Agarwood\Core\Middleware\CorsMiddleware::class,
            //            \App\Http\Middleware\FavIconMiddleware::class,
            //            \Swoft\Whoops\WhoopsMiddleware::class,
        ],
        'afterMiddlewares' => [
            ValidatorMiddleware::class  //启用验证器
        ]
    ],

    // +------------------------------------------------------
    // | 加载配置文件
    // +------------------------------------------------------
    'config'               => [
        'path' => __DIR__ . '/../config',
        'env'  => env('APP_ENV', 'pro'),  // 根据不同的环境加载不同的配置
    ],

    // +------------------------------------------------------
    // |  数据库配置
    // +------------------------------------------------------
    'db'                   => [
        'class'    => Database::class,
        'dsn'      => sprintf(
            'mysql:dbname=%s;host=%s;port=%s',
            env('MASTER_DB_NAME'),
            env('MASTER_DB_HOST'),
            env('MASTER_DB_PORT', 3306)
        ),
        'username' => env('MASTER_DB_USER', 'root'),
        'password' => env('MASTER_DB_PWD', 'root'),
        'prefix'   => env('MASTER_DB_PREFIX', 'user_center_'),
        'charset'  => 'utf8mb4',
        'options'  => [
            PDO::MYSQL_ATTR_USE_BUFFERED_QUERY => true,
            PDO::MYSQL_ATTR_INIT_COMMAND       => 'SET NAMES utf8mb4',
            PDO::ATTR_CASE                     => PDO::CASE_NATURAL,
            PDO::ATTR_ERRMODE                  => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_ORACLE_NULLS             => PDO::NULL_NATURAL,
            PDO::ATTR_STRINGIFY_FETCHES        => false,
            PDO::ATTR_EMULATE_PREPARES         => false,
            PDO::MYSQL_ATTR_LOCAL_INFILE       => true
        ],
        'config'   => [
            'collation' => 'utf8mb4_unicode_ci',
            'strict'    => false,
            'timezone'  => '+8:00',
            'modes'     => 'NO_ENGINE_SUBSTITUTION,STRICT_TRANS_TABLES',
            'fetchMode' => PDO::FETCH_ASSOC,
        ],
    ],

    // +------------------------------------------------------
    // |  数据库连接池配置
    // +------------------------------------------------------
    'db.pool'              => [
        'class'       => \Swoft\Db\Pool::class,
        'database'    => bean('db'),
        'minActive'   => env('MASTER_DB_MIN_ACTIVE', 5),
        'maxActive'   => env('MASTER_DB_MAX_ACTIVE', 10),
        'maxWait'     => env('MASTER_DB_MAX_WAIT', 0),
        'maxWaitTime' => env('MASTER_DB_MAX_WAIT_TIME', 0),
        'maxIdleTime' => env('MASTER_DB_MAX_WAIT_IDLE_TIME', 60),
        'timeout'     => env('MASTER_DB_TIMEOUT', 5)
    ],

    // +------------------------------------------------------
    // |  redis配置
    // +------------------------------------------------------
    'redis'                => [
        'class'    => RedisDb::class,
        'driver'   => 'phpredis',
        'host'     => env('MASTER_REDIS_HOST', '127.0.0.1'),
        'port'     => env('MASTER_REDIS_PORT', 6379),
        'database' => env('MASTER_REDIS_DATABASE', 1),
        'option'   => [
            'prefix'                => env('MASTER_REDIS_PREFIX'),
            'serializer'            => Redis::SERIALIZER_NONE,
            // set socket timeout
            // Redis::OPT_READ_TIMEOUT => -1
        ],
    ],

    // +------------------------------------------------------
    // |  redis链接池配置
    // +------------------------------------------------------
    'redis.pool'           => [
        'class'       => \Swoft\Redis\Pool::class,
        'redisDb'     => bean('redis'),
        'minActive'   => env('MASTER_REDIS_POOL_MIN_ACTIVE', 10),
        'maxActive'   => env('MASTER_REDIS_POOL_MAX_ACTIVE', 20),
        'maxWait'     => env('MASTER_REDIS_POOL_MAX_WAIT', 0),
        'maxWaitTime' => env('MASTER_REDIS_POOL_MAX_WAIT_TIME', 0),
        'maxIdleTime' => env('MASTER_REDIS_POOL_MAX_IDLE_TIME', 40),
    ],

    // +------------------------------------------------------
    // |  consul 配置
    // +------------------------------------------------------
    //    'consul'               => [   // 暂时不使用 consul
    //        'host'    => env('CONSUL_HOST', '127.0.0.1'),
    //        'port'    => env('CONSUL_PORT', 8500),
    //        'timeout' => env('CONSUL_TIMEOUT', 3),
    //    ],

    // +------------------------------------------------------
    // |  RPC客户端 配置 ------ oauth.center配置
    // +------------------------------------------------------
    'oauth.center'         => [
        'class'   => ServiceClient::class,
        'host'    => env('RPC_CLIENT_OAUTH_CENTER_HOST', '127.0.0.1'),
        'port'    => env('RPC_CLIENT_OAUTH_CENTER_PORT', 18307),
        'setting' => [
            'timeout'         => env('RPC_CLIENT_TIMEOUT', 0.5),
            'connect_timeout' => env('RPC_CLIENT_CONNECT_TIMEOUT', 1.0),
            'write_timeout'   => env('RPC_CLIENT_WRITE_TIMEOUT', 10),
            'read_timeout'    => env('RPC_CLIENT_READ_TIMEOUT', 0.5),
        ],
        'packet'  => bean('rpcClientPacket')
    ],
    'oauth.center.pool'    => [
        'class'  => ServicePool::class,
        'client' => bean('oauth.center')
    ],

    // +------------------------------------------------------
    // |  RPC客户端 配置 ------ mall.center配置
    // +------------------------------------------------------
    'mall.center'          => [
        'class'   => ServiceClient::class,
        'host'    => env('RPC_CLIENT_MALL_CENTER_HOST', '127.0.0.1'),
        'port'    => env('RPC_CLIENT_MALL_CENTER_PORT', 18307),
        'setting' => [
            'timeout'         => env('RPC_CLIENT_TIMEOUT', 0.5),
            'connect_timeout' => env('RPC_CLIENT_CONNECT_TIMEOUT', 1.0),
            'write_timeout'   => env('RPC_CLIENT_WRITE_TIMEOUT', 10),
            'read_timeout'    => env('RPC_CLIENT_READ_TIMEOUT', 0.5),
        ],
        'packet'  => bean('rpcClientPacket')
    ],
    'mall.center.pool'     => [
        'class'  => ServicePool::class,
        'client' => bean('mall.center')
    ],

    // +------------------------------------------------------
    // |  RPC客户端 配置 ------ product.center配置
    // +------------------------------------------------------
    'product.center'       => [
        'class'   => ServiceClient::class,
        'host'    => env('RPC_CLIENT_PRODUCT_CENTER_HOST', '127.0.0.1'),
        'port'    => env('RPC_CLIENT_PRODUCT_CENTER_PORT', 18307),
        'setting' => [
            'timeout'         => env('RPC_CLIENT_TIMEOUT', 0.5),
            'connect_timeout' => env('RPC_CLIENT_CONNECT_TIMEOUT', 1.0),
            'write_timeout'   => env('RPC_CLIENT_WRITE_TIMEOUT', 10),
            'read_timeout'    => env('RPC_CLIENT_READ_TIMEOUT', 0.5),
        ],
        'packet'  => bean('rpcClientPacket')
    ],
    'product.center.pool'  => [
        'class'  => ServicePool::class,
        'client' => bean('product.center')
    ],

    // +------------------------------------------------------
    // |  RPC客户端 配置 ------ order.center配置
    // +------------------------------------------------------
    'order.center'         => [
        'class'   => ServiceClient::class,
        'host'    => env('RPC_CLIENT_ORDER_CENTER_HOST', '127.0.0.1'),
        'port'    => env('RPC_CLIENT_ORDER_CENTER_PORT', 18307),
        'setting' => [
            'timeout'         => env('RPC_CLIENT_TIMEOUT', 0.5),
            'connect_timeout' => env('RPC_CLIENT_CONNECT_TIMEOUT', 1.0),
            'write_timeout'   => env('RPC_CLIENT_WRITE_TIMEOUT', 10),
            'read_timeout'    => env('RPC_CLIENT_READ_TIMEOUT', 0.5),
        ],
        'packet'  => bean('rpcClientPacket')
    ],
    'order.center.pool'    => [
        'class'  => ServicePool::class,
        'client' => bean('order.center')
    ],

    // +------------------------------------------------------
    // |  RPC客户端 配置 ------ data.center配置
    // +------------------------------------------------------
    'data.center'          => [
        'class'   => ServiceClient::class,
        'host'    => env('RPC_CLIENT_DATA_CENTER_HOST', '127.0.0.1'),
        'port'    => env('RPC_CLIENT_DATA_CENTER_PORT', 18307),
        'setting' => [
            'timeout'         => env('RPC_CLIENT_TIMEOUT', 0.5),
            'connect_timeout' => env('RPC_CLIENT_CONNECT_TIMEOUT', 1.0),
            'write_timeout'   => env('RPC_CLIENT_WRITE_TIMEOUT', 10),
            'read_timeout'    => env('RPC_CLIENT_READ_TIMEOUT', 0.5),
        ],
        'packet'  => bean('rpcClientPacket')
    ],
    'data.center.pool'     => [
        'class'  => ServicePool::class,
        'client' => bean('data.center')
    ],

    // +------------------------------------------------------
    // |  RPC客户端 配置 ------ finance.center配置
    // +------------------------------------------------------
    'finance.center'       => [
        'class'   => ServiceClient::class,
        'host'    => env('RPC_CLIENT_FINANCE_CENTER_HOST', '127.0.0.1'),
        'port'    => env('RPC_CLIENT_FINANCE_CENTER_PORT', 18307),
        'setting' => [
            'timeout'         => env('RPC_CLIENT_TIMEOUT', 0.5),
            'connect_timeout' => env('RPC_CLIENT_CONNECT_TIMEOUT', 1.0),
            'write_timeout'   => env('RPC_CLIENT_WRITE_TIMEOUT', 10),
            'read_timeout'    => env('RPC_CLIENT_READ_TIMEOUT', 0.5),
        ],
        'packet'  => bean('rpcClientPacket')
    ],
    'finance.center.pool'  => [
        'class'  => ServicePool::class,
        'client' => bean('finance.center')
    ],

    // +------------------------------------------------------
    // |  RPC客户端 配置 ------ customer.center配置
    // +------------------------------------------------------
    'customer.center'      => [
        'class'   => ServiceClient::class,
        'host'    => env('RPC_CLIENT_CUSTOMER_CENTER_HOST', '127.0.0.1'),
        'port'    => env('RPC_CLIENT_CUSTOMER_CENTER_PORT', 18307),
        'setting' => [
            'timeout'         => env('RPC_CLIENT_TIMEOUT', 0.5),
            'connect_timeout' => env('RPC_CLIENT_CONNECT_TIMEOUT', 1.0),
            'write_timeout'   => env('RPC_CLIENT_WRITE_TIMEOUT', 10),
            'read_timeout'    => env('RPC_CLIENT_READ_TIMEOUT', 0.5),
        ],
        'packet'  => bean('rpcClientPacket')
    ],
    'customer.center.pool' => [
        'class'  => ServicePool::class,
        'client' => bean('customer.center')
    ],

    // +------------------------------------------------------
    // |  RPC客户端 配置 ------ market.center配置
    // +------------------------------------------------------
    'market.center'        => [
        'class'   => ServiceClient::class,
        'host'    => env('RPC_CLIENT_MARKET_CENTER_HOST', '127.0.0.1'),
        'port'    => env('RPC_CLIENT_MARKET_CENTER_PORT', 18307),
        'setting' => [
            'timeout'         => env('RPC_CLIENT_TIMEOUT', 0.5),
            'connect_timeout' => env('RPC_CLIENT_CONNECT_TIMEOUT', 1.0),
            'write_timeout'   => env('RPC_CLIENT_WRITE_TIMEOUT', 10),
            'read_timeout'    => env('RPC_CLIENT_READ_TIMEOUT', 0.5),
        ],
        'packet'  => bean('rpcClientPacket')
    ],
    'market.center.pool'   => [
        'class'  => ServicePool::class,
        'client' => bean('market.center')
    ]
];
