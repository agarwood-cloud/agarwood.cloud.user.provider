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

use App\OfficialAccount\Domain\Aggregate\Enum\WebSocketMessage;
use App\OfficialAccount\Domain\SendToNodeDomain;
use App\Support\CustomerServiceHttpClient;
use Carbon\Carbon;
use Godruoyi\Snowflake\Snowflake;
use GuzzleHttp\Exception\GuzzleException;
use Swoft\Log\Helper\CLog;

/**
 * @\Swoft\Bean\Annotation\Mapping\Bean()
 */
class SendToNodeDomainImpl implements SendToNodeDomain
{
    /**
     * @\Swoft\Bean\Annotation\Mapping\Inject()
     *
     * @var \App\Support\CustomerServiceHttpClient
     */
    public CustomerServiceHttpClient $httpClient;

    /**
     * 发送 textMessage 到 node 服务器
     *
     * @param string $toUserName   客服的uuid
     * @param string $fromUserId   粉丝的openid
     * @param string $fromUserName 粉丝的昵称
     * @param string $content      转发的消息
     * @param string $sender
     *
     * @return void
     */
    public function textMessage(string $toUserName, string $fromUserId, string $fromUserName, string $content, string $sender = 'customer'): void
    {
        $snowflake = new Snowflake();
        // body 的消息格式
        $body = [
            'toUserName'   => $toUserName,
            'fromUserId'   => $fromUserId,
            'fromUserName' => $fromUserName,
            'content'      => $content,
            'id'           => $snowflake->id(),
            'sender'       => $sender,
            'createdAt'    => Carbon::now()->toDateTimeString(),
            'msgType'      => WebSocketMessage::SERVER_TEXT_MESSAGE,
        ];

        try {
            $client = $this->httpClient->httpClient();
            $client->post('wechat/message', [
                'json' => $body
            ]);
        } catch (GuzzleException $e) {
            CLog::error('Guzzle send textMessage Error:' . $e->getMessage());
        }
    }

    /**
     * 发送图片
     *
     * @param string $toUserName
     * @param string $fromUserId
     * @param string $fromUserName
     * @param string $mediaId
     * @param string $imageUrl
     * @param string $sender
     *
     * @return void
     */
    public function imageMessage(string $toUserName, string $fromUserId, string $fromUserName, string $mediaId, string $imageUrl, string $sender = 'customer'): void
    {
        $snowflake = new Snowflake();
        $body      = [
            'toUserName'   => $toUserName,
            'fromUserId'   => $fromUserId,
            'fromUserName' => $fromUserName,
            'mediaId'      => $mediaId,
            'imageUrl'     => $imageUrl,
            'id'           => $snowflake->id(),
            'sender'       => $sender,
            'createdAt'    => Carbon::now()->toDateTimeString(),
            'msgType'      => WebSocketMessage::SERVER_IMAGE_MESSAGE,
        ];

        try {
            $client = $this->httpClient->httpClient();
            $client->post('wechat/message', [
                'json' => $body
            ]);
        } catch (GuzzleException $e) {
            CLog::error('Guzzle send imageMessage Error:' . $e->getMessage());
        }
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
     * @param string $sender
     *
     * @return void
     */
    public function videoMessage(
        string $toUserName,
        string $fromUserId,
        string $fromUserName,
        string $title,
        string $mediaId,
        string $description,
        string $thumbMediaId,
        string $videoUrl,
        string $sender = 'customer'
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
            'sender'       => $sender,
            'createdAt'    => Carbon::now()->toDateTimeString(),
            'msgType'      => WebSocketMessage::SERVER_VIDEO_MESSAGE,
            'videoUrl'     => $videoUrl
        ];
        try {
            $client = $this->httpClient->httpClient();
            $client->post('wechat/message', [
                'json' => $body
            ]);
        } catch (GuzzleException $e) {
            CLog::error('Guzzle send videoMessage Error:' . $e->getMessage());
        }
    }

    /**
     * 发送声音消息
     *
     * @param string $toUserName
     * @param string $fromUserId
     * @param string $fromUserName
     * @param string $mediaId
     * @param string $voiceUrl
     * @param string $sender
     *
     * @return void
     */
    public function voiceMessage(string $toUserName, string $fromUserId, string $fromUserName, string $mediaId, string $voiceUrl, string $sender = 'customer'): void
    {
        $snowflake = new Snowflake();

        $body = [
            'toUserName'   => $toUserName,
            'fromUserId'   => $fromUserId,
            'fromUserName' => $fromUserName,
            'mediaId'      => $mediaId,
            'voiceUrl'     => $voiceUrl,
            'id'           => $snowflake->id(),
            'sender'       => $sender,
            'createdAt'    => Carbon::now()->toDateTimeString(),
            'msgType'      => WebSocketMessage::SERVER_VOICE_MESSAGE,
        ];

        try {
            $client = $this->httpClient->httpClient();
            $client->post('wechat/message', [
                'json' => $body
            ]);
        } catch (GuzzleException $e) {
            CLog::error('Guzzle send voiceMessage Error:' . $e->getMessage());
        }
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
     * @param string $sender
     *
     * @return void
     */
    public function newsItemMessage(string $toUserName, string $fromUserId, string $fromUserName, string $title, string $description, string $url, string $image, string $sender = 'customer'): void
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
            'sender'       => $sender,
            'createdAt'    => Carbon::now()->toDateTimeString(),
            'msgType'      => WebSocketMessage::SERVER_NEWS_ITEM_MESSAGE,
        ];
        try {
            $client = $this->httpClient->httpClient();
            $client->post('wechat/message', [
                'json' => $body
            ]);
        } catch (GuzzleException $e) {
            CLog::error('Guzzle send newItemMessage Error:' . $e->getMessage());
        }
    }

    /**
     * 错误的消息
     *
     * @param string $toUserName
     * @param string $fromUserId
     * @param string $fromUserName
     * @param string $content
     * @param int    $errorCode
     * @param string $sender
     */
    public function errorMessage(string $toUserName, string $fromUserId, string $fromUserName, string $content, int $errorCode, string $sender = 'customer'): void
    {
        $body = [
            'toUserName'   => $toUserName,
            'fromUserId'   => $fromUserId,
            'fromUserName' => $fromUserName,
            'content'      => $content,
            'sender'       => $sender,
            'errorCode'    => $errorCode,
            'createdAt'    => Carbon::now()->toDateTimeString(),
            'msgType'      => WebSocketMessage::SERVER_ERROR_MESSAGE,
        ];

        try {
            $client = $this->httpClient->httpClient();
            $client->post('wechat/message', [
                'json' => $body
            ]);
        } catch (GuzzleException $e) {
            CLog::error('Guzzle send newItemMessage Error:' . $e->getMessage());
        }
    }
}
