<?php declare(strict_types=1);
/**
 * This file is part of Agarwood Cloud.
 *
 * @link     https://www.agarwood-cloud.com
 * @document https://www.agarwood-cloud.com/docs
 * @contact  676786620@qq.com
 * @author   agarwood
 */

namespace App\Customer\Domain\Aggregate\Repository;

/**
 * @\Swoft\Bean\Annotation\Mapping\Bean()
 */
interface CustomerObtainFansRepository
{
    /**
     * 创建
     *
     * @param array $attributes
     *
     * @return bool
     */
    public function create(array $attributes): bool;

    /**
     * 某个时间段内圈粉数量
     *
     * @param int    $customerId
     * @param string $startAt
     * @param string $endAt
     *
     * @return int
     */
    public function obtainFansBetweenTime(int $customerId, string $startAt, string $endAt): int;

    /**
     * 部门在某个时间段内圈粉数量
     *
     * @param int    $departmentId
     * @param string $startAt
     * @param string $endAt
     *
     * @return int
     */
    public function obtainFansBetweenTimeByDepartment(int $departmentId, string $startAt, string $endAt): int;

    /**
     * 查找该公众号最后一个抢粉的信息
     *
     * @param int $tencentId
     *
     * @return array
     */
    public function lastOfficialAccountObtainFans(int $tencentId): array;

    /**
     * 查找部门最后一个抢粉的信息
     *
     * @param int $departmentId
     *
     * @return array
     */
    public function lastDepartmentObtainFans(int $departmentId): array;
}
