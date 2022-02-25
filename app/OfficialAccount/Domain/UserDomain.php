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

/**
 * @\Swoft\Bean\Annotation\Mapping\Bean()
 */
interface UserDomain
{
    /**
     * Get user list for Query Builder
     *
     * @param int   $tencentId
     * @param array $filter
     *
     * @return array
     */
    public function index(int $tencentId, array $filter): array;

    /**
     * @param string $openid
     * @param array  $attributes
     *
     * @return int
     */
    public function update(string $openid, array $attributes): int;

    /**
     * view info
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
}
