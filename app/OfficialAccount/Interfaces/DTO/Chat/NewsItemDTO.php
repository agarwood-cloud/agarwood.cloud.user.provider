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
 * @\Swoft\Validator\Annotation\Mapping\Validator()
 */
class NewsItemDTO extends AbstractBaseDTO
{
    /**
     * 发送人，uuid
     *
     * @\Swoft\Validator\Annotation\Mapping\IsString()
     * @\Swoft\Validator\Annotation\Mapping\Required()
     * @\Swoft\Validator\Annotation\Mapping\NotEmpty()
     *
     * @var string
     */
    public string $fromUserId = '';

    /**
     * 发送人，uuid
     *
     * @\Swoft\Validator\Annotation\Mapping\IsString()
     * @\Swoft\Validator\Annotation\Mapping\Required()
     * @\Swoft\Validator\Annotation\Mapping\NotEmpty()
     *
     * @var string
     */
    public string $fromUserName = '';

    /**
     * 收件人，openid
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
     * 文章标题
     *
     * @\Swoft\Validator\Annotation\Mapping\IsString()
     * @\Swoft\Validator\Annotation\Mapping\Required()
     * @\Swoft\Validator\Annotation\Mapping\NotEmpty()
     *
     * @var string
     */
    public string $newItemUrl = '';

    /**
     * 标题
     *
     * @\Swoft\Validator\Annotation\Mapping\IsString()
     * @\Swoft\Validator\Annotation\Mapping\Required()
     * @\Swoft\Validator\Annotation\Mapping\NotEmpty()
     *
     * @var string
     */
    public string $title = '';

    /**
     *  描述
     *
     * @\Swoft\Validator\Annotation\Mapping\IsString()
     * @\Swoft\Validator\Annotation\Mapping\Required()
     * @\Swoft\Validator\Annotation\Mapping\NotEmpty()
     *
     * @var string
     */
    public string $description = '';

    /**
     * 关联的图片封面
     *
     * @\Swoft\Validator\Annotation\Mapping\IsString()
     *
     * @var string
     */
    public string $imageUrl = '';

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
    public function getNewItemUrl(): string
    {
        return $this->newItemUrl;
    }

    /**
     * @param string $newItemUrl
     */
    public function setNewItemUrl(string $newItemUrl): void
    {
        $this->newItemUrl = $newItemUrl;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    /**
     * @return string
     */
    public function getImageUrl(): string
    {
        return $this->imageUrl;
    }

    /**
     * @param string $imageUrl
     */
    public function setImageUrl(string $imageUrl): void
    {
        $this->imageUrl = $imageUrl;
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
