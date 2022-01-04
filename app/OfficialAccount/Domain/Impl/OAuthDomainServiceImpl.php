<?php declare(strict_types=1);
/**
 * This file is part of Agarwood Cloud.
 *
 * @link     https://www.agarwood-cloud.com
 * @document https://www.agarwood-cloud.com/docs
 * @contact  676786620@qq.com
 * @author   agarwood
 */

namespace App\OfficialAccount\Domain\Impl;

use App\Customer\Domain\Aggregate\Repository\CustomerQueryRepository;
use App\OfficialAccount\Domain\Aggregate\Repository\UserInfoRepository;
use App\OfficialAccount\Domain\Aggregate\Repository\UserOfficialAccountRepository;
use App\OfficialAccount\Domain\Aggregate\Repository\UserQueryRepository;
use App\OfficialAccount\Domain\OAuthDomainService;
use App\OfficialAccount\Interfaces\DTO\Oauth\FrontEndJWTDTO;
use App\OfficialAccount\Interfaces\DTO\Oauth\WeChatDTO;
use App\OfficialAccount\Interfaces\Rpc\Client\MallCenter\OfficialAccountsRpc;
use EasyWeChat\Kernel\Exceptions\InvalidConfigException;
use EasyWeChat\OfficialAccount\Application;
use Overtrue\Socialite\Exceptions\AuthorizeFailedException;
use Overtrue\Socialite\User;
use Swoft\Db\Exception\DbException;
use Agarwood\WeChat\Factory\WeChat;

/**
 * @\Swoft\Bean\Annotation\Mapping\Bean()
 */
class OAuthDomainServiceImpl implements OAuthDomainService
{
    /**
     * @\Swoft\Bean\Annotation\Mapping\Inject()
     *
     * @var UserQueryRepository
     */
    protected UserQueryRepository $userRepository;

    /**
     * @\Swoft\Bean\Annotation\Mapping\Inject()
     *
     * @var UserInfoRepository
     */
    protected UserInfoRepository $userInfoRepository;

    /**
     * @\Swoft\Bean\Annotation\Mapping\Inject()
     *
     * @var CustomerQueryRepository
     */
    protected CustomerQueryRepository $customerRepository;

    /**
     * @\Swoft\Bean\Annotation\Mapping\Inject()
     *
     * @var OfficialAccountsRpc
     */
    protected OfficialAccountsRpc $customer;

    /**
     * @\Swoft\Bean\Annotation\Mapping\Inject()
     *
     * @var WeChat
     */
    protected WeChat $OfficialAccount;

    /**
     * @\Swoft\Bean\Annotation\Mapping\Inject()
     *
     * @var UserOfficialAccountRepository
     */
    protected UserOfficialAccountRepository $userOfficialAccountRepository;

    /**
     * @inheritDoc
     * @throws AuthorizeFailedException|\GuzzleHttp\Exception\GuzzleException
     */
    public function OfficialAccount(WeChatDTO $DTO): User
    {
        // 这里获取实例
        $app = $this->customer->officialAccountApplication($DTO->getToken());

        //获取用户信息
        return $app->oauth->userFromCode($DTO->getCode());
    }

    /**
     * @inheritDoc
     */
    public function token(string $openid, string $token, int $officialAccountId, int $customerId, string $customer): string
    {
        // 这里把其它的值也加入
        // 构造jwt的 token 值
        return $this->jwt->builder($openid)
            ->setTokenToJWT($token)
            ->setCustomerUuidToJWT($customerId)
            ->setServiceUuidToJWT($officialAccountId)
            ->setCustomerToJWT($customer)
            ->token();
    }

    /**
     * @inheritDoc
     */
    public function target(string $state, string $token): string
    {
        // 重定向后会带上state参数，开发者可以填写a-zA-Z0-9的参数值，最多128字节，故不可以使用base64来处理该回调地址
        // 这里由跳后端接口修改为跳前端接口
//        $targetUrl = base64_decode($state);
//        $parseUrl  = parse_url($targetUrl);
//        if (isset($parseUrl['fragment']) && (false !== strpos($parseUrl['fragment'], '?'))) {
//            $targetUrl .= '&jwtToken=' . $token;
//        } else {
//            $targetUrl .= '?jwtToken=' . $token;
//        }
//
//        return $targetUrl;
        return config('OfficialAccount.fontEndCallback') . '?jwtToken=' . $token;
    }

    /**
     * @inheritDoc
     * @throws DbException
     * @throws InvalidConfigException
     */
    public function user(User $user, Application $application, WeChatDTO $DTO): array
    {
        // 这里记录用户的信息
        $fans = $this->userRepository->findByOpenid($user->getId());

        // 如果存在，则直接返回数组
        if ($fans) {
            return $fans;
        }

        $attributes = $application->user->get($user->getId());

        // 接收链接的值
        $attributes['customerUuid'] = $DTO->getCustomerUuid();
        $attributes['customer']     = $DTO->getCustomer();
        $attributes['serviceUuid']  = $DTO->getServiceUuid();

        // 这里是给特定的客服圈粉，这里是为了兼容以前的旧版本
        if ($DTO->getCustomerUuid() && (!$DTO->getCustomer())) {
            $customerModel              = $this->customerRepository->findByUuid($DTO->getCustomerUuid());
            $attributes['customerUuid'] = $DTO->getCustomerUuid();
            $attributes['customer']     = $customerModel ? $customerModel->getName() : '';
        }

        // 这个是兼容以前的写法
        if (!$DTO->getServiceUuid()) {
            $officialAccountInfo       = $this->customer->officialAccountInfo($DTO->getToken());
            $attributes['serviceUuid'] = $officialAccountInfo['uuid'] ?? '';
        }

        return $this->userOfficialAccountRepository->addUserFromCode($attributes);
    }

    /**
     * 生成前端跳转的url
     *
     * @param FrontEndJWTDTO $dto
     *
     * @return string
     */
    public function OfficialAccountUrl(FrontEndJWTDTO $dto): string
    {
        $app = $this->customer->officialAccountApplication($dto->getToken());

        // 回调的链接
        $query    = [
            'token'        => $dto->getToken(),
            'customerUuid' => $dto->getCustomerUuid(),
            'customer'     => $dto->getCustomer(),
            'serviceUuid'  => $dto->getServiceUuid(),
            'state'        => $dto->getState(),
        ];
        $callback = config('wechat.callback') . '?' . http_build_query($query);

        //跳转到授权页面
        return $app->oauth->scopes(['snsapi_userinfo'])->redirect($callback);
    }
}
