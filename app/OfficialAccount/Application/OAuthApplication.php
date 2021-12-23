<?php declare(strict_types=1);
/**
 * This file is part of Agarwood Cloud.
 *
 * @link     https://www.agarwood-cloud.com
 * @document https://www.agarwood-cloud.com/docs
 * @contact  676786620@qq.com
 * @author   agarwood
 */

namespace App\OfficialAccount\Application;

use App\OfficialAccount\Interfaces\DTO\Oauth\FrontEndJWTDTO;
use App\OfficialAccount\Interfaces\DTO\Oauth\WeChatDTO;
use Overtrue\Socialite\User;

/**
 * @\Swoft\Bean\Annotation\Mapping\Bean()
 */
interface OAuthApplication
{
    /**
     * 完成微信 OAuth2 验证
     *
     * @param WeChatDTO $DTO
     *
     * @return User
     */
    public function OfficialAccountOauthProvider(WeChatDTO $DTO): User;

    /**
     * 生成 jwt-token 值，用于登陆验证
     *
     * @param User   $user
     * @param string $token
     * @param int $officialAccountId
     * @param int $customerId
     * @param string $customer
     *
     * @return string
     */
    public function jwtTokenProvider(User $user, string $token, int $officialAccountId, int $customerId, string $customer): string;

    /**
     * 构建跳转目标链接
     *
     * @param string $state base64后的 url值
     * @param string $token jwt-token 值
     *
     * @return string
     */
    public function targetUrlProvider(string $state, string $token): string;

    /**
     * 记录用户信息
     *
     * @param User      $user
     * @param WeChatDTO $DTO
     *
     * @return array
     */
    public function userProvider(User $user, WeChatDTO $DTO): array;

    /**
     * 返回值给前端
     *
     * @param FrontEndJWTDTO $dto
     *
     * @return string
     */
    public function OfficialAccountUrlProvider(FrontEndJWTDTO $dto): string;
}
