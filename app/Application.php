<?php declare(strict_types=1);
/**
 * This file is part of Agarwood Cloud.
 *
 * @link     https://www.agarwood-cloud.com
 * @document https://www.agarwood-cloud.com/docs
 * @contact  676786620@qq.com
 * @author   agarwood
 */

namespace App;

use Swoft\SwoftApplication;
use function date_default_timezone_set;

/**
 * Class Application
 *
 * @since 2.0
 */
class Application extends SwoftApplication
{
    protected function beforeInit(): void
    {
        parent::beforeInit();

        // ini_set('default_socket_timeout', '-1');

        // you can php setting.
        date_default_timezone_set('Asia/Shanghai');
    }

    /**
     * @return array
     */
    public function getCLoggerConfig(): array
    {
        $config           = parent::getCLoggerConfig();
        $config['enable'] = true;
        return $config;
    }
}
