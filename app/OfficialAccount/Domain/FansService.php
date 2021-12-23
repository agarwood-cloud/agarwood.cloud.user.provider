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

use App\OfficialAccount\Interfaces\DTO\Fans\GroupUserDTO;
use App\OfficialAccount\Interfaces\DTO\Fans\MoveGroupDTO;
use App\OfficialAccount\Interfaces\DTO\Fans\UpdateDTO;

/**
 * @\Swoft\Bean\Annotation\Mapping\Bean()
 */
interface FansService
{
    /**
     * 领域服务接口： 获取列表
     *
     *
     * @param int $customerId
     * @param array  $filter       过滤条件
     * @param bool   $isPagination 是否分页
     *
     * @return array
     */
    public function index(int $customerId, array $filter, bool $isPagination = true): array;

    /**
     * 领域服务接口： 更新
     *
     * @param string    $uuid 分组uuid
     * @param UpdateDTO $DTO
     *
     * @return int|null
     */
    public function update(string $uuid, UpdateDTO $DTO): ?int;

    /**
     * 领域服务接口： 预览
     *
     * @param string $openid
     *
     * @return array
     */
    public function view(string $openid): array;

    /**
     * @param string                                                $customerId
     * @param \App\OfficialAccount\Interfaces\DTO\Fans\GroupUserDTO $dto
     *
     * @return array
     */
    public function groupUser(int $customerId, GroupUserDTO $dto): array;

    /**
     * @param string                                                $openid
     * @param \App\OfficialAccount\Interfaces\DTO\Fans\MoveGroupDTO $DTO
     *
     * @return array
     */
    public function moveGroup(string $openid, MoveGroupDTO $DTO): array;

    /**
     * 粉丝信息
     *
     * @param string $openid
     *
     * @return array
     */
    public function subscribe(string $openid): array;

    /**
     * 我的待办信息
     *
     * @param string $openid
     *
     * @return array
     */
    public function toDoListEvent(string $openid): array;
}
