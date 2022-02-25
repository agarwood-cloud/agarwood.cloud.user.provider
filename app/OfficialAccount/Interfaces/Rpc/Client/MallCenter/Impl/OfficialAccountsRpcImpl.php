<?php declare(strict_types=1);
/**
 * This file is part of Agarwood Cloud.
 *
 * @link     https://www.agarwood-cloud.com
 * @document https://www.agarwood-cloud.com/docs
 * @contact  676786620@qq.com
 * @author   agarwood
 */

namespace App\OfficialAccount\Interfaces\Rpc\Client\MallCenter\Impl;

use Agarwood\Core\WeChat\Factory\WeChat;
use Agarwood\Rpc\MallCenter\MallCenterOfficialAccountsRpcInterface;
use App\OfficialAccount\Interfaces\Rpc\Client\MallCenter\OfficialAccountsRpc;
use EasyWeChat\OfficialAccount\Application;
use Swoft\Rpc\Client\Annotation\Mapping\Reference;

/**
 * @\Swoft\Bean\Annotation\Mapping\Bean()
 */
class OfficialAccountsRpcImpl implements OfficialAccountsRpc
{
    /**
     *  服务号的 RPC 服务接口
     *
     * @Reference(pool="mall.center.pool")
     *
     * @var MallCenterOfficialAccountsRpcInterface
     */
    public MallCenterOfficialAccountsRpcInterface $officialAccountsRpc;

    /**
     * @\Swoft\Bean\Annotation\Mapping\Inject()
     *
     * @var WeChat
     */
    protected WeChat $weChat;

    /**
     * @param int $tencentId
     *
     * @return array
     */
    public function officialAccountsConfig(int $tencentId): array
    {
        return $this->officialAccountsRpc->officialAccountsConfig($tencentId);
    }

    /**
     * @param int $companyId
     *
     * @return array
     */
    public function officialAccounts(int $companyId): array
    {
        return $this->officialAccountsRpc->officialAccounts($companyId);
    }

    /**
     * @param int $tencentId
     *
     * @return array
     */
    public function officialAccountsInfo(int $tencentId): array
    {
        return $this->officialAccountsRpc->officialAccountsInfo($tencentId);
    }

    /**
     * @param int $tencentId
     *
     * @return \EasyWeChat\OfficialAccount\Application
     */
    public function officialAccountApplication(int $tencentId): Application
    {
        // todo 优化: 可以使用缓存
        // $config = $this->officialAccountsRpc->officialAccountsConfig($tencentId);

        $config = [
            'app_id'  => 'wx3d4726296a65e6aa',                    // AppID
            'secret'  => '2f1358264dd78d1f603a123e5ec3c653',                   // AppSecret
            'token'   => '6bc8a1a64e71d',                    // Token
            'aes_key' => 'CE3oQoWW8BCbfotuhiixmXgLwQ5ypZ2hQ6s1mNYZ0Xc',
        ];

        return $this->weChat->officialAccount($config);
    }
}
