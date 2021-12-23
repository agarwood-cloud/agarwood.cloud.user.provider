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

use Agarwood\Rpc\OauthCenter\OAuthCenterJWTRpcInterface;
use App\Support\ParsingToken;

/**
 * @\Swoft\Bean\Annotation\Mapping\Bean()
 */
class ParsingTokenImpl implements ParsingToken
{
    /**
     * @\Swoft\Rpc\Client\Annotation\Mapping\Reference(pool="oauth.center.pool")
     *
     * @var OAuthCenterJWTRpcInterface
     */
    public OAuthCenterJWTRpcInterface $oauthCenterJWTRpc;

    /**
     * Verify that the token is available
     *
     * @param string $token
     *
     * @return bool
     */
    public function validator(string $token): bool
    {
        if (empty($token)) {
            $token = $this->getBearer();
        }

        // Verify that the token is available
        if (empty($token)) {
            return false;
        }

        return $this->oauthCenterJWTRpc->validator($token);
    }

    /**
     * UserId Or Openid
     *
     * @return int|string|null
     */
    public function getUserId(): int|string|null
    {
        return $this->oauthCenterJWTRpc->getUserId($this->getBearer());
    }

    /**
     * Customer Service
     *
     * @return string|null
     */
    public function getCustomer(): string|null
    {
        return $this->oauthCenterJWTRpc->getCustomer($this->getBearer());
    }

    /**
     * @return int|null
     */
    public function getCustomerId(): int|null
    {
        return $this->oauthCenterJWTRpc->getCustomerId($this->getBearer());
    }

    /**
     * @return string|null
     */
    public function getNickname(): string|null
    {
        return $this->oauthCenterJWTRpc->getNickname($this->getBearer());
    }

    /**
     * @return int|null
     */
    public function getOfficialAccountId(): int|null
    {
        return $this->oauthCenterJWTRpc->getOfficialAccountId($this->getBearer());
    }

    /**
     * @return string
     */
    private function getBearer(): string
    {
        return str_replace('Bearer ', '', context()->getRequest()->getHeaderLine('Authorization'));
    }
}
