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

use App\OfficialAccount\Application\UserApplication;
use App\OfficialAccount\Domain\SendToNodeDomain;
use App\OfficialAccount\Domain\UserDomainService;
use App\OfficialAccount\Infrastructure\Redis\RedisUser;
use App\OfficialAccount\Interfaces\DTO\User\IndexDTO;
use App\OfficialAccount\Interfaces\DTO\User\UpdateGroupDTO;
use App\OfficialAccount\Interfaces\DTO\User\UserCreateDTO;
use App\OfficialAccount\Interfaces\DTO\User\UserIndexDTO;
use App\OfficialAccount\Interfaces\DTO\User\UserUpdateDTO;
use Ramsey\Uuid\Uuid;
use Swoft\Stdlib\Collection;

/**
 * @\Swoft\Bean\Annotation\Mapping\Bean()
 */
class UserApplicationImpl implements UserApplication
{
    /**
     * @\Swoft\Bean\Annotation\Mapping\Inject()
     *
     * @var UserDomainService $domain
     */
    protected UserDomainService $domain;

    /**
     * @\Swoft\Bean\Annotation\Mapping\Inject()
     *
     * @var RedisUser
     */
    protected RedisUser $redisUser;

    /**
     * @\Swoft\Bean\Annotation\Mapping\Inject()
     *
     * @var \App\OfficialAccount\Domain\SendToNodeDomain
     */
    protected SendToNodeDomain $callbackNodeDomainService;

    /**
     * 列表数据
     *
     * @param int|null     $officialAccountId
     * @param UserIndexDTO $DTO
     *
     * @return array
     */
    public function indexProvider(?int $officialAccountId, UserIndexDTO $DTO): array
    {
        // $officialAccountId = 0;
        if (null === $officialAccountId) {
            return [];
        }
        return $this->domain->index($officialAccountId, $DTO->toArrayLine());
    }

    /**
     * @param \App\OfficialAccount\Interfaces\DTO\User\UserCreateDTO $DTO
     *
     * @return \Swoft\Stdlib\Collection
     */
    public function createProvider(UserCreateDTO $DTO): Collection
    {
        //增加部分系统自己添加的参数 i.e: uuid
        $attributes = $DTO->setAfter();
        $this->domain->create($attributes->toArrayLine());
        //这里可以设置更多的返回值
        return Collection::make($DTO);
    }

    /**
     * @param string $uuids
     *
     * @return bool|null
     */
    public function deleteProvider(string $uuids): ?bool
    {
        return $this->domain->delete($uuids);
    }

    /**
     * @param string                                                 $openid
     * @param UserUpdateDTO $DTO
     *
     * @return \Swoft\Stdlib\Collection
     */
    public function updateProvider(string $openid, UserUpdateDTO $DTO): Collection
    {
        $attributes = $DTO->deleteAfter($DTO->toArrayLine());
        $this->domain->update($openid, $attributes);
        return Collection::make($DTO);
    }

    /**
     * @param string $uuid
     *
     * @return array
     */
    public function viewProvider(string $uuid): array
    {
        return $this->domain->view($uuid);
    }

    /**
     * 移动粉丝
     *
     * @param string         $openid
     * @param UpdateGroupDTO $DTO
     *
     * @return \Swoft\Stdlib\Collection
     */
    public function assignCustomerProvider(string $openid, UpdateGroupDTO $DTO): Collection
    {
        $attributes = $DTO->toArrayLine();
        $this->domain->update($openid, $attributes);

        // 这删除用户的缓存信息
        $this->redisUser->deleteCacheFromRedis($openid);

        // 发送一条消息给相应的客服
        $this->callbackNodeDomainService->textMessage(
            $DTO->customerUuid,
            $openid,
            $openid,
            '【系统消息】此粉丝转移给你，请你认真做好接待',
            Uuid::uuid4()->toString()
        );

        return Collection::make($DTO);
    }

    /**
     * 粉丝列表
     *
     * @param IndexDTO $DTO
     * @param bool     $isPagination
     *
     * @return array
     */
    public function indexV3Provider(IndexDTO $DTO, bool $isPagination = true): array
    {
        return $this->domain->indexV3($DTO, $isPagination);
    }
}
