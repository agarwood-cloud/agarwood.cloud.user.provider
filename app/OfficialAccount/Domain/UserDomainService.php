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
interface UserDomainService
{
    /**
     *  获取列表
     *
     * @param int   $officialAccountId
     * @param array $filter 过滤条件
     *
     * @return array
     */
    public function index(int $officialAccountId, array $filter): array;

    /**
     * agarwood.cloud.user.center.provider - 领域服务接口： 新建
     *
     * @param array $attributes
     *
     * @return User
     */
    public function create(array $attributes): User;

    /**
     * agarwood.cloud.user.center.provider - 领域服务接口： 更新
     *
     * @param string $openid     模板uuid
     * @param array  $attributes 更新字段
     *
     * @return int|null
     */
    public function update(string $openid, array $attributes): ?int;

    /**
     * agarwood.cloud.user.center.provider - 领域服务接口： 预览
     *
     * @param string $openid
     *
     * @return array
     */
    public function view(string $openid): array;

    /**
     * agarwood.cloud.user.center.provider - 领域服务接口： 删除
     *
     * @param string $openid
     *
     * @return bool|null
     */
    public function delete(string $openid): ?bool;

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
