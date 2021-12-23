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

use App\OfficialAccount\Interfaces\DTO\Callback\TextDTO as CallBackChatTextDTO;
use App\OfficialAccount\Interfaces\DTO\Chat\ImageDTO as ChatImageDTO;
use App\OfficialAccount\Interfaces\DTO\Callback\ImageDTO as CallBackChatImageDTO;
use App\OfficialAccount\Interfaces\DTO\Chat\NewsItemDTO;
use App\OfficialAccount\Interfaces\DTO\Chat\TextDTO as ChatTextDTO;
use App\OfficialAccount\Interfaces\DTO\Chat\VideoDTO as ChatVideoDTO;
use App\OfficialAccount\Interfaces\DTO\Callback\VideoDTO as CallBackChatVideoDTO;
use App\OfficialAccount\Interfaces\DTO\Chat\VoiceDTO as ChatVoiceDTO;
use App\OfficialAccount\Interfaces\DTO\Callback\VoiceDTO as CallBackChatVoiceDTO;
use MongoDB\InsertManyResult;
use MongoDB\InsertOneResult;
use MongoDB\UpdateResult;

/**
 * @\Swoft\Bean\Annotation\Mapping\Bean()
 */
interface MongoMessageRecordDomain
{
    /**
     * 记录文件消息
     *
     * @param ChatTextDTO | CallBackChatTextDTO $textDTO
     *
     * @return \MongoDB\InsertOneResult
     */
    public function insertTextMessageRecord(ChatTextDTO|CallBackChatTextDTO $textDTO): InsertOneResult;

    /**
     * 记录图片消息
     *
     * @param ChatImageDTO | CallBackChatImageDTO $imageDTO
     *
     * @return \MongoDB\InsertOneResult
     */
    public function insertImageMessageRecord(ChatImageDTO|CallBackChatImageDTO $imageDTO): InsertOneResult;

    /**
     * 记录视频消息
     *
     * @param ChatVideoDTO | CallBackChatVideoDTO $videoDTO
     *
     * @return \MongoDB\InsertOneResult
     */
    public function insertVideoMessageRecord(ChatVideoDTO|CallBackChatVideoDTO $videoDTO): InsertOneResult;

    /**
     * 记录语音消息
     *
     * @param ChatVoiceDTO | CallBackChatVoiceDTO $voiceDTO
     *
     * @return \MongoDB\InsertOneResult
     */
    public function insertVoiceMessageRecord(ChatVoiceDTO|CallBackChatVoiceDTO $voiceDTO): InsertOneResult;

    /**
     * 记录图文消息
     *
     * @param \App\OfficialAccount\Interfaces\DTO\Chat\NewsItemDTO $DTO
     *
     * @return \MongoDB\InsertOneResult
     */
    public function insertNewsItemMessageRecord(NewsItemDTO $DTO): InsertOneResult;

    /**
     * 插入一条聊天记录
     *
     * @param string $openid     微信用户openid
     * @param string $customerId 客服id
     * @param string $sender     发送者
     * @param string $msgType    消息类型
     * @param array  $data       消息内容
     * @param string $createdAt  创建时间
     * @param bool   $isRead     是否已读
     *
     * @return \MongoDB\InsertOneResult
     */
    public function insertOneMessage(string $openid, string $customerId, string $sender, string $msgType, array $data, string $createdAt, bool $isRead = false): InsertOneResult;

    /**
     * 插入多条聊天记录
     *
     * @param array $document 消息内容
     * @param array $options
     *
     * @return \MongoDB\InsertManyResult
     */
    public function insertManyMessage(array $document, array $options = []): InsertManyResult;

    /**
     * 更新一条聊天记录
     *
     * @param string $openid  微信用户openid
     * @param bool   $isRead  是否已读
     * @param array  $options 选项
     *
     * @return \MongoDB\UpdateResult
     */
    public function updateOneMessageToReadByOpenid(string $openid, bool $isRead = true, array $options = []): UpdateResult;

    /**
     * 更新多条聊天记录
     *
     * @param string $openid
     * @param bool   $isRead
     * @param array  $options
     *
     * @return \MongoDB\UpdateResult
     */
    public function updateManyToReadByOpenid(string $openid, bool $isRead = true, array $options = []): UpdateResult;
}