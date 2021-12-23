<?php declare(strict_types=1);
/**
 * This file is part of Agarwood Cloud.
 *
 * @link     https://www.agarwood-cloud.com
 * @document https://www.agarwood-cloud.com/docs
 * @contact  676786620@qq.com
 * @author   agarwood
 */

namespace AppTest\Unit\Common;

use App\Common\MyBean;
use PHPUnit\Framework\TestCase;
use Swoft\Log\Helper\Log;
use function bean;

/**
 * Class MyBeanTest
 *
 * @package AppTest\Unit\Common
 */
class MyBeanTest extends TestCase
{
    public function testMyMethod2(): void
    {
        $bean = bean(MyBean::class);

        vdump('test message');
        Log::info('test message');

        $this->assertSame(MyBean::class . '::myMethod2', $bean->myMethod2());
    }
}
