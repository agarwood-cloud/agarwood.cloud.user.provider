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
interface CustomerAssignRepository
{
    /**
     * 客服5天内新粉的数量
     *
     * @param int $id
     * @param string $startAt
     * @param string $endAt
     *
     * @return int
     */
    public function daysFans(int $id, string $startAt, string $endAt): int;

    /**
     * 获取客服的信息
     *
     * @param int $id
     *
     * @return array
     */
    public function getCustomer(int $id): array;

    /**
     * 抢粉数量
     *
     * @param int    $customerId
     * @param string $startAt
     * @param string $endAt
     *
     * @return array
     */
    public function obtainFans(int $customerId, string $startAt, string $endAt): array;

    /**
     * 查找可用的该公众号的客服
     *
     * @param int $platformId
     *
     * @return array
     */
    public function getCustomerUuidByServiceUuid(int $platformId): array;

    /**
     * 查找所在的部门
     *
     * @param string $ids
     *
     * @return array
     */
    public function getCustomerDepartment(string $ids): array;
}
