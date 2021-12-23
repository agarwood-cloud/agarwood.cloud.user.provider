<?php declare(strict_types=1);
/**
 * This file is part of Agarwood Cloud.
 *
 * @link     https://www.agarwood-cloud.com
 * @document https://www.agarwood-cloud.com/docs
 * @contact  676786620@qq.com
 * @author   agarwood
 */

namespace App\Support;

use GuzzleHttp\Client;

/**
 * @\Swoft\Bean\Annotation\Mapping\Bean()
 */
interface CustomerServiceHttpClient
{
    /**
     * @param array $config
     *
     * @return \GuzzleHttp\Client
     */
    public function httpClient(array $config = []): Client;
}
