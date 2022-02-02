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
     * @return bool
     * @throws InvalidConfigException
     * @throws RuntimeException
     * @throws InvalidArgumentException
     */
    public function textMessage(Application $app, TextDTO $DTO): bool
    {
        $message  = new Text($DTO->getContent());
        $response = (array)$app->customer_service
            ->message($message)
            ->to($DTO->getToUserName())
            ->send();

        if ($response['errcode'] === 0) {
            // 这里是发送成功的逻辑
            return true;
        }

        // 返回发送错误的信息
        throw new BusinessException($response['errmsg'], $response['errcode']);
    }

    /**
     * 回复图片消息
     *
     * @param Application $app
     * @param ImageDTO    $DTO
     *
     * @return bool
     * @throws InvalidArgumentException
     * @throws InvalidConfigException
     * @throws RuntimeException
     */
    public function imageMessage(Application $app, ImageDTO $DTO): bool
    {
        $message  = new Image($DTO->getMediaId());
        $response = (array)$app->customer_service
            ->message($message)
            ->to($DTO->getToUserName())
            ->send();

        if ($response['errcode'] === 0) {
            // 这里是发送成功的逻辑
            return true;
        }

        // 返回发送错误的信息
        throw new BusinessException($response['errmsg'], $response['errcode']);
    }

    /**
     * 回复视频信息
     *
     * @param Application $app
     * @param VideoDTO    $DTO
     *
     * @return bool
     * @throws InvalidArgumentException
     * @throws InvalidConfigException
     * @throws RuntimeException
     */
    public function videoMessage(Application $app, VideoDTO $DTO): bool
    {
        $message  = new Video($DTO->getMediaId(), [
            'title'       => $DTO->getTitle(),
            'description' => $DTO->getDescription(),
        ]);
        $response = (array)$app->customer_service
            ->message($message)
            ->to($DTO->getToUserName())
            ->send();

        if ($response['errcode'] === 0) {
            // 这里是发送成功的逻辑
            return true;
        }

        // 返回发送错误的信息
        throw new BusinessException($response['errmsg'], $response['errcode']);
    }

    /**
     * 回复音频信息
     *
     * @param Application $app
     * @param VoiceDTO    $DTO
     *
     * @return bool
     * @throws InvalidArgumentException
     * @throws InvalidConfigException
     * @throws RuntimeException
     */
    public function voiceMessage(Application $app, VoiceDTO $DTO): bool
    {
        $message  = new Voice($DTO->getMediaId());
        $response = (array)$app->customer_service
            ->message($message)
            ->to($DTO->getToUserName())
            ->send();

        if ($response['errcode'] === 0) {
            // 这里是发送成功的逻辑
            return true;
        }

        // 返回发送错误的信息
        throw new BusinessException($response['errmsg'], $response['errcode']);
    }

    /**
     * 回复图文消息
     *
     * @param Application $app
     * @param NewsItemDTO $DTO
     *
     * @return bool
     * @throws InvalidArgumentException
     * @throws InvalidConfigException
     * @throws RuntimeException
     */
    public function newsItemMessage(Application $app, NewsItemDTO $DTO): bool
    {
        $items    = [
            new NewsItem([
                'title'       => $DTO->getTitle(),
                'description' => $DTO->getDescription(),
                'url'         => $DTO->getNewItemUrl(),
                'image'       => $DTO->getImageUrl(),
            ]),
        ];
        $message  = new News($items);
        $response = (array)$app->customer_service
            ->message($message)
            ->to($DTO->getToUserName())
            ->send();

        if ($response['errcode'] === 0) {
            // 这里是发送成功的逻辑
            return true;
        }

        // 返回发送错误的信息
        throw new BusinessException($response['errmsg'], $response['errcode']);
    }

    /**
     * 上传图片
     *
     * @param int         $officialAccountId
     * @param Application $app
     * @param array       $uploadedFiles
     *
     * @return array
     * @throws \EasyWeChat\Kernel\Exceptions\InvalidArgumentException
     * @throws \EasyWeChat\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function uploadImage(int $officialAccountId, Application $app, array $uploadedFiles): array
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
            $basePath = env('MEDIA_SERVER_PATH', '/data/www/www.cdn.xxx.com/');

            // 保存的路径
            $filePath = 'upload/media/image/' . date('Y-m-d') . '/';

            // 文件名
            $fileName = sha1(time() . uniqid('', true)) . '.' . $mediaType;

            // 文件路径
            $imageUrl = $basePath . $filePath . $fileName;

            // 移动文件
            $file->moveTo($imageUrl);

            //上传到微信服务器
            $mediaInfo = $app->media->uploadImage($imageUrl);
            $result[]  = [
                'imageUrl'  => str_replace(
                    env('MEDIA_SERVER_PATH'),
                    rtrim(env('MEDIA_SERVER_DOMAIN', 'https://www.cdn.xxx.com/'), '/') . '/',
                    $imageUrl
                ),
                'mediaInfo' => $mediaInfo,
            ];
        }
        return $result;
    }

    /**
     * 上传图片
     *
     * @param int         $officialAccountId
     * @param Application $app
     * @param array       $uploadedFiles
     *
     * @return array
     * @throws \EasyWeChat\Kernel\Exceptions\InvalidArgumentException
     * @throws \EasyWeChat\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function uploadVideo(int $officialAccountId, Application $app, array $uploadedFiles): array
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
            $basePath = env('MEDIA_SERVER_PATH', '/var/www/www.cdn.xxx.com/');

            // 保存的路径
            $filePath = 'upload/media/video/' . date('Y-m-d') . '/';

            // 文件名
            $fileName = sha1(time() . uniqid('', true)) . '.' . $mediaType;

            // 文件路径
            $imageUrl = $basePath . $filePath . $fileName;

            // 移动文件
            $file->moveTo($basePath . $filePath);

            //上传到微信服务器
            $mediaInfo = $app->media->uploadVideo($imageUrl);
            $result[]  = [
                'img_url'    => str_replace(env('MEDIA_SERVER_PATH'), '', $imageUrl),
                'media_info' => $mediaInfo
            ];
        }
        return $result;
    }
}
