<?php declare(strict_types=1);
/**
 * This file is part of Agarwood Cloud.
 *
 * @link     https://www.agarwood-cloud.com
 * @document https://www.agarwood-cloud.com/docs
 * @contact  676786620@qq.com
 * @author   agarwood
 */

namespace App\Assign\Domain\Impl;

use App\Assign\Domain\Aggregate\Entity\CustomerCompetitive;
use App\Assign\Domain\Aggregate\Repository\CompetitiveRepository;
use App\Assign\Domain\AssignQueue;
use App\Assign\Domain\CompetitiveDomainService;
use App\Assign\Interfaces\DTO\Competitive\ChangeStatusDTO;
use App\Assign\Interfaces\DTO\Competitive\UpdateDTO;

/**
 * @\Swoft\Bean\Annotation\Mapping\Bean()
 */
class CompetitiveDomainServiceImpl implements CompetitiveDomainService
{
    /**
     * @\Swoft\Bean\Annotation\Mapping\Inject()
     *
     * @var CompetitiveRepository $competitiveRepository
     */
    protected CompetitiveRepository $competitiveRepository;

    /**
     * @\Swoft\Bean\Annotation\Mapping\Inject()
     *
     * @var AssignQueue
     */
    protected AssignQueue $competitive;

    /**
     * @param int   $platformId
     * @param array $filter
     *
     * @return array
     */
    public function index(int $platformId, array $filter): array
    {
        return $this->competitiveRepository->index($platformId, $filter);
    }

    /**
     * @param array $attributes
     *
     * @return bool
     */
    public function create(array $attributes): bool
    {
        return $this->competitiveRepository->create($attributes);
    }

    /**
     * @param int       $id
     * @param UpdateDTO $DTO
     *
     * @return CustomerCompetitive |null
     */
    public function update(int $id, UpdateDTO $DTO): ?CustomerCompetitive
    {
        //如果请求参数中不存在，则恢复为默认值
        $attributes = $DTO->toArrayLine();
        $this->competitiveRepository->update($id, $attributes);

        //重新查找并返回结果集
        return $this->competitiveRepository->view($id);
    }

    /**
     * 更新可分配的状态
     *
     * @param int             $id
     * @param ChangeStatusDTO $DTO
     *
     * @return int
     */
    public function changeStatus(int $id, ChangeStatusDTO $DTO): int
    {
        //如果请求参数中不存在，则恢复为默认值
        $attributes = $DTO->toArrayNotNull();
        return $this->competitiveRepository->changeStatus($uuid, $attributes);
    }

    /**
     * 抢粉
     *
     * @param int $platformId
     * @param int $customerId
     *
     * @return int
     */
    public function obtainFans(int $platformId, int $customerId): int
    {
        // 加入到抢粉的队列里面, 如果有自定义综合竞争力，则优先按自定义综合竞争力来算
        $this->competitive->pushQueue($platformId, $customerId);

        return 1;
    }
}
