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

use App\OfficialAccount\Interfaces\DTO\Chat\ChatDTO;
use App\OfficialAccount\Interfaces\DTO\Chat\ChatRecordDTO;
use App\OfficialAccount\Application\ChatApplication;
use App\OfficialAccount\Domain\ChatSendToTencentDomain;
use App\OfficialAccount\Domain\MongoMessageRecordDomain;
use App\OfficialAccount\Interfaces\DTO\Chat\ImageDTO;
use App\OfficialAccount\Interfaces\DTO\Chat\NewsItemDTO;
use App\OfficialAccount\Interfaces\DTO\Chat\TextDTO;
use App\OfficialAccount\Interfaces\DTO\Chat\VideoDTO;
use App\OfficialAccount\Interfaces\DTO\Chat\VoiceDTO;
use App\OfficialAccount\Interfaces\Rpc\Client\MallCenter\OfficialAccountsRpc;
use Carbon\Carbon;

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
     * @param int     $platformId
     * @param TextDTO $DTO
     *
     * @return bool
     */
    public function textMessageProvider(int $platformId, TextDTO $DTO): bool
    {
        // todo 发送消息给用户
    }

    /**
     * 图片消息
     *
     * @param int      $platformId
     * @param ImageDTO $DTO
     *
     * @return bool
     */
    public function ImageMessageProvider(int $platformId, ImageDTO $DTO): bool
    {
        // todo 发送消息给用户
    }

    /**
     * 视频消息
     *
     * @param int      $platformId
     * @param VideoDTO $DTO
     *
     * @return bool
     */
    public function videoMessageProvider(int $platformId, VideoDTO $DTO): bool
    {
        // todo 发送消息给用户
    }

    /**
     * 音频消息
     *
     * @param int      $platformId
     * @param VoiceDTO $DTO
     *
     * @return bool
     */
    public function voiceMessageProvider(int $platformId, VoiceDTO $DTO): bool
    {
        // todo 发送消息给用户
    }

    /**
     * 图文消息
     *
     * @param int         $platformId
     * @param NewsItemDTO $DTO
     *
     * @return bool
     */
    public function newsItemMessageProvider(int $platformId, NewsItemDTO $DTO): bool
    {
        // todo 发送消息给用户
    }

    /**
     * @param int   $platformId
     * @param array $uploadedFiles
     *
     * @return array
     */
    public function uploadImageProvider(int $platformId, array $uploadedFiles): array
    {
        $app = $this->officialAccountsRpc->officialAccountApplication($platformId);

        return $this->chatSendToTencentDomain->uploadImage($platformId, $app, $uploadedFiles);
    }

    /**
     * 上传视频
     *
     * @param int   $platformId
     * @param array $uploadedFiles
     *
     * @return array
     */
    public function uploadVideoProvider(int $platformId, array $uploadedFiles): array
    {
        $app = $this->officialAccountsRpc->officialAccountApplication($platformId);

        return $this->chatSendToTencentDomain->uploadVideo($platformId, $app, $uploadedFiles);
    }

    /**
     * 最近的聊天列表
     *
     * @param int                                           $platformId
     * @param int                                           $customerId
     * @param \App\OfficialAccount\Interfaces\DTO\Chat\ChatDTO $dto
     *
     * @return array
     */
    public function chatListProvider(int $platformId, int $customerId, ChatDTO $dto): array
    {
        return $this->mongoMessageRecordDomain->getLastMessageChatList(
            $customerId,
            $dto->getStartAt() ?: Carbon::now()->subMonths(3)->toDateTimeString(),
            $dto->getEndAt() ?: Carbon::now()->toDateTimeString(),
            $dto->getPage(),
            $dto->getPerPage()
        );
    }

    /**
     * @param string                                                 $openid
     * @param int                                                    $customerId
     * @param \App\OfficialAccount\Interfaces\DTO\Chat\ChatRecordDTO $dto
     *
     * @return array
     */
    public function chatRecordProvider(string $openid, int $customerId, ChatRecordDTO $dto): array
    {
        return $this->mongoMessageRecordDomain->getMessageRecordByOpenid(
            $openid,
            $dto->getStartAt() ?: Carbon::now()->subMonths(3)->toDateTimeString(),
            $dto->getEndAt() ?: Carbon::now()->toDateTimeString(),
            $dto->getPage(),
            $dto->getPerPage()
        );
    }
}
