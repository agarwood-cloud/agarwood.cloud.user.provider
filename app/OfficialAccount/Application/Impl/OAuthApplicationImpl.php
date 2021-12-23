<?php declare(strict_types=1);
/**
 * This file is part of Agarwood Cloud.
 *
 * @link     https://www.agarwood-cloud.com
 * @document https://www.agarwood-cloud.com/docs
 * @contact  676786620@qq.com
 * @author   agarwood
 */

namespace App\OfficialAccount\Application\Impl;

use App\OfficialAccount\Application\OAuthApplication;
use App\OfficialAccount\Domain\OAuthDomainService;
use App\OfficialAccount\Interfaces\DTO\Oauth\FrontEndJWTDTO;
use App\OfficialAccount\Interfaces\DTO\Oauth\WeChatDTO;
use App\OfficialAccount\Interfaces\Rpc\Client\MallCenter\OfficialAccountsRpc;
use Overtrue\Socialite\User;

/**
 * @\Swoft\Bean\Annotation\Mapping\Bean()
 */
class OAuthApplicationImpl implements OAuthApplication
{
    /**
     * @\Swoft\Bean\Annotation\Mapping\Inject()
     *
     * @var OAuthDomainService
     */
    protected OAuthDomainService $oauth;

    /**
     * @\Swoft\Bean\Annotation\Mapping\Inject()
     *
     * @var OfficialAccountsRpc
     */
    protected OfficialAccountsRpc $serviceRpc;

    /**
     * @inheritDoc
     */
    public function OfficialAccountOauthProvider(WeChatDTO $DTO): User
    {
        return $this->oauth->OfficialAccount($DTO);
    }

    /**
     * @inheritDoc
     */
    public function jwtTokenProvider(User $user, string $token, int $officialAccountId, int $customerId, string $customer): string
    {
        //这里设置
        return $this->oauth->token($user->getId(), $token, $officialAccountId, $customerId, $customer);
    }

    /**
     * @inheritDoc
     */
    public function targetUrlProvider(string $state, string $token): string
    {
        return $this->oauth->target($state, $token);
    }

    /**
     * @inheritDoc
     */
    public function userProvider(User $user, WeChatDTO $DTO): array
    {
        $app = $this->serviceRpc->officialAccountApplication($DTO->getToken());

        return $this->oauth->user($user, $app, $DTO);
    }

    /**
     * @inheritDoc
     */
    public function OfficialAccountUrlProvider(FrontEndJWTDTO $dto): string
    {
        return $this->oauth->OfficialAccountUrl($dto);
    }
}
