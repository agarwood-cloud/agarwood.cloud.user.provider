<?php declare(strict_types=1);
/**
 * This file is part of Agarwood Cloud.
 *
 * @link     https://www.agarwood-cloud.com
 * @document https://www.agarwood-cloud.com/docs
 * @contact  676786620@qq.com
 * @author   agarwood
 */

namespace App\OfficialAccount\Domain\Impl;

use App\OfficialAccount\Domain\Aggregate\Entity\CustomerAutoReply;
use App\OfficialAccount\Domain\Aggregate\Repository\AutoReplyRepository;
use App\OfficialAccount\Domain\AutoReplyDomainService;
use App\OfficialAccount\Interfaces\DTO\AutoReply\UpdateDTO;

/**
 * @\Swoft\Bean\Annotation\Mapping\Bean()
 */
class AutoReplyDomainServiceImpl implements AutoReplyDomainService
{
    /**
     * @\Swoft\Bean\Annotation\Mapping\Inject()
     *
     * @var AutoReplyRepository
     */
    protected AutoReplyRepository $autoReplyRepository;

    public function index(int $tencentId, int $customerId, array $filter, bool $isPagination = true): array
    {
        $auto            = $this->autoReplyRepository->auto($tencentId, $customerId);
        $quick           = $this->autoReplyRepository->index($tencentId, $customerId, $filter, $isPagination);
        $quick['list'][] = $auto;
        return $quick;
    }

    public function create(array $attributes): ?CustomerAutoReply
    {
        return $this->autoReplyRepository->create($attributes);
    }

    public function update(string $uuid, UpdateDTO $DTO): ?int
    {
        return $this->autoReplyRepository->update($uuid, $DTO->toArrayLine());
    }

    public function delete(string $uuid): ?int
    {
        return $this->autoReplyRepository->delete($uuid);
    }

    public function updateOrCreate(array $attributes, array $value): CustomerAutoReply
    {
        return $this->autoReplyRepository->updateOrCreate($attributes, $value);
    }
}
