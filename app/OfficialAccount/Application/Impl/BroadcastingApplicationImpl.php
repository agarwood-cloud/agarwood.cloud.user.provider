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

use App\OfficialAccount\Application\BroadcastingApplication;
use App\OfficialAccount\Domain\BroadcastingDomainService;
use App\OfficialAccount\Interfaces\DTO\Broadcasting\FansGroupDTO;
use App\OfficialAccount\Interfaces\DTO\Broadcasting\IndexDTO;
use App\OfficialAccount\Interfaces\DTO\Broadcasting\SendTextDTO;
use App\OfficialAccount\Interfaces\Rpc\Client\MallCenter\OfficialAccountsRpc;

/**
 * @\Swoft\Bean\Annotation\Mapping\Bean()
 */
class BroadcastingApplicationImpl implements BroadcastingApplication
{
    /**
     * @\Swoft\Bean\Annotation\Mapping\Inject()
     *
     * @var BroadcastingDomainService $domain
     */
    protected BroadcastingDomainService $domain;

    /**
     * @\Swoft\Bean\Annotation\Mapping\Inject()
     *
     * @var OfficialAccountsRpc
     */
    protected OfficialAccountsRpc $serviceRpc;

    /**
     * 已发送的列表
     *
     * @param string   $platformId
     * @param IndexDTO $DTO
     * @param bool     $isPagination
     *
     * @return array
     */
    public function indexProvider(int $platformId, IndexDTO $DTO, bool $isPagination = true): array
    {
        return $this->domain->index($platformId, $DTO->toArrayLine(), $isPagination);
    }

    /**
     * @param string      $platformId
     * @param SendTextDTO $DTO
     *
     * @return array
     */
    public function sendTextProvider(int $platformId, SendTextDTO $DTO): array
    {
        $app = $this->serviceRpc->officialAccountApplication($platformId);

        return $this->domain->sendText($platformId, $app, $DTO);
    }

    /**
     * 分组列表
     *
     * @param string       $platformId
     * @param FansGroupDTO $dto
     * @param bool         $isPagination
     *
     * @return array
     */
    public function fansGroupProvider(int $platformId, FansGroupDTO $dto, bool $isPagination = true): array
    {
        return $this->domain->fansGroup($platformId, $dto, $isPagination);
    }
}
