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
     * @param string   $officialAccountId
     * @param IndexDTO $DTO
     * @param bool     $isPagination
     *
     * @return array
     */
    public function indexProvider(int $officialAccountId, IndexDTO $DTO, bool $isPagination = true): array
    {
        return $this->domain->index($officialAccountId, $DTO->toArrayLine(), $isPagination);
    }

    /**
     * @param string      $officialAccountId
     * @param SendTextDTO $DTO
     *
     * @return array
     */
    public function sendTextProvider(int $officialAccountId, SendTextDTO $DTO): array
    {
        $app = $this->serviceRpc->officialAccountApplication($officialAccountId);

        return $this->domain->sendText($officialAccountId, $app, $DTO);
    }

    /**
     * 分组列表
     *
     * @param string       $officialAccountId
     * @param FansGroupDTO $dto
     * @param bool         $isPagination
     *
     * @return array
     */
    public function fansGroupProvider(int $officialAccountId, FansGroupDTO $dto, bool $isPagination = true): array
    {
        return $this->domain->fansGroup($officialAccountId, $dto, $isPagination);
    }
}
