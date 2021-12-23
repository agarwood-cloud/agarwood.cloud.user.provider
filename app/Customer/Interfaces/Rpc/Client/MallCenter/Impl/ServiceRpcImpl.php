<?php declare(strict_types=1);
/**
 * This file is part of Agarwood Cloud.
 *
 * @link     https://www.agarwood-cloud.com
 * @document https://www.agarwood-cloud.com/docs
 * @contact  676786620@qq.com
 * @author   agarwood
 */

namespace App\Customer\Interfaces\Rpc\Client\MallCenter\Impl;

use Agarwood\WeChat\Factory\WeChat;
use App\Customer\Interfaces\Rpc\Client\MallCenter\ServiceRpc;
use EasyWeChat\OfficialAccount\Application;

/**
 * @\Swoft\Bean\Annotation\Mapping\Bean()
 */
class ServiceRpcImpl implements ServiceRpc
{
    /**
     * @\Swoft\Bean\Annotation\Mapping\Inject()
     *
     * @var WeChat
     */
    protected WeChat $OfficialAccount;

    /**
     * @inheritDoc
     */
    public function officialAccountConfig(string $token): array
    {
        return $this->serviceRpc->config($token);
    }

    /**
     * @inheritDoc
     */
    public function view(string $token): array
    {
        return $this->serviceRpc->view($token);
    }

    /**
     * @inheritDoc
     */
    public function officialAccountInfo(string $token): array
    {
        return $this->serviceRpc->officialAccountsInfo($token);
    }

    /**
     * @inheritDoc
     */
    public function officialAccountApplication(string $token): Application
    {
        $config = $this->serviceRpc->config($token);

        return $this->OfficialAccount->officialAccount($config);
    }

    /**
     * @inheritDoc
     */
    public function officialAccountConsoleApplication(string $token): Application
    {
        $config = $this->serviceRpc->config($token);

        return $this->OfficialAccount->officialAccountConsole($config);
    }
}
