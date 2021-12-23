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

use App\Assign\Interfaces\DTO\Department\CreateDTO;
use App\Assign\Interfaces\DTO\Department\IndexDTO;
use App\Assign\Interfaces\DTO\Department\ChangeStatusDTO;
use App\Assign\Interfaces\DTO\Department\UpdateDTO;
use Swoft\Stdlib\Collection;

/**
 * @\Swoft\Bean\Annotation\Mapping\Bean()
 */
interface CompetitiveDepartmentApplication
{
    /**
     * 应用层
     *      综合竞争力列表服务接口
     *
     *
     * @param string   $officialAccountId
     * @param IndexDTO $DTO
     * @param bool     $isPagination
     *
     * @return array
     */
    public function indexProvider(int $officialAccountId, IndexDTO $DTO, bool $isPagination = true): array;

    /**
     * 应用层
     *      综合竞争力服务接口
     *
     * @param string    $officialAccountId
     * @param CreateDTO $DTO
     *
     * @return Collection
     */
    public function createProvider(int $officialAccountId, CreateDTO $DTO): Collection;

    /**
     * 应用层
     *      综合竞争力服务接口
     *
     * @param string    $uuid
     * @param UpdateDTO $DTO
     *
     * @return Collection
     */
    public function updateProvider(string $uuid, UpdateDTO $DTO): Collection;

    /**
     *  应用层
     *      综合竞争力服务接口
     *
     * @param array           $uuids
     * @param ChangeStatusDTO $DTO
     *
     * @return Collection
     */
    public function changeStatusProvider(array $uuids, ChangeStatusDTO $DTO): Collection;
}
