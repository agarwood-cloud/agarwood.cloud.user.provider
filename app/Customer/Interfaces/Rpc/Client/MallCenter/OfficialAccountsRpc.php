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
interface OfficialAccountsRpc
{
    /**
     * Get the config of the EasyWechat.
     *
     * @param int $tencentId
     *
     * @return array
     */
    public function officialAccountsConfig(int $tencentId): array;

    /**
     * Get all official account information
     *
     *
     * @param int $companyId
     *
     * @return array
     */
    public function officialAccounts(int $companyId): array;

    /**
     * Get the details of the official account
     *
     * @param int $tencentId
     *
     * @return array
     */
    public function officialAccountsInfo(int $tencentId): array;

    /**
     * Get the official account application
     */
    public function officialAccountApplication(int $tencentId): Application;
}
