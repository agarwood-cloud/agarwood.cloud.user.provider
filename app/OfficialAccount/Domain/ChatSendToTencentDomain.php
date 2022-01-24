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
use MongoDB\InsertOneResult;
use Swoft\Http\Message\Request;

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
     * @return bool
     */
    public function textMessage(Application $app, TextDTO $DTO): bool;

    /**
     * 回复图片消息
     *
     * @param Application $app
     * @param ImageDTO    $DTO
     *
     * @return bool
     */
    public function imageMessage(Application $app, ImageDTO $DTO): bool;

    /**
     * 回复视频信息
     *
     * @param Application $app
     * @param VideoDTO    $DTO
     *
     * @return bool
     */
    public function videoMessage(Application $app, VideoDTO $DTO): bool;

    /**
     * 回复音频信息
     *
     * @param Application $app
     * @param VoiceDTO    $DTO
     *
     * @return bool
     */
    public function voiceMessage(Application $app, VoiceDTO $DTO): bool;

    /**
     * 回复图文消息
     *
     * @param Application $app
     * @param NewsItemDTO $DTO
     *
     * @return bool
     */
    public function newsItemMessage(Application $app, NewsItemDTO $DTO): bool;

    /**
     * 上传图片
     *
     * @param int         $officialAccountId
     * @param Application $app
     * @param array     $uploadedFiles
     *
     * @return array
     */
    public function uploadImage(int $officialAccountId, Application $app, array $uploadedFiles): array;

    /**
     * 上传视频
     *
     * @param int         $officialAccountId
     * @param Application $app
     * @param array       $uploadedFiles
     *
     * @return array
     */
    public function uploadVideo(int $officialAccountId, Application $app, array $uploadedFiles): array;
}
