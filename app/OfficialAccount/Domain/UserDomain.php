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

use App\OfficialAccount\Domain\Aggregate\Entity\User;
use App\OfficialAccount\Interfaces\DTO\User\IndexDTO;

/**
 * @\Swoft\Bean\Annotation\Mapping\Bean()
 */
interface UserDomain
{
    /**
     * Get user list for Query Builder
     *
     * @param int   $officialAccountId
     * @param array $filter
     *
     * @return array
     */
    public function index(int $officialAccountId, array $filter): array;

    /**
     * @param string $openid
     * @param array  $attributes
     *
     * @return int
     */
    public function update(string $openid, array $attributes): int;

    /**
     * agarwood.cloud.user.center.provider - 领域服务接口： 预览
     *
     * @param string $openid
     *
     * @return array
     */
    public function view(string $openid): array;

    /**
     * Delete user by openid
     *
     * @param string $openid
     *
     * @return int
     */
    public function delete(string $openid): int;

    /**
     * 领域服务接口： 登陆
     *
     * @param IndexDTO $DTO
     * @param bool     $isPagination
     *
     * @return array
     */
    public function indexV3(IndexDTO $DTO, bool $isPagination): array;
}
