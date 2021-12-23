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

use App\OfficialAccount\Interfaces\DTO\Broadcasting\FansGroupDTO;
use App\OfficialAccount\Interfaces\DTO\Broadcasting\SendTextDTO;
use EasyWeChat\OfficialAccount\Application;

/**
 * @\Swoft\Bean\Annotation\Mapping\Bean()
 */
interface BroadcastingDomainService
{
    /**
     * 群发文本消息
     *
     * @param string      $officialAccountId
     * @param Application $application
     * @param SendTextDTO $textDTO
     *
     * @return array
     */
    public function sendText(int $officialAccountId, Application $application, SendTextDTO $textDTO): array;

    /**
     * 已发送的列表
     *
     * @param int $officialAccountId
     * @param array  $toArrayLine
     * @param bool   $isPagination
     *
     * @return array
     */
    public function index(int $officialAccountId, array $toArrayLine, bool $isPagination): array;

    /**
     * 分组列表
     *
     * @param string       $officialAccountId
     * @param FansGroupDTO $dto
     * @param bool         $isPagination
     *
     * @return array
     */
    public function fansGroup(int $officialAccountId, FansGroupDTO $dto, bool $isPagination): array;
}
