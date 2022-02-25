<?php declare(strict_types=1);
/**
 * This file is part of Agarwood Cloud.
 *
 * @link     https://www.agarwood-cloud.com
 * @document https://www.agarwood-cloud.com/docs
 * @contact  676786620@qq.com
 * @author   agarwood
 */

namespace App\OfficialAccount\Domain;

use App\OfficialAccount\Interfaces\DTO\Oauth\FrontEndJWTDTO;
use App\OfficialAccount\Interfaces\DTO\Oauth\WeChatDTO;
use EasyWeChat\OfficialAccount\Application;
use Overtrue\Socialite\User;

/**
 * @\Swoft\Bean\Annotation\Mapping\Bean()
 */
interface OAuthDomainService
{
    /**
     * 完成微信 OAuth2 登陆授权
     *
     * @param WeChatDTO $DTO
     *
     * @return User
     */
    public function OfficialAccount(WeChatDTO $DTO): User;

    /**
     * 生成 jwt-token 值，用于用户登陆难
     *
     * @param string $openid
     * @param string $token
     * @param int $tencentId
     * @param int $customerId
     * @param string $customer
     *
     * @return string
     */
    public function token(string $openid, string $token, int $tencentId, int $customerId, string $customer): string;

    /**
     * 生成跳转的目标地址
     *
     * @param string $state base64后的回调地址
     * @param string $token jwt-token值
     *
     * @return string
     */
    public function target(string $state, string $token): string;

    /**
     * 记录用户信息
     *
     * @param User                                    $user
     * @param \EasyWeChat\OfficialAccount\Application $application
     * @param WeChatDTO                               $DTO
     *
     * @return array
     */
    public function user(User $user, Application $application, WeChatDTO $DTO): array;

    /**
     * 生成需要验证的跳转的url
     *
     * @param FrontEndJWTDTO $dto
     *
     * @return string
     */
    public function OfficialAccountUrl(FrontEndJWTDTO $dto): string;
}
