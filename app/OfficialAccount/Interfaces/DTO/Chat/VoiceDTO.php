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
use Swoft\Validator\Annotation\Mapping\IsString;
use Swoft\Validator\Annotation\Mapping\NotEmpty;
use Swoft\Validator\Annotation\Mapping\Required;
use Swoft\Validator\Annotation\Mapping\Validator;

/**
 *
 * @Validator()
 */
class VoiceDTO extends AbstractBaseDTO
{
    /**
     * 发送人，uuid
     *
     * @IsString()
     * @Required()
     * @NotEmpty()
     *
     * @var string
     */
    public string $fromUserId = '';

    /**
     * 发送人，uuid
     *
     * @IsString()
     * @Required()
     * @NotEmpty()
     *
     * @var string
     */
    public string $fromUserName = '';

    /**
     * 收件人，openid
     *
     * @IsString()
     * @Required()
     * @NotEmpty()
     *
     * @var string
     */
    public string $toUserName = '';

    /**
     *
     *
     * @IsString()
     * @Required()
     * @NotEmpty()
     *
     * @var string
     */
    public string $createAt = '';

    /**
     *
     * @IsString()
     * @Required()
     * @NotEmpty()
     *
     * @var string
     */
    public string $mediaId = '';

    /**
     *
     *
     * @IsString()
     * @Required()
     * @NotEmpty()
     *
     * @var string
     */
    public string $msgType = 'image';

    /**
     *
     *
     * @IsString()
     * @Required()
     * @NotEmpty()
     *
     * @var string
     */
    public string $url = '';

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
    public function getCreateAt(): string
    {
        return $this->createAt;
    }

    /**
     * @param string $createAt
     */
    public function setCreateAt(string $createAt): void
    {
        $this->createAt = $createAt;
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
}
