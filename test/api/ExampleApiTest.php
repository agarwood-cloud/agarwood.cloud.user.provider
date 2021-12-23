<?php declare(strict_types=1);
/**
 * This file is part of Agarwood Cloud.
 *
 * @link     https://www.agarwood-cloud.com
 * @document https://www.agarwood-cloud.com/docs
 * @contact  676786620@qq.com
 * @author   agarwood
 */

namespace AppTest\Api;

use PHPUnit\Framework\TestCase;
use Swoft\Swlib\HttpClient;

/**
 * Class ExampleApiTest
 *
 * @package AppTest\Api
 */
class ExampleApiTest extends TestCase
{
    public const HOST = 'http://127.0.0.1:18306';

    /**
     * @var HttpClient
     */
    private $http;

    public function setUp(): void
    {
        $this->http = new HttpClient();
    }

    public function testHi(): void
    {
        /** @see UserController::hi() */
        $w = $this->http->get(self::HOST. '/hi');

        $this->assertSame(200, $w->getStatusCode());
        $this->assertSame('hi', $w->getBody()->getContents());
    }
}
