<?php declare(strict_types=1);
/**
 * This file is part of Agarwood Cloud.
 *
 * @link     https://www.agarwood-cloud.com
 * @document https://www.agarwood-cloud.com/docs
 * @contact  676786620@qq.com
 * @author   agarwood
 */

namespace App\OfficialAccount\Domain\Aggregate\Repository;

/**
 * @\Swoft\Bean\Annotation\Mapping\Bean()
 */
interface UserRepository
{
    /**
     * 列表数据
     *
     * @param int   $officialAccountId
     * @param array $filter
     *
     * @return array
     */
    public function index(int $officialAccountId, array $filter): array;

    /**
     * 创建
     *
     * @param array $attributes
     *
     * @return bool
     */
    public function create(array $attributes): bool;

    /**
     * 删除
     *
     * @param string $openid
     *
     * @return int
     */
    public function delete(string $openid): int;

    /**
     * @param string $openid
     * @param array  $attributes
     *
     * @return int
     */
    public function update(string $openid, array $attributes): int;

    /**
     * @param string $openid
     *
     * @return array
     */
    public function view(string $openid): array;

    /**
     * 检查用户是否存在
     *
     * @param string $openid
     *
     * @return array
     */
    public function findOpenid(string $openid): array;

    /**
     * 粉丝列表数据
     *
     * @param array $filter
     *
     * @return array
     */
    public function indexV3(array $filter): array;

    /**
     * 查找用户信息
     *
     * @param string $openid
     *
     * @return array
     */
    public function findByOpenid(string $openid): array;
}
