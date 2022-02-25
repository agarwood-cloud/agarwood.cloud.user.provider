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

use Agarwood\Core\WeChat\Factory\WeChat;
use Agarwood\Rpc\MallCenter\MallCenterOfficialAccountsRpcInterface;
use App\Customer\Interfaces\Rpc\Client\MallCenter\OfficialAccountsRpc;
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
     * @param int $platformId
     *
     * @return array
     */
    public function officialAccountsConfig(int $platformId): array
    {
        return $this->officialAccountsRpc->officialAccountsConfig($platformId);
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
     * @param int $platformId
     *
     * @return array
     */
    public function officialAccountsInfo(int $platformId): array
    {
        return $this->officialAccountsRpc->officialAccountsInfo($platformId);
    }

    /**
     * @param int $platformId
     *
     * @return \EasyWeChat\OfficialAccount\Application
     */
    public function officialAccountApplication(int $platformId): Application
    {
        // todo 优化: 可以使用缓存
        $config = $this->officialAccountsRpc->officialAccountsConfig($platformId);

        return $this->weChat->officialAccount($config);
    }
}
