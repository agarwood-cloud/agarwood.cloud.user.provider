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
use App\OfficialAccount\Domain\UserDomain;
use App\OfficialAccount\Infrastructure\Redis\RedisUser;
use App\OfficialAccount\Interfaces\DTO\User\IndexDTO;
use App\OfficialAccount\Interfaces\DTO\User\UpdateDTO;
use Swoft\Stdlib\Collection;

/**
 * @\Swoft\Bean\Annotation\Mapping\Bean()
 */
class UserApplicationImpl implements UserApplication
{
    /**
     * @\Swoft\Bean\Annotation\Mapping\Inject()
     *
     * @var UserDomain $userDomain
     */
    public UserDomain $userDomain;

    /**
     * @\Swoft\Bean\Annotation\Mapping\Inject()
     *
     * @var RedisUser
     */
    public RedisUser $redisUser;

    /**
     * @\Swoft\Bean\Annotation\Mapping\Inject()
     *
     * @var \App\OfficialAccount\Domain\SendToNodeDomain
     */
    protected SendToNodeDomain $callbackNodeDomainService;

    /**
     * 列表数据
     *
     * @param int|null $officialAccountId
     * @param IndexDTO $DTO
     *
     * @return array
     */
    public function indexProvider(?int $officialAccountId, IndexDTO $DTO): array
    {
        if (null === $officialAccountId) {
            return [];
        }
        return $this->userDomain->index($officialAccountId, $DTO->toArrayLine());
    }

    /**
     * @param string $openid
     *
     * @return array
     */
    public function viewProvider(string $openid): array
    {
        return $this->userDomain->view($openid);
    }

    /**
     * @param string $openid
     *
     * @return int
     */
    public function deleteProvider(string $openid): int
    {
        return $this->userDomain->delete($openid);
    }

    /**
     * @param string    $openid
     * @param UpdateDTO $DTO
     *
     * @return \Swoft\Stdlib\Collection
     */
    public function updateProvider(string $openid, UpdateDTO $DTO): Collection
    {
        $attributes = $DTO->toArrayNotNull([], true);
        $this->userDomain->update($openid, $attributes);
        return Collection::make($DTO);
    }
}
