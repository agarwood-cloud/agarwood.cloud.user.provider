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

use App\OfficialAccount\Interfaces\DTO\User\IndexDTO;
use App\OfficialAccount\Interfaces\DTO\User\UpdateGroupDTO;
use App\OfficialAccount\Interfaces\DTO\User\UserCreateDTO;
use App\OfficialAccount\Interfaces\DTO\User\UserIndexDTO;
use App\OfficialAccount\Interfaces\DTO\User\UserUpdateDTO;
use Swoft\Stdlib\Collection;

/**
 * 应用层
 *
 * @\Swoft\Bean\Annotation\Mapping\Bean()
 */
interface UserApplication
{
    /**
     * 客户列表
     *
     * @param int|null                                              $officialAccountId
     * @param \App\OfficialAccount\Interfaces\DTO\User\UserIndexDTO $DTO
     *
     * @return array
     */
    public function indexProvider(?int $officialAccountId, UserIndexDTO $DTO): array;

    public function createProvider(UserCreateDTO $DTO): Collection;

    public function deleteProvider(string $uuids): ?bool;

    public function updateProvider(string $openid, UserUpdateDTO $DTO): Collection;

    public function viewProvider(string $uuid): array;

    public function assignCustomerProvider(string $openid, UpdateGroupDTO $DTO): Collection;

    /**
     * 应用层
     *      粉丝列表服务接口
     *
     *
     * @param IndexDTO $DTO
     * @param bool     $isPagination
     *
     * @return array
     */
    public function indexV3Provider(IndexDTO $DTO, bool $isPagination = true): array;
}
