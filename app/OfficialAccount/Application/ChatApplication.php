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

use App\OfficialAccount\Interfaces\DTO\Chat\ImageDTO;
use App\OfficialAccount\Interfaces\DTO\Chat\NewsItemDTO;
use App\OfficialAccount\Interfaces\DTO\Chat\TextDTO;
use App\OfficialAccount\Interfaces\DTO\Chat\VideoDTO;
use App\OfficialAccount\Interfaces\DTO\Chat\VoiceDTO;
use Swoft\Http\Message\Request;

/**
 * @\Swoft\Bean\Annotation\Mapping\Bean()
 */
interface ChatApplication
{
    /**
     * 文本消息
     *
     * @param int     $officialAccountId
     * @param TextDTO $DTO
     *
     * @return bool
     */
    public function textMessageProvider(int $officialAccountId, TextDTO $DTO): bool;

    /**
     * 图片消息
     *
     * @param int      $officialAccountId
     * @param ImageDTO $DTO
     *
     * @return bool
     */
    public function ImageMessageProvider(int $officialAccountId, ImageDTO $DTO): bool;

    /**
     * 视频消息
     *
     * @param int $officialAccountId
     * @param VideoDTO    $DTO
     *
     * @return bool
     */
    public function videoMessageProvider(int $officialAccountId, VideoDTO $DTO): bool;

    /**
     * 音频信息
     *
     * @param int      $officialAccountId
     * @param VoiceDTO $DTO
     *
     * @return bool
     */
    public function voiceMessageProvider(int $officialAccountId, VoiceDTO $DTO): bool;

    /**
     * 图文信息
     *
     * @param int         $officialAccountId
     * @param NewsItemDTO $DTO
     *
     * @return bool
     */
    public function newsItemMessageProvider(int $officialAccountId, NewsItemDTO $DTO): bool;

    /**
     * 上传图片
     *
     * @param int     $officialAccountId
     * @param Request $request
     *
     * @return array
     */
    public function uploadImageProvider(int $officialAccountId, Request $request): array;

    /**
     * 上传视频
     *
     * @param int $officialAccountId
     * @param array  $getUploadedFiles
     *
     * @return array
     */
    public function uploadVideoProvider(int $officialAccountId, array $getUploadedFiles): array;
}