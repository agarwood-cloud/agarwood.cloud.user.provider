<?php declare(strict_types=1);
/**
 * This file is part of Agarwood Cloud.
 *
 * @link     https://www.agarwood-cloud.com
 * @document https://www.agarwood-cloud.com/docs
 * @contact  676786620@qq.com
 * @author   agarwood
 */

namespace App\OfficialAccount\Interfaces\Rpc\Client\MallCenter;

use EasyWeChat\OfficialAccount\Application;

/**
 * @\Swoft\Bean\Annotation\Mapping\Bean()
 */
interface OfficialAccountsRpc
{
    /**
     * Get the config of the EasyWechat.
     *
     * @param int $platformId
     *
     * @return array
     */
    public function officialAccountsConfig(int $platformId): array;

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
     * @param int $platformId
     *
     * @return array
     */
    public function officialAccountsInfo(int $platformId): array;

    /**
     * Get the official account application
     */
    public function officialAccountApplication(int $platformId): Application;

    /**
     * Get the official account application
     */
    public function officialAccountApplicationConsole(int $platformId): Application;

    /**
     * Get the enterprise id
     *
     * @param int $platformId
     *
     * @return int
     */
    public function getEnterpriseId(int $platformId): int;
}
