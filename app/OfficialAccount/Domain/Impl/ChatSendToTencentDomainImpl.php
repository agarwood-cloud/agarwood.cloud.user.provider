<?php declare(strict_types=1);
/**
 * This file is part of Agarwood Cloud.
 *
 * @link     https://www.agarwood-cloud.com
 * @document https://www.agarwood-cloud.com/docs
 * @contact  676786620@qq.com
 * @author   agarwood
 */

namespace App\OfficialAccount\Domain\Impl;

use Agarwood\Core\Exception\BusinessException;
use App\OfficialAccount\Domain\ChatSendToTencentDomain;
use App\OfficialAccount\Interfaces\DTO\Chat\ImageDTO;
use App\OfficialAccount\Interfaces\DTO\Chat\NewsItemDTO;
use App\OfficialAccount\Interfaces\DTO\Chat\TextDTO;
use App\OfficialAccount\Interfaces\DTO\Chat\VideoDTO;
use App\OfficialAccount\Interfaces\DTO\Chat\VoiceDTO;
use Carbon\Carbon;
use EasyWeChat\Kernel\Exceptions\InvalidArgumentException;
use EasyWeChat\Kernel\Exceptions\InvalidConfigException;
use EasyWeChat\Kernel\Exceptions\RuntimeException;
use EasyWeChat\Kernel\Messages\Image;
use EasyWeChat\Kernel\Messages\News;
use EasyWeChat\Kernel\Messages\NewsItem;
use EasyWeChat\Kernel\Messages\Text;
use EasyWeChat\Kernel\Messages\Video;
use EasyWeChat\Kernel\Messages\Voice;
use EasyWeChat\OfficialAccount\Application;
use Swoft\Http\Message\Upload\UploadedFile;

/**
 * @\Swoft\Bean\Annotation\Mapping\Bean()
 */
class ChatSendToTencentDomainImpl implements ChatSendToTencentDomain
{
    /**
     * 回复文本消息
     *
     * @param Application $app
     * @param TextDTO     $DTO
     *
     * @return array
     * @throws \EasyWeChat\Kernel\Exceptions\InvalidArgumentException
     * @throws \EasyWeChat\Kernel\Exceptions\InvalidConfigException
     * @throws \EasyWeChat\Kernel\Exceptions\RuntimeException
     */
    public function textMessage(Application $app, TextDTO $DTO): array
    {
        $message = new Text($DTO->getContent());
        return (array)$app->customer_service
            ->message($message)
            ->to($DTO->getToUserName())
            ->send();
    }

    /**
     * 回复图片消息
     *
     * @param Application $app
     * @param ImageDTO    $DTO
     *
     * @return array
     * @throws \EasyWeChat\Kernel\Exceptions\InvalidArgumentException
     * @throws \EasyWeChat\Kernel\Exceptions\InvalidConfigException
     * @throws \EasyWeChat\Kernel\Exceptions\RuntimeException
     */
    public function imageMessage(Application $app, ImageDTO $DTO): array
    {
        $message = new Image($DTO->getMediaId());
        return (array)$app->customer_service
            ->message($message)
            ->to($DTO->getToUserName())
            ->send();
    }

    /**
     * 回复视频信息
     *
     * @param Application $app
     * @param VideoDTO    $DTO
     *
     * @return array
     * @throws \EasyWeChat\Kernel\Exceptions\InvalidArgumentException
     * @throws \EasyWeChat\Kernel\Exceptions\InvalidConfigException
     * @throws \EasyWeChat\Kernel\Exceptions\RuntimeException
     */
    public function videoMessage(Application $app, VideoDTO $DTO): array
    {
        $message = new Video($DTO->getMediaId(), [
            'title'       => $DTO->getTitle(),
            'description' => $DTO->getDescription(),
        ]);
        return (array)$app->customer_service
            ->message($message)
            ->to($DTO->getToUserName())
            ->send();
    }

    /**
     * 回复音频信息
     *
     * @param Application $app
     * @param VoiceDTO    $DTO
     *
     * @return array
     * @throws InvalidArgumentException
     * @throws InvalidConfigException
     * @throws RuntimeException
     */
    public function voiceMessage(Application $app, VoiceDTO $DTO): array
    {
        $message = new Voice($DTO->getMediaId());
        return (array)$app->customer_service
            ->message($message)
            ->to($DTO->getToUserName())
            ->send();
    }

    /**
     * 回复图文消息
     *
     * @param Application $app
     * @param NewsItemDTO $DTO
     *
     * @return array
     * @throws \EasyWeChat\Kernel\Exceptions\InvalidArgumentException
     * @throws \EasyWeChat\Kernel\Exceptions\InvalidConfigException
     * @throws \EasyWeChat\Kernel\Exceptions\RuntimeException
     */
    public function newsItemMessage(Application $app, NewsItemDTO $DTO): array
    {
        $items   = [
            new NewsItem([
                'title'       => $DTO->getTitle(),
                'description' => $DTO->getDescription(),
                'url'         => $DTO->getNewItemUrl(),
                'image'       => $DTO->getImageUrl(),
            ]),
        ];
        $message = new News($items);

        return (array)$app->customer_service
            ->message($message)
            ->to($DTO->getToUserName())
            ->send();
    }

    /**
     * 上传图片
     *
     * @param int         $platformId
     * @param Application $app
     * @param array       $uploadedFiles
     *
     * @return array
     * @throws \EasyWeChat\Kernel\Exceptions\InvalidArgumentException
     * @throws \EasyWeChat\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function uploadImage(int $platformId, Application $app, array $uploadedFiles): array
    {
        $result = [];
        foreach ($uploadedFiles as $file) {
            /** @var $file UploadedFile */

            // 检查文件格式、大小是否有问题
            if ($file->getSize() > 1024 * 1000 * 10 ||
                !in_array($file->getClientMediaType(), ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'], false)
            ) {
                throw new BusinessException('图片格式仅支持jpeg，jpg，png，gif 且大小不超过2M', 4000005);
            }

            // 文件后缀
            $array     = explode('/', $file->getClientMediaType());
            $mediaType = end($array);

            // 路径的前缘
            $basePath = env('MEDIA_SERVER_PATH', '/var/www/media/');

            // 保存的路径
            $filePath = 'upload/media/image/' . date('Y-m-d') . '/';

            // 文件名
            $fileName = sha1(time() . uniqid('', true)) . '.' . $mediaType;

            // 文件路径
            $imageUrl = $basePath . $filePath . $fileName;

            // 移动文件
            $file->moveTo($imageUrl);

            //上传到微信服务器
            $mediaInfo = (array)$app->media->uploadImage($imageUrl);
            // 转换驼峰
            $mediaInfoTemp = [
                'type'      => $mediaInfo['type'],
                'mediaId'   => $mediaInfo['media_id'],
                'createdAt' => Carbon::createFromTimestamp($mediaInfo['created_at'], 'PRC')->toDateTimeString(),
                'item'      => $mediaInfo['item'],
            ];
            $result[]      = [
                'imageUrl'  => str_replace(
                    env('MEDIA_SERVER_PATH'),
                    rtrim(env('MEDIA_SERVER_DOMAIN', 'https://www.cdn.xxx.com/'), '/') . '/',
                    $imageUrl
                ),
                'mediaInfo' => $mediaInfoTemp,
            ];
        }
        return $result;
    }

    /**
     * 上传图片
     *
     * @param int         $platformId
     * @param Application $app
     * @param array       $uploadedFiles
     *
     * @return array
     * @throws \EasyWeChat\Kernel\Exceptions\InvalidArgumentException
     * @throws \EasyWeChat\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function uploadVideo(int $platformId, Application $app, array $uploadedFiles): array
    {
        $result = [];
        foreach ($uploadedFiles as $file) {
            /** @var $file UploadedFile */

            // 检查文件格式、大小是否有问题
            if ($file->getSize() > 1024 * 1000 * 10 || $file->getClientMediaType() !== 'video/mp4') {
                throw new BusinessException('The video format only supports mp4 and the size does not exceed 2M!', 4000005);
            }

            // 文件后缀
            $array     = explode('/', $file->getClientMediaType());
            $mediaType = end($array);

            // 路径的前缘
            $basePath = env('MEDIA_SERVER_PATH', '/var/www/media/');

            // 保存的路径
            $filePath = 'upload/media/video/' . date('Y-m-d') . '/';

            // 文件名
            $fileName = sha1(time() . uniqid('', true)) . '.' . $mediaType;

            // 文件路径
            $videoUrl = $basePath . $filePath . $fileName;

            // 移动文件
            $file->moveTo($videoUrl);

            //上传到微信服务器
            $mediaInfo = (array)$app->media->uploadVideo($videoUrl);
            // 转换驼峰
            $result[] = [
                'videoUrl'  => str_replace(env('MEDIA_SERVER_PATH'), '', $videoUrl),
                'mediaInfo' => [
                    'createdAt' => $mediaInfo['created_at'],
                    'item'      => $mediaInfo['item'],
                    'mediaId'   => $mediaInfo['media_id'],
                    'type'      => $mediaInfo['type'],
                ]
            ];
        }
        return $result;
    }
}
