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

use EasyWeChat\OfficialAccount\Application;

/**
 * @\Swoft\Bean\Annotation\Mapping\Bean()
 */
interface VideoMessageHandlerDomain
{
    /**
     * @param int                                     $officialAccountId
     * @param \EasyWeChat\OfficialAccount\Application $application
     */
    public function videoMessage(int $officialAccountId, Application $application): void;

    /**
     * 构建音频消息，转发文本消息到 node
     *
     * @param string $toUserName   客服的uuid
     * @param string $fromUserId   粉丝的openid
     * @param string $fromUserName 粉丝的昵称
     * @param string $title
     * @param string $mediaId
     * @param string $description
     * @param string $thumbMediaId
     * @param string $videoUrl
     *
     * @return array
     */
    public function buildVideoMessage(
        string $toUserName,
        string $fromUserId,
        string $fromUserName,
        string $title,
        string $mediaId,
        string $description,
        string $thumbMediaId,
        string $videoUrl
    ): array;
}
