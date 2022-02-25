<?php declare(strict_types=1);
/**
 * This file is part of Agarwood Cloud.
 *
 * @link     https://www.agarwood-cloud.com
 * @document https://www.agarwood-cloud.com/docs
 * @contact  676786620@qq.com
 * @author   agarwood
 */

namespace App\Assign\Domain;

use App\Assign\Domain\Aggregate\Entity\CustomerCompetitive;
use App\Assign\Interfaces\DTO\Competitive\ChangeStatusDTO;
use App\Assign\Interfaces\DTO\Competitive\UpdateDTO;

/**
 * @\Swoft\Bean\Annotation\Mapping\Bean()
 */
interface CompetitiveDomainService
{
    /**
     * 领域服务接口： 获取列表
     *
     * @param int   $tencentId
     * @param array $filter 过滤条件
     *
     * @return array
     */
    public function index(int $tencentId, array $filter): array;

    /**
     *  领域服务接口： 新建
     *
     * @param array $attributes
     *
     * @return bool
     */
    public function create(array $attributes): bool;

    /**
     *  领域服务接口： 新建
     *
     * @param int       $id
     * @param UpdateDTO $DTO
     *
     * @return CustomerCompetitive | null
     */
    public function update(int $id, UpdateDTO $DTO): ?CustomerCompetitive;

    /**
     *  领域服务接口： 更新
     *
     * @param int             $id
     * @param ChangeStatusDTO $DTO 更新字段
     *
     * @return int
     */
    public function changeStatus(int $id, ChangeStatusDTO $DTO): int;

    /**
     * 领域服务接口： 抢粉
     *
     * @param int $tencentId
     * @param int $customerId
     *
     * @return int
     */
    public function obtainFans(int $tencentId, int $customerId): int;
}
