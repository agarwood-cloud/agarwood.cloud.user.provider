<?php declare(strict_types=1);
/**
 * This file is part of Agarwood Cloud.
 *
 * @link     https://www.agarwood-cloud.com
 * @document https://www.agarwood-cloud.com/docs
 * @contact  676786620@qq.com
 * @author   agarwood
 */

namespace App\Assign\Application;

use App\Assign\Interfaces\DTO\Competitive\ChangeStatusDTO;
use App\Assign\Interfaces\DTO\Competitive\CreateDTO;
use App\Assign\Interfaces\DTO\Competitive\IndexDTO;
use App\Assign\Interfaces\DTO\Competitive\UpdateDTO;
use Swoft\Stdlib\Collection;

/**
 * @\Swoft\Bean\Annotation\Mapping\Bean()
 */
interface CompetitiveApplication
{
    /**
     * 应用层
     *      综合竞争力列表服务接口
     *
     *
     * @param int      $platformId
     * @param IndexDTO $DTO
     *
     * @return array
     */
    public function indexProvider(int $platformId, IndexDTO $DTO): array;

    /**
     * 应用层
     *      综合竞争力服务接口
     *
     * @param int       $platformId
     * @param CreateDTO $DTO
     *
     * @return Collection
     */
    public function createProvider(int $platformId, CreateDTO $DTO): Collection;

    /**
     * 应用层
     *      综合竞争力服务接口
     *
     * @param int       $id
     * @param UpdateDTO $DTO
     *
     * @return Collection
     */
    public function updateProvider(int $id, UpdateDTO $DTO): Collection;

    /**
     *  应用层
     *      综合竞争力服务接口
     *
     * @param int             $id
     * @param ChangeStatusDTO $DTO
     *
     * @return Collection
     */
    public function changeStatusProvider(int $id, ChangeStatusDTO $DTO): Collection;

    /**
     * 圈粉应用提供者
     *
     * @param int $platformId
     * @param int $customerId
     *
     * @return int
     */
    public function obtainFansProvider(int $platformId, int $customerId): int;
}
