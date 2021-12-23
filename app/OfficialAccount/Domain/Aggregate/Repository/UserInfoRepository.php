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

use Swoft\Db\Exception\DbException;

/**
 * @\Swoft\Bean\Annotation\Mapping\Bean()
 */
interface UserInfoRepository
{
    /**
     * 服务号管理列表数据
     *
     * @param array $filter
     *
     * @return array
     * @throws DbException
     */
    public function index(array $filter): array;

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
    public static function findOpenid(string $openid): array;
}
