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

use App\OfficialAccount\Interfaces\DTO\Chat\ImageDTO;
use App\OfficialAccount\Interfaces\DTO\Chat\NewsItemDTO;
use App\OfficialAccount\Interfaces\DTO\Chat\TextDTO;
use App\OfficialAccount\Interfaces\DTO\Chat\VideoDTO;
use App\OfficialAccount\Interfaces\DTO\Chat\VoiceDTO;
use EasyWeChat\OfficialAccount\Application;

/**
 * @\Swoft\Bean\Annotation\Mapping\Bean()
 */
interface ChatSendToTencentDomain
{
    /**
     * 回复文本消息
     *
     * @param Application $app
     * @param TextDTO     $DTO
     *
     * @return array
     */
    public function textMessage(Application $app, TextDTO $DTO): array;

    /**
     * 回复图片消息
     *
     * @param Application $app
     * @param ImageDTO    $DTO
     *
     * @return array
     */
    public function imageMessage(Application $app, ImageDTO $DTO): array;

    /**
     * 回复视频信息
     *
     * @param Application $app
     * @param VideoDTO    $DTO
     *
     * @return array
     */
    public function videoMessage(Application $app, VideoDTO $DTO): array;

    /**
     * 回复音频信息
     *
     * @param Application $app
     * @param VoiceDTO    $DTO
     *
     * @return array
     */
    public function voiceMessage(Application $app, VoiceDTO $DTO): array;

    /**
     * 回复图文消息
     *
     * @param Application $app
     * @param NewsItemDTO $DTO
     *
     * @return array
     */
    public function newsItemMessage(Application $app, NewsItemDTO $DTO): array;

    /**
     * 上传图片
     *
     * @param int         $platformId
     * @param Application $app
     * @param array     $uploadedFiles
     *
     * @return array
     */
    public function uploadImage(int $platformId, Application $app, array $uploadedFiles): array;

    /**
     * 上传视频
     *
     * @param int         $platformId
     * @param Application $app
     * @param array       $uploadedFiles
     *
     * @return array
     */
    public function uploadVideo(int $platformId, Application $app, array $uploadedFiles): array;
}
