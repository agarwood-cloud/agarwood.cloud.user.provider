<?php declare(strict_types=1);
/**
 * This file is part of Agarwood Cloud.
 *
 * @link     https://www.agarwood-cloud.com
 * @document https://www.agarwood-cloud.com/docs
 * @contact  676786620@qq.com
 * @author   agarwood
 */

namespace App\OfficialAccount\Domain;

use App\OfficialAccount\Domain\Aggregate\Entity\CustomerAutoReply;
use App\OfficialAccount\Interfaces\DTO\AutoReply\UpdateDTO;

/**
 * @\Swoft\Bean\Annotation\Mapping\Bean()
 */
interface AutoReplyDomainService
{
    /**
     *
     * @param int $platformId
     * @param int $customerId
     * @param array  $filter       过滤条件
     * @param bool   $isPagination 是否分页
     *
     * @return array
     */
    public function index(int $platformId, int $customerId, array $filter, bool $isPagination = true): array;

    /**
     * 新建
     *
     * @param array $attributes
     *
     * @return CustomerAutoReply|null
     */
    public function create(array $attributes): ?CustomerAutoReply;

    /**
     * 更新
     *
     * @param string    $uuid 分组uuid
     * @param UpdateDTO $DTO
     *
     * @return int|null
     */
    public function update(string $uuid, UpdateDTO $DTO): ?int;

    /**
     * 删除
     *
     * @param string $uuid
     *
     * @return int|null
     */
    public function delete(string $uuid): ?int;

    /**
     * 保存或者更新
     *
     * @param array $attributes
     * @param array $value
     *
     * @return CustomerAutoReply
     */
    public function updateOrCreate(array $attributes, array $value): CustomerAutoReply;
}
