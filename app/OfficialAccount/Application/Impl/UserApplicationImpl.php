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
use App\OfficialAccount\Domain\UserDomain;
use App\OfficialAccount\Interfaces\DTO\User\IndexDTO;
use App\OfficialAccount\Interfaces\DTO\User\UpdateDTO;
use App\OfficialAccount\Interfaces\Rpc\Client\OrderCenter\FansTimelineOrderRpc;
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
     * @var \App\OfficialAccount\Interfaces\Rpc\Client\OrderCenter\FansTimelineOrderRpc
     */
    public FansTimelineOrderRpc $fansTimelineOrderRpc;

    /**
     * User list data
     *
     * @param int|null $platformId
     * @param IndexDTO $DTO
     *
     * @return array
     */
    public function indexProvider(?int $platformId, IndexDTO $DTO): array
    {
        if (null === $platformId) {
            return [];
        }
        return $this->userDomain->index($platformId, $DTO->toArrayLine());
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

    /**
     * todo: View fans' records??? such as subscribe status, create order, todo list,  and so on!
     *
     * @param string $openid
     *
     * @return array
     */
    public function timelineProvider(string $openid): array
    {
        // ???????????? & ???????????? & ??????????????????
        $subscribe = $this->userDomain->subscribe($openid);

        // ????????????????????????????????????
        $order = $this->fansTimelineOrderRpc->timelineOrderByOpenid($openid);

        // ????????????
        $event = $this->userDomain->toDoListEvent($openid);

        // todo ????????????

        return array_merge($subscribe, $order, $event);
    }
}
