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

use App\OfficialAccount\Interfaces\DTO\Broadcasting\FansGroupDTO;
use App\OfficialAccount\Interfaces\DTO\Broadcasting\IndexDTO;
use App\OfficialAccount\Interfaces\DTO\Broadcasting\SendTextDTO;

/**
 * 应用层
 *
 * @\Swoft\Bean\Annotation\Mapping\Bean()
 */
interface BroadcastingApplication
{
    /**
     * 应用层
     *      客服列表服务接口
     *
     *
     * @param string   $tencentId
     * @param IndexDTO $DTO
     * @param bool     $isPagination
     *
     * @return array
     */
    public function indexProvider(int $tencentId, IndexDTO $DTO, bool $isPagination = true): array;

    /**
     * 群发文本消息
     *
     * @param string      $tencentId
     * @param SendTextDTO $DTO
     *
     * @return array
     */
    public function sendTextProvider(int $tencentId, SendTextDTO $DTO): array;

    /**
     * 分组列表
     *
     * @param string       $tencentId
     * @param FansGroupDTO $dto
     * @param bool         $isPagination
     *
     * @return array
     */
    public function fansGroupProvider(int $tencentId, FansGroupDTO $dto, bool $isPagination = true): array;
}
