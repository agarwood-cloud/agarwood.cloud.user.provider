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

/**
 * @\Swoft\Bean\Annotation\Mapping\Bean()
 */
interface SendToNodeDomain
{
    /**
     * 转发文本消息到 node
     *
     * @param string $toUserName   客服的uuid
     * @param string $fromUserId   粉丝的openid
     * @param string $fromUserName 粉丝的昵称
     * @param string $content      转发的消息
     * @param string $sender
     *
     * @return void
     */
    public function textMessage(
        string $toUserName,
        string $fromUserId,
        string $fromUserName,
        string $content,
        string $sender = 'customer'
    ): void;

    /**
     * 转发图片消息到 node
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
    public function imageMessage(
        string $toUserName,
        string $fromUserId,
        string $fromUserName,
        string $mediaId,
        string $imageUrl,
        string $sender = 'customer'
    ): void;

    /**
     * 转发视频信息到node
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
    ): void;

    /**
     * 转发视频信息到node
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
    public function voiceMessage(
        string $toUserName,
        string $fromUserId,
        string $fromUserName,
        string $mediaId,
        string $voiceUrl,
        string $sender = 'customer'
    ): void;

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
    public function newsItemMessage(
        string $toUserName,
        string $fromUserId,
        string $fromUserName,
        string $title,
        string $description,
        string $url,
        string $image,
        string $sender = 'customer'
    ): void;

    /**
     * 将错误的异常消息全部转发给node
     *
     * @param string $toUserName   客服的uuid
     * @param string $fromUserId   粉丝的openid
     * @param string $fromUserName 粉丝的昵称
     * @param string $content      转发的消息
     * @param int    $errorCode
     * @param string $sender
     *
     * @return void
     */
    public function errorMessage(
        string $toUserName,
        string $fromUserId,
        string $fromUserName,
        string $content,
        int    $errorCode,
        string $sender = 'customer'
    ): void;
}
