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

use App\OfficialAccount\Interfaces\DTO\Chat\ChatDTO;
use App\OfficialAccount\Interfaces\DTO\Chat\ChatRecordDTO;
use App\OfficialAccount\Interfaces\DTO\Chat\ImageDTO;
use App\OfficialAccount\Interfaces\DTO\Chat\NewsItemDTO;
use App\OfficialAccount\Interfaces\DTO\Chat\TextDTO;
use App\OfficialAccount\Interfaces\DTO\Chat\VideoDTO;
use App\OfficialAccount\Interfaces\DTO\Chat\VoiceDTO;

/**
 * @\Swoft\Bean\Annotation\Mapping\Bean()
 */
interface ChatApplication
{
    /**
     * 文本消息
     *
     * @param int     $platformId
     * @param TextDTO $DTO
     *
     * @return bool
     * @deprecated
     */
    public function textMessageProvider(int $platformId, TextDTO $DTO): bool;

    /**
     * 图片消息
     *
     * @param int      $platformId
     * @param ImageDTO $DTO
     *
     * @return bool
     */
    public function ImageMessageProvider(int $platformId, ImageDTO $DTO): bool;

    /**
     * 视频消息
     *
     * @param int      $platformId
     * @param VideoDTO $DTO
     *
     * @return bool
     * @deprecated
     */
    public function videoMessageProvider(int $platformId, VideoDTO $DTO): bool;

    /**
     * 音频信息
     *
     * @param int      $platformId
     * @param VoiceDTO $DTO
     *
     * @return bool
     * @deprecated
     */
    public function voiceMessageProvider(int $platformId, VoiceDTO $DTO): bool;

    /**
     * 图文信息
     *
     * @param int         $platformId
     * @param NewsItemDTO $DTO
     *
     * @return bool
     * @deprecated
     */
    public function newsItemMessageProvider(int $platformId, NewsItemDTO $DTO): bool;

    /**
     * 上传图片
     *
     * @param int   $platformId
     * @param array $uploadedFiles
     *
     * @return array
     */
    public function uploadImageProvider(int $platformId, array $uploadedFiles): array;

    /**
     * 上传视频
     *
     * @param int   $platformId
     * @param array $uploadedFiles
     *
     * @return array
     */
    public function uploadVideoProvider(int $platformId, array $uploadedFiles): array;

    /**
     * @param int                                              $platformId
     * @param int                                              $customerId
     * @param \App\OfficialAccount\Interfaces\DTO\Chat\ChatDTO $dto
     *
     * @return array
     */
    public function chatListProvider(int $platformId, int $customerId, ChatDTO $dto): array;

    /**
     * @param string                                                 $openid
     * @param int                                                    $customerId
     * @param \App\OfficialAccount\Interfaces\DTO\Chat\ChatRecordDTO $dto
     *
     * @return array
     */
    public function chatRecordProvider(string $openid, int $customerId, ChatRecordDTO $dto): array;
}
