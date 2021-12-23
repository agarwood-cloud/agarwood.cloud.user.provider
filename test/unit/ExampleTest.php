<?php declare(strict_types=1);
/**
 * This file is part of Agarwood Cloud.
 *
 * @link     https://www.agarwood-cloud.com
 * @document https://www.agarwood-cloud.com/docs
 * @contact  676786620@qq.com
 * @author   agarwood
 */

namespace AppTest\Unit;

use PHPUnit\Framework\TestCase;
use function bean;

/**
 * Class ExampleTest
 *
 * @package AppTest\Unit
 */
class ExampleTest extends TestCase
{
    public function testDemo(): void
    {
        $this->assertNotEmpty(bean('cliApp'));
    }
}
