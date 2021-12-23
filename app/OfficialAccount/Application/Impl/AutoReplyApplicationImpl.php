<?php declare(strict_types=1);
/**
 * This file is part of Agarwood Cloud.
 *
 * @link     https://www.agarwood-cloud.com
 * @document https://www.agarwood-cloud.com/docs
 * @contact  676786620@qq.com
 * @author   agarwood
 */

namespace App\OfficialAccount\Application\Impl;

use App\OfficialAccount\Application\AutoReplyApplication;
use App\OfficialAccount\Domain\AutoReplyDomainService;
use App\OfficialAccount\Interfaces\DTO\AutoReply\CreateDTO;
use App\OfficialAccount\Interfaces\DTO\AutoReply\IndexDTO;
use App\OfficialAccount\Interfaces\DTO\AutoReply\SaveDTO;
use App\OfficialAccount\Interfaces\DTO\AutoReply\UpdateDTO;
use Agarwood\Core\Util\ArrayHelper;
use Exception;
use Swoft\Stdlib\Collection;

/**
 * @\Swoft\Bean\Annotation\Mapping\Bean()
 */
class AutoReplyApplicationImpl implements AutoReplyApplication
{
    /**
     * 分组领域服务
     *
     * @\Swoft\Bean\Annotation\Mapping\Inject()
     *
     * @var AutoReplyDomainService
     */
    protected AutoReplyDomainService $domain;

    /**
     * @inheritDoc
     * @throws Exception
     */
    public function indexProvider(int $officialAccountId, int $customerId, IndexDTO $DTO, bool $isPagination = true): array
    {
        $indexData = $this->domain->index($officialAccountId, $customerId, $DTO->toArrayLine(), $isPagination);

        if (isset($indexData['list'])) {
            $indexData['list'] = ArrayHelper::index($indexData['list'], null, 'autoType');
        }

        return $indexData;
    }

    /**
     * @inheritDoc
     */
    public function createProvider(int $officialAccountId, int $customerId, CreateDTO $DTO): Collection
    {
        //增加部分系统自己添加的参数 i.e: uuid
        $attributes                  = $DTO->toArrayLine();
        $attributes['service_uuid']  = $officialAccountId;
        $attributes['customer_uuid'] = $customerId;
        $attributes['auto_type']     = ReplyEnum::QUICK_REPLY_TYPE;
        $collection                  = $this->domain->create($attributes);
        //这里可以设置更多的返回值
        return Collection::make($collection);
    }

    /**
     * @inheritDoc
     */
    public function deleteProvider(string $uuids): ?int
    {
        return $this->domain->delete($uuids);
    }

    /**
     * @inheritDoc
     */
    public function updateProvider(string $uuid, UpdateDTO $DTO): Collection
    {
        $result = $this->domain->update($uuid, $DTO);
        return Collection::make($result);
    }

    /**
     * @param string                                                $officialAccountId
     * @param string                                                $customerId
     * @param \App\OfficialAccount\Interfaces\DTO\AutoReply\SaveDTO $DTO
     *
     * @return \Swoft\Stdlib\Collection
     */
    public function saveProvider(int $officialAccountId, int $customerId, SaveDTO $DTO): Collection
    {
        // 是否存在
        $attributes['service_uuid']  = $officialAccountId;
        $attributes['customer_uuid'] = $customerId;
        $attributes['auto_type']     = ReplyEnum::AUTO_REPLY_TYPE;

        // 需要保存或者更新的内容
        $value              = $DTO->toArrayLine();
        $value['event_key'] = ReplyEnum::EVENT_KEY;

        $collection = $this->domain->updateOrCreate($attributes, $value);
        //这里可以设置更多的返回值
        return Collection::make($collection);
    }
}
