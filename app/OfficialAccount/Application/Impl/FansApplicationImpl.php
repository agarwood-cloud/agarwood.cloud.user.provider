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

use App\OfficialAccount\Application\Bo\CustomerToDo\TimelineBo;
use App\OfficialAccount\Application\FansApplication;
use App\OfficialAccount\Domain\FansService;
use App\OfficialAccount\Interfaces\DTO\Fans\GroupUserDTO;
use App\OfficialAccount\Interfaces\DTO\Fans\IndexDTO;
use App\OfficialAccount\Interfaces\DTO\Fans\MoveGroupDTO;
use App\OfficialAccount\Interfaces\DTO\Fans\UpdateDTO;
use App\OfficialAccount\Interfaces\Rpc\Client\OrderCenter\FansTimelineOrderRpc;
use Swoft\Stdlib\Collection;

/**
 * @\Swoft\Bean\Annotation\Mapping\Bean()
 */
class FansApplicationImpl implements FansApplication
{
    /**
     * 分组领域服务
     *
     * @\Swoft\Bean\Annotation\Mapping\Inject()
     *
     * @var FansService
     */
    protected FansService $domain;

    /**
     * @\Swoft\Bean\Annotation\Mapping\Inject()
     *
     * @var FansTimelineOrderRpc
     */
    protected FansTimelineOrderRpc $fansTimelineOrderRpc;

    /**
     * @\Swoft\Bean\Annotation\Mapping\Inject()
     *
     * @var TimelineBo
     */
    protected TimelineBo $timelineBo;

    /**
     * @inheritDoc
     */
    public function indexProvider(int $customerId, IndexDTO $DTO, bool $isPagination = true): array
    {
        return $this->domain->index($customerId, $DTO->toArrayLine(), $isPagination);
    }

    /**
     * @inheritDoc
     */
    public function updateProvider(string $uuid, UpdateDTO $DTO): Collection
    {
        $result = $this->domain->update($uuid, $DTO);
        return Collection::make($result);
    }

    /**
     * @inheritDoc
     */
    public function viewProvider(string $openid): array
    {
        return $this->domain->view($openid);
    }

    /**
     * @param string                                                $customerId
     * @param \App\OfficialAccount\Interfaces\DTO\Fans\GroupUserDTO $dto
     *
     * @return array
     */
    public function groupUserProvider(int $customerId, GroupUserDTO $dto): array
    {
        return $this->domain->groupUser($customerId, $dto);
    }

    /**
     * @param \App\OfficialAccount\Interfaces\DTO\Fans\MoveGroupDTO $DTO
     *
     * @return \Swoft\Stdlib\Collection
     */
    public function moveGroupProvider(MoveGroupDTO $DTO): Collection
    {
        $result = $this->domain->moveGroup($DTO->getOpenid(), $DTO);
        return Collection::make($result);
    }

    /**
     * 粉丝时间线
     *
     * @param string $openid
     *
     * @return array
     */
    public function timelineProvider(string $openid): array
    {
        // 关注时间 & 取关时间 & 再次关注时间
        $subscribe = $this->domain->subscribe($openid);

        // 购买商品，包含所有的订单
        $order = $this->fansTimelineOrderRpc->timelineOrderByOpenid($openid);

        // 跟进事项
        $event = $this->domain->toDoListEvent($openid);

        /*
        |--------------------------------------------------------------------------
        | 粉丝活动轨迹的时间线【数组格式】
        |--------------------------------------------------------------------------
        |   $event = [
        |       [
        |           'timeline' => '2021年10月10日',
        |           'event'    => '粉丝关注'
        |       ]
        |   ];
        */

        // 按时间排序
        return $this->timelineBo->map($subscribe, $order, $event);
    }
}
