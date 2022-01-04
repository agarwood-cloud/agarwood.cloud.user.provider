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

use App\OfficialAccount\Interfaces\DTO\Fans\GroupUserDTO;
use App\OfficialAccount\Interfaces\DTO\Fans\IndexDTO;
use App\OfficialAccount\Interfaces\DTO\Fans\MoveGroupDTO;
use App\OfficialAccount\Interfaces\DTO\Fans\UpdateDTO;
use Swoft\Stdlib\Collection;

/**
 * @\Swoft\Bean\Annotation\Mapping\Bean()
 */
interface FansApplication
{
    /**
     * 应用层
     *      分组应用层列表服务接口
     *
     * @param int   $customerId
     * @param IndexDTO $DTO
     * @param bool     $isPagination
     *
     * @return array
     */
    public function indexProvider(int $customerId, IndexDTO $DTO, bool $isPagination = true): array;

    /**
     * 应用层
     *      分组应用层更新分组分组服务接口
     *
     * @param string    $uuid
     * @param UpdateDTO $DTO
     *
     * @return Collection
     */
    public function updateProvider(string $uuid, UpdateDTO $DTO): Collection;

    /**
     * 应用层
     *      分组应用层分组详情分组服务接口
     *
     * @param string $openid
     *
     * @return array
     */
    public function viewProvider(string $openid): array;

    /**
     * 应用层
     *      该客服下的粉丝分组
     *
     *
     * @param string       $customerId
     * @param GroupUserDTO $dto
     *
     * @return array
     */
    public function groupUserProvider(int $customerId, GroupUserDTO $dto): array;

    /**
     * 移动粉丝到xx 分组
     *
     * @param \App\OfficialAccount\Interfaces\DTO\Fans\MoveGroupDTO $DTO
     *
     * @return Collection
     */
    public function moveGroupProvider(MoveGroupDTO $DTO): Collection;

    /**
     * 粉丝时间线
     *
     * @param string $openid
     *
     * @return array
     */
    public function timelineProvider(string $openid): array;
}
