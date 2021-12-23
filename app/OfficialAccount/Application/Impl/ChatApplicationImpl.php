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

use Agarwood\Core\Exception\BusinessException;
use App\OfficialAccount\Application\ChatApplication;
use App\OfficialAccount\Domain\ChatSendToTencentDomain;
use App\OfficialAccount\Domain\MongoMessageRecordDomain;
use App\OfficialAccount\Domain\SendToNodeDomain;
use App\OfficialAccount\Interfaces\DTO\Chat\ImageDTO;
use App\OfficialAccount\Interfaces\DTO\Chat\NewsItemDTO;
use App\OfficialAccount\Interfaces\DTO\Chat\TextDTO;
use App\OfficialAccount\Interfaces\DTO\Chat\VideoDTO;
use App\OfficialAccount\Interfaces\DTO\Chat\VoiceDTO;
use App\OfficialAccount\Interfaces\Rpc\Client\MallCenter\OfficialAccountsRpc;
use Swoft\Http\Message\Request;

/**
 * @\Swoft\Bean\Annotation\Mapping\Bean()
 */
class ChatApplicationImpl implements ChatApplication
{
    /**
     * @\Swoft\Bean\Annotation\Mapping\Inject()
     *
     * @var \App\OfficialAccount\Domain\ChatSendToTencentDomain
     */
    protected ChatSendToTencentDomain $chatSendToTencentDomain;

    /**
     * @\Swoft\Bean\Annotation\Mapping\Inject()
     *
     * @var \App\OfficialAccount\Interfaces\Rpc\Client\MallCenter\OfficialAccountsRpc
     */
    protected OfficialAccountsRpc $officialAccountsRpc;

    /**
     * 转消息转到到node服务(外部)
     *
     * @\Swoft\Bean\Annotation\Mapping\Inject()
     *
     * @var \App\OfficialAccount\Domain\SendToNodeDomain
     */
    protected SendToNodeDomain $sendToNodeDomain;

    /**
     * 记录消息记录
     *
     * @\Swoft\Bean\Annotation\Mapping\Inject()
     *
     * @var \App\OfficialAccount\Domain\MongoMessageRecordDomain
     */
    public MongoMessageRecordDomain $mongoMessageRecordDomain;

    /**
     * 文本消息
     *
     * @param int     $officialAccountId
     * @param TextDTO $DTO
     *
     * @return bool
     */
    public function textMessageProvider(int $officialAccountId, TextDTO $DTO): bool
    {
        $app = $this->officialAccountsRpc->officialAccountApplication($officialAccountId);

        try {
            // 发送消息给用户
            $result = $this->chatSendToTencentDomain->textMessage($app, $DTO);
            if ($result) {
                $this->sendToNodeDomain->textMessage(
                    $DTO->getFromUserId(),
                    $DTO->getToUserName(),
                    $DTO->getToUserName(),
                    $DTO->getContent(),
                    'customer'
                );

                // 保存到 mongodb
                $this->mongoMessageRecordDomain->insertTextMessageRecord($DTO);
            }
        } catch (BusinessException $exception) {
            $this->sendToNodeDomain->errorMessage(
                $DTO->getFromUserId(),
                $DTO->getToUserName(),
                $DTO->getToUserName(),
                $exception->getSubMsg(),
                $exception->getCode(),
                'system'
            );
            return false;
        }
        return true;
    }

    /**
     * 图片消息
     *
     * @param int      $officialAccountId
     * @param ImageDTO $DTO
     *
     * @return bool
     */
    public function ImageMessageProvider(int $officialAccountId, ImageDTO $DTO): bool
    {
        $app = $this->officialAccountsRpc->officialAccountApplication($officialAccountId);

        try {
            // 发送消息给用户
            $result = $this->chatSendToTencentDomain->imageMessage($app, $DTO);

            if ($result) {
                // 重新转发回去给客服, 转发消息给node
                $this->sendToNodeDomain->imageMessage(
                    $DTO->getFromUserId(),
                    $DTO->getToUserName(),
                    $DTO->getToUserName(),
                    $DTO->getMediaId(),
                    $DTO->getUrl() ?? $DTO->getImageUrl(),
                    'customer'
                );

                // 保存到 mongodb
                $this->mongoMessageRecordDomain->insertImageMessageRecord($DTO);
            }
        } catch (BusinessException $exception) {
            $this->sendToNodeDomain->errorMessage(
                $DTO->getFromUserId(),
                $DTO->getToUserName(),
                $DTO->getToUserName(),
                $exception->getSubMsg(),
                $exception->getCode(),
                'system'
            );
            return false;
        }
        return true;
    }

    /**
     * 视频消息
     *
     * @param int      $officialAccountId
     * @param VideoDTO $DTO
     *
     * @return bool
     */
    public function videoMessageProvider(int $officialAccountId, VideoDTO $DTO): bool
    {
        $app = $this->officialAccountsRpc->officialAccountApplication($officialAccountId);

        try {
            // 发送消息给用户
            $result = $this->chatSendToTencentDomain->videoMessage($app, $DTO);

            if ($result) {

                // 转发回去给 node
                $this->sendToNodeDomain->videoMessage(
                    $DTO->getFromUserId(),
                    $DTO->getToUserName(),
                    $DTO->getToUserName(),
                    $DTO->getTitle(),
                    $DTO->getMediaId(),
                    $DTO->getDescription(),
                    $DTO->getThumbMediaId(),
                    $DTO->getUrl(),
                    'customer'
                );

                // 保存到 mongodb
                $this->mongoMessageRecordDomain->insertVideoMessageRecord($DTO);
            }
        } catch (BusinessException $exception) {
            $this->sendToNodeDomain->errorMessage(
                $DTO->getFromUserId(),
                $DTO->getToUserName(),
                $DTO->getToUserName(),
                $exception->getSubMsg(),
                $exception->getCode(),
                'system'
            );
            return false;
        }
        return true;
    }

    /**
     * 音频消息
     *
     * @param int      $officialAccountId
     * @param VoiceDTO $DTO
     *
     * @return bool
     */
    public function voiceMessageProvider(int $officialAccountId, VoiceDTO $DTO): bool
    {
        $app = $this->officialAccountsRpc->officialAccountApplication($officialAccountId);

        try {
            // 发送消息给用户
            $result = $this->chatSendToTencentDomain->voiceMessage($app, $DTO);

            if ($result) {
                // 转发回去给 node
                $this->sendToNodeDomain->voiceMessage(
                    $DTO->getFromUserId(),
                    $DTO->getToUserName(),
                    $DTO->getToUserName(),
                    $DTO->getMediaId(),
                    $DTO->getUrl(),
                    'customer'
                );

                // 保存到 mongodb
                $this->mongoMessageRecordDomain->insertVoiceMessageRecord($DTO);
            }
        } catch (BusinessException $exception) {
            $this->sendToNodeDomain->errorMessage(
                $DTO->getFromUserId(),
                $DTO->getToUserName(),
                $DTO->getToUserName(),
                $exception->getSubMsg(),
                $exception->getCode(),
                'system'
            );
            return false;
        }
        return true;
    }

    /**
     * 图文消息
     *
     * @param int         $officialAccountId
     * @param NewsItemDTO $DTO
     *
     * @return bool
     */
    public function newsItemMessageProvider(int $officialAccountId, NewsItemDTO $DTO): bool
    {
        $app = $this->officialAccountsRpc->officialAccountApplication($officialAccountId);

        try {
            // 发送消息给用户
            $result = $this->chatSendToTencentDomain->newsItemMessage($app, $DTO);

            if ($result) {
                // 重新转发回去给客服, 转发消息给node
                $this->sendToNodeDomain->newsItemMessage(
                    $DTO->getFromUserId(),
                    $DTO->getToUserName(),
                    $DTO->getToUserName(),
                    $DTO->getTitle(),
                    $DTO->getDescription(),
                    $DTO->getUrl(),
                    $DTO->getImage(),
                    'customer'
                );

                // 保存到 mongodb
                $this->mongoMessageRecordDomain->insertNewsItemMessageRecord($DTO);
            }
            return true;
        } catch (BusinessException $exception) {
            $this->sendToNodeDomain->errorMessage(
                $DTO->getFromUserId(),
                $DTO->getToUserName(),
                $DTO->getToUserName(),
                $exception->getSubMsg(),
                $exception->getCode(),
                'system'
            );
            return false;
        }
    }

    /**
     * @param int     $officialAccountId
     * @param Request $request
     *
     * @return array
     */
    public function uploadImageProvider(int $officialAccountId, Request $request): array
    {
        $app = $this->officialAccountsRpc->officialAccountApplication($officialAccountId);

        return $this->chatSendToTencentDomain->uploadImage($officialAccountId, $app, $request);
    }

    /**
     * 上传视频
     *
     * @param int   $officialAccountId
     * @param array $getUploadedFiles
     *
     * @return array
     */
    public function uploadVideoProvider(int $officialAccountId, array $getUploadedFiles): array
    {
        $app = $this->officialAccountsRpc->officialAccountApplication($officialAccountId);

        return $this->chatSendToTencentDomain->uploadVideo($officialAccountId, $app, $getUploadedFiles);
    }
}
