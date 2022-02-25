<?php declare(strict_types=1);
/**
 * This file is part of Agarwood Cloud.
 *
 * @link     https://www.agarwood-cloud.com
 * @document https://www.agarwood-cloud.com/docs
 * @contact  676786620@qq.com
 * @author   agarwood
 */

namespace App\Customer\Application;

use App\Customer\Interfaces\DTO\CustomerToDo\CreateDTO;
use App\Customer\Interfaces\DTO\CustomerToDo\IndexDTO;
use App\Customer\Interfaces\DTO\CustomerToDo\UpdateDTO;
use Swoft\Stdlib\Collection;

/**
 * @\Swoft\Bean\Annotation\Mapping\Bean()
 */
interface CustomerToDoApplication
{
    /**
     * 应用层
     *      分组应用层列表服务接口
     *
     * @param int      $platformId
     * @param int      $customerId
     * @param IndexDTO $DTO
     *
     * @return array
     */
    public function indexProvider(int $platformId, int $customerId, IndexDTO $DTO): array;

    /**
     * 应用层
     *      分组应用层创建分组服务接口
     *
     * @param int       $platformId
     * @param int       $customerId
     * @param CreateDTO $DTO
     *
     * @return Collection
     */
    public function createProvider(int $platformId, int $customerId, CreateDTO $DTO): Collection;

    /**
     * 应用层
     *      分组应用层删除分组服务接口
     *
     * @param string $ids
     *
     * @return int|null
     */
    public function deleteProvider(string $ids): ?int;

    /**
     * 应用层
     *      分组应用层更新分组分组服务接口
     *
     * @param int       $id
     * @param UpdateDTO $DTO
     *
     * @return Collection
     */
    public function updateProvider(int $id, UpdateDTO $DTO): Collection;
}
