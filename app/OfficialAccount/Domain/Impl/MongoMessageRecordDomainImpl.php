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
     * ??????????????????
     *
     * @param ChatTextDTO | CallbackTextDTO $textDTO
     *
     * @return \MongoDB\InsertOneResult
     */
    public function insertTextMessageRecord(ChatTextDTO|CallbackTextDTO $textDTO): InsertOneResult
    {
        // ?????????????????????
        $openid     = '';
        $customerId = '';
        $sender     = '';

        // ??????????????????????????????
        if (method_exists($textDTO, 'getSender') && $textDTO->getSender() === 'user') {
            $openid     = $textDTO->getFromUserName();
            $customerId = $textDTO->getToUserName();
            $sender     = $textDTO->getSender();
        }

        // ???????????????????????????????????????????????????????????????
        if (method_exists($textDTO, 'getSender') && $textDTO->getSender() === 'customer') {
            $openid     = $textDTO->getToUserName();
            $customerId = $textDTO->getFromUserName();
            $sender     = $textDTO->getSender();
        }

        // ????????????????????????
        if (method_exists($textDTO, 'getMsgType') && $textDTO->getMsgType() === 'text.message') {
            $openid     = $textDTO->getFromUserName();
            $customerId = $textDTO->getToUserName();
            $sender     = 'user';
        }

        // ????????????
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
     * ??????????????????
     *
     * @param \App\OfficialAccount\Interfaces\DTO\Callback\ImageDTO|\App\OfficialAccount\Interfaces\DTO\Chat\ImageDTO $imageDTO
     * @param string                                                                                                  $imageUrl
     *
     * @return \MongoDB\InsertOneResult
     */
    public function insertImageMessageRecord(CallBackChatImageDTO|ChatImageDTO $imageDTO, string $imageUrl): InsertOneResult
    {
        // ?????????????????????
        $openid     = '';
        $customerId = '';
        $sender     = '';

        // ??????????????????????????????
        if (method_exists($imageDTO, 'getSender') && $imageDTO->getSender() === 'user') {
            $openid     = $imageDTO->getFromUserName();
            $sender     = $imageDTO->getSender();
            $customerId = $imageDTO->getToUserName();
        }

        // ???????????????????????????????????????????????????????????????
        if (method_exists($imageDTO, 'getSender') && $imageDTO->getSender() === 'customer') {
            $openid     = $imageDTO->getToUserName();
            $customerId = $imageDTO->getFromUserName();
            $sender     = $imageDTO->getSender();
        }

        // ????????????????????????
        if (method_exists($imageDTO, 'getMsgType') && $imageDTO->getMsgType() === 'image.message') {
            $openid     = $imageDTO->getFromUserName();
            $customerId = $imageDTO->getToUserName();
            $sender     = 'user';
        }

        // ????????????
        $data = [
            'content'   => '[????????????]',
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

        // ????????????
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
     * ??????????????????
     *
     * @param \App\OfficialAccount\Interfaces\DTO\Callback\VideoDTO|\App\OfficialAccount\Interfaces\DTO\Chat\VideoDTO $videoDTO
     * @param string                                                                                                  $videoUrl
     *
     * @return \MongoDB\InsertOneResult
     */
    public function insertVideoMessageRecord(CallbackVideoDTO|ChatVideoDTO $videoDTO, string $videoUrl): InsertOneResult
    {
        // ?????????????????????
        $openid     = '';
        $customerId = '';
        $sender     = '';

        // ??????????????????????????????
        if (method_exists($videoDTO, 'getSender') && $videoDTO->getSender() === 'user') {
            $openid     = $videoDTO->getFromUserName();
            $sender     = $videoDTO->getSender();
            $customerId = $videoDTO->getToUserName();
        }

        // ???????????????????????????????????????????????????????????????
        if (method_exists($videoDTO, 'getSender') && $videoDTO->getSender() === 'customer') {
            $openid     = $videoDTO->getToUserName();
            $customerId = $videoDTO->getFromUserName();
            $sender     = $videoDTO->getSender();
        }

        // ????????????????????????
        if (method_exists($videoDTO, 'getMsgType') && $videoDTO->getMsgType() === 'video.message') {
            $openid     = $videoDTO->getFromUserName();
            $customerId = $videoDTO->getToUserName();
            $sender     = 'user';
        }

        // ????????????
        $data = [
            'content'     => '[????????????]',
            'video_url'   => $videoUrl,
            'title'       => $videoDTO->getTitle(),
            'description' => $videoDTO->getDescription(),
        ];

        // ????????????
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
     * ??????????????????
     *
     * @param \App\OfficialAccount\Interfaces\DTO\Callback\VoiceDTO|\App\OfficialAccount\Interfaces\DTO\Chat\VoiceDTO $voiceDTO
     * @param string                                                                                                  $voiceUrl
     *
     * @return \MongoDB\InsertOneResult
     */
    public function insertVoiceMessageRecord(CallBackChatVoiceDTO|ChatVoiceDTO $voiceDTO, string $voiceUrl): InsertOneResult
    {
        // ?????????????????????
        $openid     = '';
        $customerId = '';
        $sender     = '';

        // ??????????????????????????????
        if (method_exists($voiceDTO, 'getSender') && $voiceDTO->getSender() === 'user') {
            $openid     = $voiceDTO->getFromUserName();
            $sender     = $voiceDTO->getSender();
            $customerId = $voiceDTO->getToUserName();
        }

        // ???????????????????????????????????????????????????????????????
        if (method_exists($voiceDTO, 'getSender') && $voiceDTO->getSender() === 'customer') {
            $openid     = $voiceDTO->getToUserName();
            $customerId = $voiceDTO->getFromUserName();
            $sender     = $voiceDTO->getSender();
        }

        // ????????????????????????
        if (method_exists($voiceDTO, 'getMsgType') && $voiceDTO->getMsgType() === 'video.message') {
            $openid     = $voiceDTO->getFromUserName();
            $customerId = $voiceDTO->getToUserName();
            $sender     = 'user';
        }

        // ????????????
        $data = [
            'content'   => '[????????????]',
            'voice_url' => $voiceUrl
        ];

        // ????????????
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
     * ????????????????????????
     *
     * @param string $openid     ????????????openid
     * @param int    $customerId ??????id
     * @param string $sender     ?????????
     * @param string $msgType    ????????????
     * @param array  $data       ????????????
     * @param bool   $isRead     ????????????
     *
     * @return \MongoDB\InsertOneResult
     */
    public function insertOneMessage(string $openid, int $customerId, string $sender, string $msgType, array $data, bool $isRead = false): InsertOneResult
    {
        return $this->chatMessageRecordMongoCommandRepository->insertOneMessage($openid, $customerId, $sender, $msgType, $data, $isRead);
    }

    /**
     * ????????????????????????
     *
     * @param array $document ????????????
     * @param array $options
     *
     * @return \MongoDB\InsertManyResult
     */
    public function insertManyMessage(array $document, array $options = []): InsertManyResult
    {
        return $this->chatMessageRecordMongoCommandRepository->insertManyMessage($document, $options);
    }

//    /**
//     * ??????????????????
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
        // ?????????????????????
        $openid     = '';
        $customerId = '';
        $sender     = '';

        // ??????????????????????????????
        if (method_exists($DTO, 'getSender') && $DTO->getSender() === 'user') {
            $openid     = $DTO->getFromUserName();
            $sender     = $DTO->getSender();
            $customerId = $DTO->getToUserName();
        }

        // ???????????????????????????????????????????????????????????????
        if (method_exists($DTO, 'getSender') && $DTO->getSender() === 'customer') {
            $openid     = $DTO->getToUserName();
            $customerId = $DTO->getFromUserName();
            $sender     = $DTO->getSender();
        }

        // ????????????????????????
        if (method_exists($DTO, 'getMsgType') && $DTO->getMsgType() === 'link.message') {
            $openid     = $DTO->getFromUserName();
            $customerId = $DTO->getToUserName();
            $sender     = 'user';
        }

        // ????????????
        $data = [
            'content'    => '[????????????]',
            'location_x' => $DTO->getLocationX(),
            'location_y' => $DTO->getLocationY(),
            'scale'      => $DTO->getScale(),
            'label'      => $DTO->getLabel(),
        ];

        // ????????????
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
        // ?????????????????????
        $openid     = '';
        $customerId = '';
        $sender     = '';

        // ??????????????????????????????
        if (method_exists($DTO, 'getSender') && $DTO->getSender() === 'user') {
            $openid     = $DTO->getFromUserName();
            $sender     = $DTO->getSender();
            $customerId = $DTO->getToUserName();
        }

        // ???????????????????????????????????????????????????????????????
        if (method_exists($DTO, 'getSender') && $DTO->getSender() === 'customer') {
            $openid     = $DTO->getToUserName();
            $customerId = $DTO->getFromUserName();
            $sender     = $DTO->getSender();
        }

        // ????????????????????????
        if (method_exists($DTO, 'getMsgType') && $DTO->getMsgType() === 'link.message') {
            $openid     = $DTO->getFromUserName();
            $customerId = $DTO->getToUserName();
            $sender     = 'user';
        }

        // ????????????
        $data = [
            'content'     => '[????????????]',
            'url'         => $DTO->getUrl(),
            'title'       => $DTO->getTitle(),
            'description' => $DTO->getDescription()
        ];

        // ????????????
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
     * ????????????????????????
     *
     * @param string $openid  ????????????openid
     * @param bool   $isRead  ????????????
     * @param array  $options ??????
     *
     * @return \MongoDB\UpdateResult
     */
    public function updateOneMessageToReadByOpenid(string $openid, bool $isRead = true, array $options = []): UpdateResult
    {
        return $this->chatMessageRecordMongoCommandRepository->updateOneMessageToReadByOpenid($openid, $isRead, $options);
    }

    /**
     * ????????????????????????
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
     * ???????????????????????????
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

        // ????????????????????????????????????????????????
        if (!$message['list']) {
            return ['list' => [], 'total' => 0];
        }
        // ??????????????????????????????????????????
        $message['list'] = json_decode(json_encode($message['list'], JSON_THROW_ON_ERROR), true, 512, JSON_THROW_ON_ERROR);

        // ?????????
        foreach ($message['list'] as $key => $value) {
            if ($value['_id']) {
                $message['list'][$key]['id'] = $value['_id']['$oid'];
                unset($message['list'][$key]['_id']);
            }
        }
        $message['list'] = ArrayHelper::convertToHump($message['list']);

        // ????????????
        // $message['user'] = $this->userQueryRepository->findByOpenid($openid);

        // ????????????
        $message['perPage'] = $pageSize;
        $message['page']    = $page;

        return $message;
    }

    /**
     * ????????????????????????????????????????????????
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

        // ???????????????openid
        $openid = array_column($lastMessage, 'openid');

        // ??????????????????
        $user = $this->userQueryRepository->findAllByOpenid($openid);

        // ??????openid ?????? key
        $user = ArrayHelper::index($user, null, 'openid');

        // ??????????????????
        $temp = [];
        foreach ($lastMessage as $key => $value) {
            $temp[$key]['id'] = $value['_id'];

            // ?????????
            foreach ($value as $k => $v) {
                if (is_string($k) && str_contains($k, '_')) {
                    $temp[$key][StringUtil::toHump($k, false)] = $v;
                } else {
                    $temp[$key][$k] = $v;
                }
            }

            // ??????????????????
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

        // ?????????????????????
        return [
            'list'      => $temp,
            'count'     => $count['total'] ?? 0,
            'page'      => $page,
            'perPage'   => $pageSize,
            'pageCount' => isset($count['total']) ? ceil($count['total'] / $pageSize): 0,
        ];
    }
}
