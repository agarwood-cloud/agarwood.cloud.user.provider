<?php declare(strict_types=1);
/**
 * This file is part of Agarwood Cloud.
 *
 * @link     https://www.agarwood-cloud.com
 * @document https://www.agarwood-cloud.com/docs
 * @contact  676786620@qq.com
 * @author   agarwood
 */

namespace App\OfficialAccount\Interfaces\DTO\Chat;

use Agarwood\Core\Support\Impl\AbstractBaseDTO;

/**
 *
 * @\Swoft\Validator\Annotation\Mapping\Validator()
 */
class VoiceDTO extends AbstractBaseDTO
{
    /**
     * 发送人
     *
     * @\Swoft\Validator\Annotation\Mapping\IsString()
     * @\Swoft\Validator\Annotation\Mapping\Required()
     * @\Swoft\Validator\Annotation\Mapping\NotEmpty()
     *
     * @var string
     */
    public string $fromUserId = '';

    /**
     * 发送人
     *
     * @\Swoft\Validator\Annotation\Mapping\IsString()
     * @\Swoft\Validator\Annotation\Mapping\Required()
     * @\Swoft\Validator\Annotation\Mapping\NotEmpty()
     *
     * @var string
     */
    public string $fromUserName = '';

    /**
     * 收件人
     *
     * @\Swoft\Validator\Annotation\Mapping\IsString()
     * @\Swoft\Validator\Annotation\Mapping\Required()
     * @\Swoft\Validator\Annotation\Mapping\NotEmpty()
     *
     * @var string
     */
    public string $toUserName = '';

    /**
     * 时间
     *
     * @\Swoft\Validator\Annotation\Mapping\IsString()
     * @\Swoft\Validator\Annotation\Mapping\Required()
     * @\Swoft\Validator\Annotation\Mapping\NotEmpty()
     *
     * @var string
     */
    public string $createdAt = '';

    /**
     * 腾讯平台的语音ID
     *
     * @\Swoft\Validator\Annotation\Mapping\IsString()
     * @\Swoft\Validator\Annotation\Mapping\Required()
     * @\Swoft\Validator\Annotation\Mapping\NotEmpty()
     *
     * @var string
     */
    public string $mediaId = '';

    /**
     * 消息类型
     *
     * @\Swoft\Validator\Annotation\Mapping\IsString()
     * @\Swoft\Validator\Annotation\Mapping\Required()
     * @\Swoft\Validator\Annotation\Mapping\NotEmpty()
     *
     * @var string
     */
    public string $msgType = '';

    /**
     * 消息URL
     *
     * @\Swoft\Validator\Annotation\Mapping\IsString()
     * @\Swoft\Validator\Annotation\Mapping\Required()
     * @\Swoft\Validator\Annotation\Mapping\NotEmpty()
     *
     * @var string
     */
    public string $url = '';

    /**
     * 发送者
     *
     * @\Swoft\Validator\Annotation\Mapping\IsString()
     * @\Swoft\Validator\Annotation\Mapping\Required()
     * @\Swoft\Validator\Annotation\Mapping\NotEmpty()
     *
     * @var string
     */
    public string $sender = '';

    /**
     * @return string
     */
    public function getFromUserId(): string
    {
        return $this->fromUserId;
    }

    /**
     * @param string $fromUserId
     */
    public function setFromUserId(string $fromUserId): void
    {
        $this->fromUserId = $fromUserId;
    }

    /**
     * @return string
     */
    public function getFromUserName(): string
    {
        return $this->fromUserName;
    }

    /**
     * @param string $fromUserName
     */
    public function setFromUserName(string $fromUserName): void
    {
        $this->fromUserName = $fromUserName;
    }

    /**
     * @return string
     */
    public function getToUserName(): string
    {
        return $this->toUserName;
    }

    /**
     * @param string $toUserName
     */
    public function setToUserName(string $toUserName): void
    {
        $this->toUserName = $toUserName;
    }

    /**
     * @return string
     */
    public function getCreatedAt(): string
    {
        return $this->createdAt;
    }

    /**
     * @param string $createdAt
     */
    public function setCreatedAt(string $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return string
     */
    public function getMediaId(): string
    {
        return $this->mediaId;
    }

    /**
     * @param string $mediaId
     */
    public function setMediaId(string $mediaId): void
    {
        $this->mediaId = $mediaId;
    }

    /**
     * @return string
     */
    public function getMsgType(): string
    {
        return $this->msgType;
    }

    /**
     * @param string $msgType
     */
    public function setMsgType(string $msgType): void
    {
        $this->msgType = $msgType;
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * @param string $url
     */
    public function setUrl(string $url): void
    {
        $this->url = $url;
    }

    /**
     * @return string
     */
    public function getSender(): string
    {
        return $this->sender;
    }

    /**
     * @param string $sender
     */
    public function setSender(string $sender): void
    {
        $this->sender = $sender;
    }
}
