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

use Agarwood\Core\WeChat\Factory\WeChat;
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
        // ??????????????????
        $app = $this->customer->officialAccountApplication($DTO->getToken());

        //??????????????????
        return $app->oauth->userFromCode($DTO->getCode());
    }

    /**
     * @inheritDoc
     */
    public function token(string $openid, string $token, int $platformId, int $customerId, string $customer): string
    {
        // ??????????????????????????????
        // ??????jwt??? token ???
        return $this->jwt->builder($openid)
            ->setTokenToJWT($token)
            ->setCustomerUuidToJWT($customerId)
            ->setServiceUuidToJWT($platformId)
            ->setCustomerToJWT($customer)
            ->token();
    }

    /**
     * @inheritDoc
     */
    public function target(string $state, string $token): string
    {
        // ?????????????????????state??????????????????????????????a-zA-Z0-9?????????????????????128???????????????????????????base64????????????????????????
        // ????????????????????????????????????????????????
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
        // ???????????????????????????
        $fans = $this->userRepository->findByOpenid($user->getId());

        // ????????????????????????????????????
        if ($fans) {
            return $fans;
        }

        $attributes = $application->user->get($user->getId());

        // ??????????????????
        $attributes['customerUuid'] = $DTO->getCustomerUuid();
        $attributes['customer']     = $DTO->getCustomer();
        $attributes['serviceUuid']  = $DTO->getServiceUuid();

        // ???????????????????????????????????????????????????????????????????????????
        if ($DTO->getCustomerUuid() && (!$DTO->getCustomer())) {
            $customerModel              = $this->customerRepository->findByUuid($DTO->getCustomerUuid());
            $attributes['customerUuid'] = $DTO->getCustomerUuid();
            $attributes['customer']     = $customerModel ? $customerModel->getName() : '';
        }

        // ??????????????????????????????
        if (!$DTO->getServiceUuid()) {
            $officialAccountInfo       = $this->customer->officialAccountInfo($DTO->getToken());
            $attributes['serviceUuid'] = $officialAccountInfo['uuid'] ?? '';
        }

        return $this->userOfficialAccountRepository->addUserFromCode($attributes);
    }

    /**
     * ?????????????????????url
     *
     * @param FrontEndJWTDTO $dto
     *
     * @return string
     */
    public function OfficialAccountUrl(FrontEndJWTDTO $dto): string
    {
        $app = $this->customer->officialAccountApplication($dto->getToken());

        // ???????????????
        $query    = [
            'token'        => $dto->getToken(),
            'customerUuid' => $dto->getCustomerUuid(),
            'customer'     => $dto->getCustomer(),
            'serviceUuid'  => $dto->getServiceUuid(),
            'state'        => $dto->getState(),
        ];
        $callback = config('wechat.callback') . '?' . http_build_query($query);

        //?????????????????????
        return $app->oauth->scopes(['snsapi_userinfo'])->redirect($callback);
    }
}
