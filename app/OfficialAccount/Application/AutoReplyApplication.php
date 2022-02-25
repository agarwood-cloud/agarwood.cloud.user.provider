<?php declare(strict_types=1);
/**
 * This file is part of Agarwood Cloud.
 *
 * @link     https://www.agarwood-cloud.com
 * @document https://www.agarwood-cloud.com/docs
 * @contact  676786620@qq.com
 * @author   agarwood
 */

namespace App\OfficialAccount\Application;

use App\OfficialAccount\Interfaces\DTO\AutoReply\CreateDTO;
use App\OfficialAccount\Interfaces\DTO\AutoReply\IndexDTO;
use App\OfficialAccount\Interfaces\DTO\AutoReply\SaveDTO;
use App\OfficialAccount\Interfaces\DTO\AutoReply\UpdateDTO;
use Swoft\Stdlib\Collection;

/**
 * @\Swoft\Bean\Annotation\Mapping\Bean()
 */
interface AutoReplyApplication
{
    /**
     * 应用层
     *      分组应用层列表服务接口
     *
     * @param string   $tencentId
     * @param string   $customerId
     * @param IndexDTO $DTO
     * @param bool     $isPagination
     *
     * @return array
     */
    public function indexProvider(int $tencentId, int $customerId, IndexDTO $DTO, bool $isPagination = true): array;

    /**
     * 应用层
     *      分组应用层创建分组服务接口
     *
     * @param string    $tencentId
     * @param string    $customerId
     * @param CreateDTO $DTO
     *
     * @return Collection
     */
    public function createProvider(int $tencentId, int $customerId, CreateDTO $DTO): Collection;

    /**
     * 应用层
     *      分组应用层删除分组服务接口
     *
     * @param string $uuids
     *
     * @return int|null
     */
    public function deleteProvider(string $uuids): ?int;

    /**
     * 应用层
     *      分组应用层更新分组分组服务接口
     *
     * @param string    $uuid
     * @param UpdateDTO $DTO
     *
     * @return Collection
     */
    public function updateProvider(string $uuid, UpdateDTO $DTO): Collection;

    /**
     * @param string  $tencentId
     * @param string  $customerId
     * @param SaveDTO $DTO
     *
     * @return Collection
     */
    public function saveProvider(int $tencentId, int $customerId, SaveDTO $DTO): Collection;
}
