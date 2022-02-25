<?php declare(strict_types=1);
/**
 * This file is part of Agarwood Cloud.
 *
 * @link     https://www.agarwood-cloud.com
 * @document https://www.agarwood-cloud.com/docs
 * @contact  676786620@qq.com
 * @author   agarwood
 */

namespace App\Assign\Domain\Aggregate\Repository;

/**
 * @\Swoft\Bean\Annotation\Mapping\Bean()
 */
interface AssignSettingRepository
{
    /**
     * 记录抢粉信息
     *
     * @param int $platformId
     * @param int $customerId
     * @param string $openid
     * @param string $obtainStatus
     *
     * @return bool
     */
    public function recordAssignFans(int $platformId, int $customerId, string $openid, string $obtainStatus = 'obtain'): bool;

    /**
     * 是否设置抢粉的信息
     *
     * @param int $customerId
     *
     * @return array
     */
    public function hasSettingAssign(int $customerId): array;

    /**
     * 查找该分配粉丝的部门及相关参数部
     *      Tips: 门分配粉丝为0的，不分配粉丝
     *
     * @param int $platformId
     *
     * @return array
     */
    public function getDepartments(int $platformId): array;

    /**
     * 客户所在的组别信息
     *
     * @param string $id
     *
     * @return array
     */
    public function customerGroup(string $id): array;

    /**
     * 抢粉部门设置
     *
     * @param string $id
     *
     * @return array
     */
    public function customerCompetitiveDepartment(string $id): array;
}
