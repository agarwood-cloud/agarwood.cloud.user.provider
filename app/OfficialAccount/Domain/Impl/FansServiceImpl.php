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

use App\Customer\Domain\Aggregate\Repository\CustomerToDoRepository;
use App\OfficialAccount\Domain\Aggregate\Repository\FansRepository;
use App\OfficialAccount\Domain\FansService;
use App\OfficialAccount\Infrastructure\Redis\RedisUser;
use App\OfficialAccount\Interfaces\DTO\Fans\GroupUserDTO;
use App\OfficialAccount\Interfaces\DTO\Fans\MoveGroupDTO;
use App\OfficialAccount\Interfaces\DTO\Fans\UpdateDTO;

/**
 * @\Swoft\Bean\Annotation\Mapping\Bean()
 */
class FansServiceImpl implements FansService
{
    /**
     * @\Swoft\Bean\Annotation\Mapping\Inject()
     *
     * @var RedisUser
     */
    protected RedisUser $redisUser;

    /**
     * @\Swoft\Bean\Annotation\Mapping\Inject()
     *
     * @var CustomerToDoRepository
     */
    protected CustomerToDoRepository $toDoDao;

    /**
     * @\Swoft\Bean\Annotation\Mapping\Inject()
     *
     * @var FansRepository
     */
    protected FansRepository $fansDao;

    public function index(int $customerId, array $filter, bool $isPagination = true): array
    {
        return $this->fansDao->index($customerUuid, $filter, $isPagination);
    }

    public function update(string $uuid, UpdateDTO $DTO): ?int
    {
        return $this->fansDao->update($uuid, $DTO->toArrayLine());
    }

    /**
     * 查看粉丝的信息
     *
     * @param string $openid
     *
     * @return array
     */
    public function view(string $openid): array
    {
        // 先读取缓存的数据
        $user = $this->redisUser->getCacheFromRedis($openid);

        if ($user) {
            return $user;
        }

        // 如果不存在则读取数据库的数据
        $user = $this->fansDao->view($openid);

        return $user ? ['user' => $user->toArray()] : ['user' => []];
    }

    /**
     * 该客服分组下的用户
     *
     * @param string       $customerUuid
     * @param GroupUserDTO $dto
     *
     * @return array
     */
    public function groupUser(int $customerId, GroupUserDTO $dto): array
    {
        return $this->fansDao->groupUser($customerUuid, $dto->toArrayLine());
    }

    /**
     * 移动粉丝到分组
     *
     * @param string                                                $openid
     * @param \App\OfficialAccount\Interfaces\DTO\Fans\MoveGroupDTO $DTO
     *
     * @return array
     */
    public function moveGroup(string $openid, MoveGroupDTO $DTO): array
    {
        $this->fansDao->moveGroup($openid, $DTO->toArrayLine());

        $view = $this->fansDao->view($openid);
        return $view ? $view->toArray() : [];
    }

    /**
     * @param string $openid
     *
     * @return array
     */
    public function subscribe(string $openid): array
    {
        return $this->fansDao->findByOpenid($openid);
    }

    /**
     * @param string $openid
     *
     * @return array
     */
    public function toDoListEvent(string $openid): array
    {
        return $this->toDoDao->toDoListEvent($openid);
    }
}
