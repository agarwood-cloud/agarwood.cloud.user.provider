<?php declare(strict_types=1);
/**
 * This file is part of Agarwood Cloud.
 *
 * @link     https://www.agarwood-cloud.com
 * @document https://www.agarwood-cloud.com/docs
 * @contact  676786620@qq.com
 * @author   agarwood
 */

namespace App\Customer\Interfaces\Rpc\Client\MallCenter;

use EasyWeChat\OfficialAccount\Application;

/**
 * @\Swoft\Bean\Annotation\Mapping\Bean()
 */
interface ServiceRpc
{
    /**
     * 获取 token 值的服务号对应的服务号配置信息
     *
     * @param string $token
     *
     * @return array
     */
    public function officialAccountConfig(string $token): array;

    /**
     * 查看公众号详情信息
     *
     *
     * @param string $token
     *
     * @return array
     */
    public function view(string $token): array;

    /**
     * 查看公众号详情信息
     *
     *
     * @param string $token
     *
     * @return array
     */
    public function officialAccountInfo(string $token): array;

    /**
     * 获取easy-OfficialAccount 的公众号实例 [ http 支持协程的 ]
     *
     * @param string $token
     *
     * @return Application
     */
    public function officialAccountApplication(string $token): Application;

    /**
     * 获取easy-OfficialAccount 的公众号实例 [ console ]
     *
     * @param string $token
     *
     * @return Application
     */
    public function officialAccountConsoleApplication(string $token): Application;
}
