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
     * @param int     $tencentId
     * @param TextDTO $DTO
     *
     * @return bool
     */
    public function textMessageProvider(int $tencentId, TextDTO $DTO): bool;

    /**
     * 图片消息
     *
     * @param int      $tencentId
     * @param ImageDTO $DTO
     *
     * @return bool
     */
    public function ImageMessageProvider(int $tencentId, ImageDTO $DTO): bool;

    /**
     * 视频消息
     *
     * @param int      $tencentId
     * @param VideoDTO $DTO
     *
     * @return bool
     */
    public function videoMessageProvider(int $tencentId, VideoDTO $DTO): bool;

    /**
     * 音频信息
     *
     * @param int      $tencentId
     * @param VoiceDTO $DTO
     *
     * @return bool
     */
    public function voiceMessageProvider(int $tencentId, VoiceDTO $DTO): bool;

    /**
     * 图文信息
     *
     * @param int         $tencentId
     * @param NewsItemDTO $DTO
     *
     * @return bool
     */
    public function newsItemMessageProvider(int $tencentId, NewsItemDTO $DTO): bool;

    /**
     * 上传图片
     *
     * @param int   $tencentId
     * @param array $uploadedFiles
     *
     * @return array
     */
    public function uploadImageProvider(int $tencentId, array $uploadedFiles): array;

    /**
     * 上传视频
     *
     * @param int   $tencentId
     * @param array $uploadedFiles
     *
     * @return array
     */
    public function uploadVideoProvider(int $tencentId, array $uploadedFiles): array;

    /**
     * @param int                                              $tencentId
     * @param int                                              $customerId
     * @param \App\OfficialAccount\Interfaces\DTO\Chat\ChatDTO $dto
     *
     * @return array
     */
    public function chatListProvider(int $tencentId, int $customerId, ChatDTO $dto): array;

    /**
     * @param string                                                 $openid
     * @param int                                                    $customerId
     * @param \App\OfficialAccount\Interfaces\DTO\Chat\ChatRecordDTO $dto
     *
     * @return array
     */
    public function chatRecordProvider(string $openid, int $customerId, ChatRecordDTO $dto): array;
}
