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

/**
 * @\Swoft\Bean\Annotation\Mapping\Bean()
 */
interface ParsingToken
{
    /**
     * Verify that the token is available
     *
     * @param string $token
     *
     * @return bool
     */
    public function validator(string $token): bool;

    /**
     * UserId Or Openid
     *
     * @return int|string|null
     */
    public function getUserId(): int|string|null;

    /**
     * Customer Service
     *
     * @return string|null
     */
    public function getCustomer(): string|null;

    /**
     * @return int|null
     */
    public function getCustomerId(): int|null;

    /**
     * @return string|null
     */
    public function getNickname(): string|null;

    /**
     * @return int|null
     */
    public function getOfficialAccountId(): int|null;
}
