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

use App\Customer\Interfaces\DTO\Group\CustomerGroupCreateDTO;
use App\Customer\Interfaces\DTO\Group\CustomerGroupIndexDTO;
use App\Customer\Interfaces\DTO\Group\CustomerGroupUpdateDTO;
use Swoft\Stdlib\Collection;

/**
 * @\Swoft\Bean\Annotation\Mapping\Bean()
 */
interface CustomerGroupApplication
{
    /**
     * 应用层
     *      分组应用层列表服务接口
     *
     * @param int                   $officialAccountId
     * @param CustomerGroupIndexDTO $DTO
     *
     * @return array
     */
    public function indexProvider(int $officialAccountId, CustomerGroupIndexDTO $DTO): array;

    /**
     * 应用层
     *      分组应用层创建分组服务接口
     *
     * @param int                    $officialAccountId
     * @param CustomerGroupCreateDTO $DTO
     *
     * @return Collection
     */
    public function createProvider(int $officialAccountId, CustomerGroupCreateDTO $DTO): Collection;

    /**
     * 应用层
     *      分组应用层删除分组服务接口
     *
     * @param string $uuids
     *
     * @return bool|null
     */
    public function deleteProvider(string $uuids): ?bool;

    /**
     * 应用层
     *      分组应用层更新分组分组服务接口
     *
     * @param int                    $id
     * @param CustomerGroupUpdateDTO $DTO
     *
     * @return Collection
     */
    public function updateProvider(int $id, CustomerGroupUpdateDTO $DTO): Collection;

    /**
     * 应用层
     *      分组应用层分组详情分组服务接口
     *
     * @param int $id
     *
     * @return array
     */
    public function viewProvider(int $id): array;
}
