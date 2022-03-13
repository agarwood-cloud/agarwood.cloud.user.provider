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

use Agarwood\Core\Util\ArrayHelper;
use Agarwood\Core\Util\StringUtil;
use App\OfficialAccount\Domain\Aggregate\Enum\WebSocketMessage;
use App\OfficialAccount\Domain\Aggregate\Repository\ChatMessageRecordMongoCommandRepository;
use App\OfficialAccount\Domain\Aggregate\Repository\UserQueryRepository;
use App\OfficialAccount\Domain\MongoMessageRecordDomain;
use App\OfficialAccount\Interfaces\DTO\Callback\ImageDTO as CallBackChatImageDTO;
use App\OfficialAccount\Interfaces\DTO\Callback\LinkDTO;
use App\OfficialAccount\Interfaces\DTO\Callback\LocationDTO;
use App\OfficialAccount\Interfaces\DTO\Callback\TextDTO as CallbackTextDTO;
use App\OfficialAccount\Interfaces\DTO\Callback\VideoDTO as CallbackVideoDTO;
use App\OfficialAccount\Interfaces\DTO\Callback\VoiceDTO as CallBackChatVoiceDTO;
use App\OfficialAccount\Interfaces\DTO\Chat\ImageDTO as ChatImageDTO;
use App\OfficialAccount\Interfaces\DTO\Chat\TextDTO as ChatTextDTO;
use App\OfficialAccount\Interfaces\DTO\Chat\VideoDTO as ChatVideoDTO;
use App\OfficialAccount\Interfaces\DTO\Chat\VoiceDTO as ChatVoiceDTO;
use Exception;
use JsonException;
use MongoDB\InsertManyResult;
use MongoDB\InsertOneResult;
use MongoDB\UpdateResult;
use Swoft\Log\Helper\CLog;
use Throwable;

/**
 * @\Swoft\Bean\Annotation\Mapping\Bean()
 */
class MongoMessageRecordDomainImpl implements MongoMessageRecordDomain
{
    /**
     * @\Swoft\Bean\Annotation\Mapping\Inject()
     *
     * @var \App\OfficialAccount\Domain\Aggregate\Repository\ChatMessageRecordMongoCommandRepository
     */
    public ChatMessageRecordMongoCommandRepository $chatMessageRecordMongoCommandRepository;

    /**
     * @\Swoft\Bean\Annotation\Mapping\Inject()
     *
     * @var \App\OfficialAccount\Domain\Aggregate\Repository\UserQueryRepository
     */
    public UserQueryRepository $userQueryRepository;

    /**
     * 记录文件消息
     *
     * @param ChatTextDTO | CallbackTextDTO $textDTO
     *
     * @return \MongoDB\InsertOneResult
     */
    public function insertTextMessageRecord(ChatTextDTO|CallbackTextDTO $textDTO): InsertOneResult
    {
        // 判断消息的类型
        $openid     = '';
        $customerId = '';
        $sender     = '';

        // 客服发送给用户的消息
        if (method_exists($textDTO, 'getSender') && $textDTO->getSender() === 'user') {
            $openid     = $textDTO->getFromUserName();
            $customerId = $textDTO->getToUserName();
            $sender     = $textDTO->getSender();
        }

        // 客服发送给用户的消息，转发回来给客服的消息
        if (method_exists($textDTO, 'getSender') && $textDTO->getSender() === 'customer') {
            $openid     = $textDTO->getToUserName();
            $customerId = $textDTO->getFromUserName();
            $sender     = $textDTO->getSender();
        }

        // 腾讯发过来的消息
        if (method_exists($textDTO, 'getMsgType') && $textDTO->getMsgType() === 'text.message') {
            $openid     = $textDTO->getFromUserName();
            $customerId = $textDTO->getToUserName();
            $sender     = 'user';
        }

        // 消息内容
        $data = [
            'content' => $textDTO->getContent(),
        ];

        return $this->chatMessageRecordMongoCommandRepository->insertOneMessage(
            $openid,
            (int)$customerId,
            $sender,
            WebSocketMessage::TEXT_MESSAGE,
            $data,
            false
        );
    }

    /**
     * 记录图片消息
     *
     * @param \App\OfficialAccount\Interfaces\DTO\Callback\ImageDTO|\App\OfficialAccount\Interfaces\DTO\Chat\ImageDTO $imageDTO
     * @param string                                                                                                  $imageUrl
     *
     * @return \MongoDB\InsertOneResult
     */
    public function insertImageMessageRecord(CallBackChatImageDTO|ChatImageDTO $imageDTO, string $imageUrl): InsertOneResult
    {
        // 判断消息的类型
        $openid     = '';
        $customerId = '';
        $sender     = '';

        // 客服发送给用户的消息
        if (method_exists($imageDTO, 'getSender') && $imageDTO->getSender() === 'user') {
            $openid     = $imageDTO->getFromUserName();
            $sender     = $imageDTO->getSender();
            $customerId = $imageDTO->getToUserName();
        }

        // 客服发送给用户的消息，转发回来给客服的消息
        if (method_exists($imageDTO, 'getSender') && $imageDTO->getSender() === 'customer') {
            $openid     = $imageDTO->getToUserName();
            $customerId = $imageDTO->getFromUserName();
            $sender     = $imageDTO->getSender();
        }

        // 腾讯发过来的消息
        if (method_exists($imageDTO, 'getMsgType') && $imageDTO->getMsgType() === 'image.message') {
            $openid     = $imageDTO->getFromUserName();
            $customerId = $imageDTO->getToUserName();
            $sender     = 'user';
        }

        // 消息内容
        $data = [
            'content'   => '[图片消息]',
            'image_url' => $imageUrl
        ];

        try {
            $this->chatMessageRecordMongoCommandRepository->insertOneMessage(
                $openid,
                (int)$customerId,
                $sender,
                WebSocketMessage::IMAGE_MESSAGE,
                $data,
                false
            );
        } catch (Throwable $e) {
            CLog::error('insert image error:', $e->getMessage());
        }

        // 记录消息
        return $this->chatMessageRecordMongoCommandRepository->insertOneMessage(
            $openid,
            (int)$customerId,
            $sender,
            WebSocketMessage::IMAGE_MESSAGE,
            $data,
            false
        );
    }

    /**
     * 记录视频消息
     *
     * @param \App\OfficialAccount\Interfaces\DTO\Callback\VideoDTO|\App\OfficialAccount\Interfaces\DTO\Chat\VideoDTO $videoDTO
     * @param string                                                                                                  $videoUrl
     *
     * @return \MongoDB\InsertOneResult
     */
    public function insertVideoMessageRecord(CallbackVideoDTO|ChatVideoDTO $videoDTO, string $videoUrl): InsertOneResult
    {
        // 判断消息的类型
        $openid     = '';
        $customerId = '';
        $sender     = '';

        // 客服发送给用户的消息
        if (method_exists($videoDTO, 'getSender') && $videoDTO->getSender() === 'user') {
            $openid     = $videoDTO->getFromUserName();
            $sender     = $videoDTO->getSender();
            $customerId = $videoDTO->getToUserName();
        }

        // 客服发送给用户的消息，转发回来给客服的消息
        if (method_exists($videoDTO, 'getSender') && $videoDTO->getSender() === 'customer') {
            $openid     = $videoDTO->getToUserName();
            $customerId = $videoDTO->getFromUserName();
            $sender     = $videoDTO->getSender();
        }

        // 腾讯发过来的消息
        if (method_exists($videoDTO, 'getMsgType') && $videoDTO->getMsgType() === 'video.message') {
            $openid     = $videoDTO->getFromUserName();
            $customerId = $videoDTO->getToUserName();
            $sender     = 'user';
        }

        // 消息内容
        $data = [
            'content'     => '[视频消息]',
            'video_url'   => $videoUrl,
            'title'       => $videoDTO->getTitle(),
            'description' => $videoDTO->getDescription(),
        ];

        // 记录消息
        return $this->chatMessageRecordMongoCommandRepository->insertOneMessage(
            $openid,
            (int)$customerId,
            $sender,
            WebSocketMessage::VIDEO_MESSAGE,
            $data,
            false
        );
    }

    /**
     * 记录语音消息
     *
     * @param \App\OfficialAccount\Interfaces\DTO\Callback\VoiceDTO|\App\OfficialAccount\Interfaces\DTO\Chat\VoiceDTO $voiceDTO
     * @param string                                                                                                  $voiceUrl
     *
     * @return \MongoDB\InsertOneResult
     */
    public function insertVoiceMessageRecord(CallBackChatVoiceDTO|ChatVoiceDTO $voiceDTO, string $voiceUrl): InsertOneResult
    {
        // 判断消息的类型
        $openid     = '';
        $customerId = '';
        $sender     = '';

        // 客服发送给用户的消息
        if (method_exists($voiceDTO, 'getSender') && $voiceDTO->getSender() === 'user') {
            $openid     = $voiceDTO->getFromUserName();
            $sender     = $voiceDTO->getSender();
            $customerId = $voiceDTO->getToUserName();
        }

        // 客服发送给用户的消息，转发回来给客服的消息
        if (method_exists($voiceDTO, 'getSender') && $voiceDTO->getSender() === 'customer') {
            $openid     = $voiceDTO->getToUserName();
            $customerId = $voiceDTO->getFromUserName();
            $sender     = $voiceDTO->getSender();
        }

        // 腾讯发过来的消息
        if (method_exists($voiceDTO, 'getMsgType') && $voiceDTO->getMsgType() === 'video.message') {
            $openid     = $voiceDTO->getFromUserName();
            $customerId = $voiceDTO->getToUserName();
            $sender     = 'user';
        }

        // 消息内容
        $data = [
            'content'   => '[语音消息]',
            'voice_url' => $voiceUrl
        ];

        // 记录消息
        return $this->chatMessageRecordMongoCommandRepository->insertOneMessage(
            $openid,
            (int)$customerId,
            $sender,
            WebSocketMessage::VOICE_MESSAGE,
            $data,
            false
        );
    }

    /**
     * 插入一条聊天记录
     *
     * @param string $openid     微信用户openid
     * @param int    $customerId 客服id
     * @param string $sender     发送者
     * @param string $msgType    消息类型
     * @param array  $data       消息内容
     * @param bool   $isRead     是否已读
     *
     * @return \MongoDB\InsertOneResult
     */
    public function insertOneMessage(string $openid, int $customerId, string $sender, string $msgType, array $data, bool $isRead = false): InsertOneResult
    {
        return $this->chatMessageRecordMongoCommandRepository->insertOneMessage($openid, $customerId, $sender, $msgType, $data, $isRead);
    }

    /**
     * 插入多条聊天记录
     *
     * @param array $document 消息内容
     * @param array $options
     *
     * @return \MongoDB\InsertManyResult
     */
    public function insertManyMessage(array $document, array $options = []): InsertManyResult
    {
        return $this->chatMessageRecordMongoCommandRepository->insertManyMessage($document, $options);
    }

//    /**
//     * 记录图文消息
//     *
//     * @param \App\OfficialAccount\Interfaces\DTO\Chat\NewsItemDTO $DTO
//     *
//     * @return \MongoDB\InsertOneResult
//     */
//    public function insertNewsItemMessageRecord(NewsItemDTO $DTO): InsertOneResult
//    {
//        // return $this->chatMessageRecordMongoCommandRepository->insertNewsItemMessageRecord($DTO);
//    }

    /**
     * @param \App\OfficialAccount\Interfaces\DTO\Callback\LocationDTO $DTO
     *
     * @return \MongoDB\InsertOneResult
     */
    public function insertLocationMessageRecord(LocationDTO $DTO): InsertOneResult
    {
        // 判断消息的类型
        $openid     = '';
        $customerId = '';
        $sender     = '';

        // 客服发送给用户的消息
        if (method_exists($DTO, 'getSender') && $DTO->getSender() === 'user') {
            $openid     = $DTO->getFromUserName();
            $sender     = $DTO->getSender();
            $customerId = $DTO->getToUserName();
        }

        // 客服发送给用户的消息，转发回来给客服的消息
        if (method_exists($DTO, 'getSender') && $DTO->getSender() === 'customer') {
            $openid     = $DTO->getToUserName();
            $customerId = $DTO->getFromUserName();
            $sender     = $DTO->getSender();
        }

        // 腾讯发过来的消息
        if (method_exists($DTO, 'getMsgType') && $DTO->getMsgType() === 'link.message') {
            $openid     = $DTO->getFromUserName();
            $customerId = $DTO->getToUserName();
            $sender     = 'user';
        }

        // 消息内容
        $data = [
            'content'    => '[坐标消息]',
            'location_x' => $DTO->getLocationX(),
            'location_y' => $DTO->getLocationY(),
            'scale'      => $DTO->getScale(),
            'label'      => $DTO->getLabel(),
        ];

        // 记录消息
        return $this->chatMessageRecordMongoCommandRepository->insertOneMessage(
            $openid,
            (int)$customerId,
            $sender,
            WebSocketMessage::LOCATION_MESSAGE,
            $data,
            false
        );
    }

    /**
     * @param \App\OfficialAccount\Interfaces\DTO\Callback\LinkDTO $DTO
     *
     * @return \MongoDB\InsertOneResult
     */
    public function insertLinkMessageRecord(LinkDTO $DTO): InsertOneResult
    {
        // 判断消息的类型
        $openid     = '';
        $customerId = '';
        $sender     = '';

        // 客服发送给用户的消息
        if (method_exists($DTO, 'getSender') && $DTO->getSender() === 'user') {
            $openid     = $DTO->getFromUserName();
            $sender     = $DTO->getSender();
            $customerId = $DTO->getToUserName();
        }

        // 客服发送给用户的消息，转发回来给客服的消息
        if (method_exists($DTO, 'getSender') && $DTO->getSender() === 'customer') {
            $openid     = $DTO->getToUserName();
            $customerId = $DTO->getFromUserName();
            $sender     = $DTO->getSender();
        }

        // 腾讯发过来的消息
        if (method_exists($DTO, 'getMsgType') && $DTO->getMsgType() === 'link.message') {
            $openid     = $DTO->getFromUserName();
            $customerId = $DTO->getToUserName();
            $sender     = 'user';
        }

        // 消息内容
        $data = [
            'content'     => '[链接消息]',
            'url'         => $DTO->getUrl(),
            'title'       => $DTO->getTitle(),
            'description' => $DTO->getDescription()
        ];

        // 记录消息
        return $this->chatMessageRecordMongoCommandRepository->insertOneMessage(
            $openid,
            (int)$customerId,
            $sender,
            WebSocketMessage::LINK_MESSAGE,
            $data,
            false
        );
    }

    /**
     * 更新一条聊天记录
     *
     * @param string $openid  微信用户openid
     * @param bool   $isRead  是否已读
     * @param array  $options 选项
     *
     * @return \MongoDB\UpdateResult
     */
    public function updateOneMessageToReadByOpenid(string $openid, bool $isRead = true, array $options = []): UpdateResult
    {
        return $this->chatMessageRecordMongoCommandRepository->updateOneMessageToReadByOpenid($openid, $isRead, $options);
    }

    /**
     * 更新多条聊天记录
     *
     * @param string $openid
     * @param bool   $isRead
     * @param array  $options
     *
     * @return \MongoDB\UpdateResult
     */
    public function updateManyToReadByOpenid(string $openid, bool $isRead = true, array $options = []): UpdateResult
    {
        return $this->chatMessageRecordMongoCommandRepository->updateManyToReadByOpenid($openid, $isRead, $options);
    }

    /**
     * 获取粉丝的聊天记录
     *
     * @param string $openid
     * @param string $startAt
     * @param string $endAt
     * @param int    $page
     * @param int    $pageSize
     *
     * @return array
     * @throws JsonException
     */
    public function getMessageRecordByOpenid(string $openid, string $startAt, string $endAt, int $page = 1, int $pageSize = 20): array
    {
        $message = $this->chatMessageRecordMongoCommandRepository->getMessageRecordByOpenid($openid, $startAt, $endAt, $page, $pageSize);

        // 如果不存在聊天记录，则返回空数组
        if (!$message['list']) {
            return ['list' => [], 'total' => 0];
        }
        // 转换数组，删除特殊数组的对象
        $message['list'] = json_decode(json_encode($message['list'], JSON_THROW_ON_ERROR), true, 512, JSON_THROW_ON_ERROR);

        // 转驼峰
        foreach ($message['list'] as $key => $value) {
            if ($value['_id']) {
                $message['list'][$key]['id'] = $value['_id']['$oid'];
                unset($message['list'][$key]['_id']);
            }
        }
        $message['list'] = ArrayHelper::convertToHump($message['list']);

        // 用户信息
        // $message['user'] = $this->userQueryRepository->findByOpenid($openid);

        // 分页信息
        $message['perPage'] = $pageSize;
        $message['page']    = $page;

        return $message;
    }

    /**
     * 获取最后一条聊天记录消息记录列表
     *
     * @param int    $customerId
     * @param string $startAt
     * @param string $endAt
     * @param int    $page
     * @param int    $pageSize
     *
     * @return array
     * @throws Exception
     */
    public function getLastMessageChatList(int $customerId, string $startAt, string $endAt, int $page = 1, int $pageSize = 20): array
    {
        $lastMessage = $this->chatMessageRecordMongoCommandRepository->getLastMessageChatList($customerId, $startAt, $endAt, $page, $pageSize);

        $countResult = $this->chatMessageRecordMongoCommandRepository->getLastMessageChatListCount($customerId, $startAt, $endAt);

        $count = (array)current($countResult);

        // 查找需要的openid
        $openid = array_column($lastMessage, 'openid');

        // 查找用户信息
        $user = $this->userQueryRepository->findAllByOpenid($openid);

        // 使用openid 使用 key
        $user = ArrayHelper::index($user, null, 'openid');

        // 合并用户信息
        $temp = [];
        foreach ($lastMessage as $key => $value) {
            $temp[$key]['id'] = $value['_id'];

            // 转驼峰
            foreach ($value as $k => $v) {
                if (is_string($k) && str_contains($k, '_')) {
                    $temp[$key][StringUtil::toHump($k, false)] = $v;
                } else {
                    $temp[$key][$k] = $v;
                }
            }

            // 加入用户信息
            if (isset($user[$value['openid']])) {
                $temp[$key]['user'] = $user[$value['openid']][0];
            } else {
                $temp[$key]['user'] = [
                    'id'             => 0,
                    'platformId'     => 0,
                    'openid'         => $value['openid'],
                    'customerId'     => $value['customer_id'],
                    'customer'       => '',
                    'nickname'       => '',
                    'headImgUrl'     => [],
                    'subscribeAt'    => '',
                    'unsubscribeAt'  => '',
                    'subscribe'      => '',
                    'subscribeScene' => 'ADD_SCENE_OTHERS',
                    'createdAt'      => '',
                    'updatedAt'      => '',
                ];
            }
        }

        // 分页的数据处理
        return [
            'list'      => $temp,
            'count'     => $count['total'],
            'page'      => $page,
            'perPage'   => $pageSize,
            'pageCount' => ceil($count['total'] / $pageSize),
        ];
    }
}
