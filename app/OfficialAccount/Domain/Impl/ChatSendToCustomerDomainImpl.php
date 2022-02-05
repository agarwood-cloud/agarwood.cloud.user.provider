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

use App\OfficialAccount\Domain\Aggregate\Enum\SubscriberEnum;
use App\OfficialAccount\Domain\Aggregate\Enum\WebSocketMessage;
use App\OfficialAccount\Domain\ChatSendToCustomerDomain;
use Carbon\Carbon;
use Godruoyi\Snowflake\Snowflake;
use Swoft\Redis\Redis;
use JsonException;

/**
 * @\Swoft\Bean\Annotation\Mapping\Bean()
 */
class ChatSendToCustomerDomainImpl implements ChatSendToCustomerDomain
{
    /**
     * 发送 textMessage 到 node 服务器
     *
     * @param string $toUserName 客服的uuid
     * @param string $fromUserId 粉丝的openid
     * @param string $content    转发的消息
     *
     * @return void
     * @throws JsonException
     */
    public function textMessage(string $toUserName, string $fromUserId, string $content): void
    {
        $snowflake = new Snowflake();

        $body = [
            'toUserName'   => $toUserName,
            'fromUserId'   => $fromUserId,
            'content'      => $content,
            'id'           => $snowflake->id(),
            'sender'       => 'customer',
            'createdAt'    => Carbon::now()->toDateTimeString(),
            'msgType'      => WebSocketMessage::TEXT_MESSAGE,
        ];

        // send to customer
        Redis::publish(SubscriberEnum::REDIS_SUBSCRIBER_CUSTOMER_CHAT_CHANNEL, json_encode($body, JSON_THROW_ON_ERROR));
    }

    /**
     * 发送图片
     *
     * @param string $toUserName
     * @param string $fromUserId
     * @param string $fromUserName
     * @param string $mediaId
     * @param string $imageUrl
     *
     * @return void
     * @throws JsonException
     */
    public function imageMessage(string $toUserName, string $fromUserId, string $fromUserName, string $mediaId, string $imageUrl): void
    {
        $snowflake = new Snowflake();
        $body      = [
            'toUserName'   => $toUserName,
            'fromUserId'   => $fromUserId,
            'fromUserName' => $fromUserName,
            'mediaId'      => $mediaId,
            'imageUrl'     => $imageUrl,
            'id'           => $snowflake->id(),
            'sender'       => 'customer',
            'createdAt'    => Carbon::now()->toDateTimeString(),
            'msgType'      => WebSocketMessage::IMAGE_MESSAGE,
        ];

        // send to customer
        Redis::publish(SubscriberEnum::REDIS_SUBSCRIBER_CUSTOMER_CHAT_CHANNEL, json_encode($body, JSON_THROW_ON_ERROR));
    }

    /**
     * 发送视频消息
     *
     * @param string $toUserName
     * @param string $fromUserId
     * @param string $fromUserName
     * @param string $title
     * @param string $mediaId
     * @param string $description
     * @param string $thumbMediaId
     * @param string $videoUrl
     *
     * @return void
     * @throws JsonException
     */
    public function videoMessage(
        string $toUserName,
        string $fromUserId,
        string $fromUserName,
        string $title,
        string $mediaId,
        string $description,
        string $thumbMediaId,
        string $videoUrl
    ): void {
        $snowflake = new Snowflake();
        $body      = [
            'toUserName'   => $toUserName,
            'fromUserId'   => $fromUserId,
            'fromUserName' => $fromUserName,
            'title'        => $title,
            'description'  => $description,
            'mediaId'      => $mediaId,
            'thumbMediaId' => $thumbMediaId,
            'id'           => $snowflake->id(),
            'sender'       => 'customer',
            'createdAt'    => Carbon::now()->toDateTimeString(),
            'msgType'      => WebSocketMessage::VIDEO_MESSAGE,
            'videoUrl'     => $videoUrl
        ];
        // send to customer
        Redis::publish(SubscriberEnum::REDIS_SUBSCRIBER_CUSTOMER_CHAT_CHANNEL, json_encode($body, JSON_THROW_ON_ERROR));
    }

    /**
     * 发送声音消息
     *
     * @param string $toUserName
     * @param string $fromUserId
     * @param string $fromUserName
     * @param string $mediaId
     * @param string $voiceUrl
     *
     * @return void
     * @throws JsonException
     */
    public function voiceMessage(string $toUserName, string $fromUserId, string $fromUserName, string $mediaId, string $voiceUrl): void
    {
        $snowflake = new Snowflake();

        $body = [
            'toUserName'   => $toUserName,
            'fromUserId'   => $fromUserId,
            'fromUserName' => $fromUserName,
            'mediaId'      => $mediaId,
            'voiceUrl'     => $voiceUrl,
            'id'           => $snowflake->id(),
            'sender'       => 'customer',
            'createdAt'    => Carbon::now()->toDateTimeString(),
            'msgType'      => WebSocketMessage::VOICE_MESSAGE,
        ];

        // send to customer
        Redis::publish(SubscriberEnum::REDIS_SUBSCRIBER_CUSTOMER_CHAT_CHANNEL, json_encode($body, JSON_THROW_ON_ERROR));
    }

    /**
     * 转发图发消息
     *
     * @param string $toUserName
     * @param string $fromUserId
     * @param string $fromUserName
     * @param string $title
     * @param string $description
     * @param string $url
     * @param string $image
     *
     * @return void
     * @throws JsonException
     */
    public function newsItemMessage(string $toUserName, string $fromUserId, string $fromUserName, string $title, string $description, string $url, string $image): void
    {
        $snowflake = new Snowflake();
        $body      = [
            'toUserName'   => $toUserName,
            'fromUserId'   => $fromUserId,
            'fromUserName' => $fromUserName,
            'title'        => $title,
            'description'  => $description,
            'image'        => $image,
            'url'          => $url,
            'id'           => $snowflake->id(),
            'sender'       => 'customer',
            'createdAt'    => Carbon::now()->toDateTimeString(),
            'msgType'      => WebSocketMessage::NEWS_ITEM_MESSAGE,
        ];
        // send to customer
        Redis::publish(SubscriberEnum::REDIS_SUBSCRIBER_CUSTOMER_CHAT_CHANNEL, json_encode($body, JSON_THROW_ON_ERROR));
    }

    /**
     * 错误的消息
     *
     * @param string $toUserName
     * @param string $fromUserId
     * @param string $content
     * @param int    $errorCode
     *
     * @throws JsonException
     */
    public function errorMessage(string $toUserName, string $fromUserId, string $content, int $errorCode): void
    {
        $body = [
            'toUserName'   => $toUserName,
            'fromUserId'   => $fromUserId,
            'content'      => $content,
            'sender'       => 'customer',
            'errorCode'    => $errorCode,
            'createdAt'    => Carbon::now()->toDateTimeString(),
            'msgType'      => WebSocketMessage::ERROR_MESSAGE,
        ];

        // send to customer
        Redis::publish(SubscriberEnum::REDIS_SUBSCRIBER_CUSTOMER_CHAT_CHANNEL, json_encode($body, JSON_THROW_ON_ERROR));
    }
}
