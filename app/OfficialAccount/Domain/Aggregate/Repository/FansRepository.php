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
interface FansRepository
{
    /**
     * 客服对应的粉丝列表
     *
     * @param int   $customerId
     * @param array $filter
     *
     * @return array
     */
    public function index(int $customerId, array $filter): array;

    /**
     * 更新信息
     *
     * @param string $openid
     * @param array  $attributes
     *
     * @return int
     */
    public function update(string $openid, array $attributes): int;

    /**
     * 预览
     *
     * @param int $id
     *
     * @return array
     */
    public function view(int $id): array;

    /**
     * 客服该分组下的粉丝
     *
     * @param int   $customerId
     * @param array $filter
     *
     * @return array
     */
    public function groupUser(int $customerId, array $filter): array;

    /**
     * 移动粉丝到分组
     *
     * @param string $openid
     * @param array  $attributes
     *
     * @return int
     */
    public function moveGroup(string $openid, array $attributes): int;

    /**
     * @param string $openid
     *
     * @return array
     */
    public function findByOpenid(string $openid): array;
}
