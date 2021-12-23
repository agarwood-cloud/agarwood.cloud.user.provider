<?php declare(strict_types=1);
/**
 * This file is part of Agarwood Cloud.
 *
 * @link     https://www.agarwood-cloud.com
 * @document https://www.agarwood-cloud.com/docs
 * @contact  676786620@qq.com
 * @author   agarwood
 */

namespace App\Support\Impl;

use App\Support\CustomerServiceHttpClient;
use GuzzleHttp\Client;

/**
 * @\Swoft\Bean\Annotation\Mapping\Bean()
 */
class CustomerServiceHttpClientImpl implements CustomerServiceHttpClient
{
    /**
     * @param array $config
     *
     * @return \GuzzleHttp\Client
     */
    public function httpClient(array $config = []): Client
    {
        if (empty($config)) {
            $config = [
                'base_uri' => env('NODE_HTTP_BASE_URL', 'http://localhost:3000'),
                'timeout'  => 6.0
            ];
        }
        return new Client($config);
    }
}
