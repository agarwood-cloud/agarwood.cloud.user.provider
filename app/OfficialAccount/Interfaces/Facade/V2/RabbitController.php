<?php declare(strict_types=1);
/**
 * This file is part of Agarwood Cloud.
 *
 * @link     https://www.agarwood-cloud.com
 * @document https://www.agarwood-cloud.com/docs
 * @contact  676786620@qq.com
 * @author   agarwood
 */

namespace App\OfficialAccount\Interfaces\Facade\V2;

use Agarwood\Core\Support\Impl\AbstractBaseController;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
use Swoft\Http\Server\Annotation\Mapping\Controller;
use Swoft\Http\Server\Annotation\Mapping\RequestMapping;
use Swoft\Http\Server\Annotation\Mapping\RequestMethod;

/**
 * @Controller(prefix="/official-account/v2")
 */
class RabbitController extends AbstractBaseController
{
    /**
     * @RequestMapping(route="rabbit", method={RequestMethod::GET})
     */
    public function index(): void
    {
        // test
        $connection = new AMQPStreamConnection('127.0.0.1', 5672, 'wumahoo', 'wumahoo', 'rabbit');
        $channel    = $connection->channel();
        $channel->exchange_declare('Gaming', 'direct', false, false, false);
        for ($i = 0; $i < 100; $i++) {
            $routes = ['dota', 'csgo', 'lol'];
            $key    = array_rand($routes);
            $arr    = [
                'match_id' => $i,
                'status'   => rand(0, 3)
            ];
            $data   = json_encode($arr);
            $msg    = new AMQPMessage($data);

            $channel->basic_publish($msg, $exchange, $routes[$key]);
            echo '发送 ' . $routes[$key] . ' 消息: ' . $data . PHP_EOL;
        }
        $channel->close();
        $connection->close();
    }
}
