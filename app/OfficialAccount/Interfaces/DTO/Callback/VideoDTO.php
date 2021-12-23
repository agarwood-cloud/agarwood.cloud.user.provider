<?php declare(strict_types=1);
/**
 * This file is part of Agarwood Cloud.
 *
 * @link     https://www.agarwood-cloud.com
 * @document https://www.agarwood-cloud.com/docs
 * @contact  676786620@qq.com
 * @author   agarwood
 */

namespace App\OfficialAccount\Interfaces\DTO\Callback;

use Agarwood\Core\Support\Impl\AbstractBaseDTO;
use Swoft\Validator\Annotation\Mapping\Validator;

/**
 *
 * @Validator()
 */
class VideoDTO extends AbstractBaseDTO
{
    /**
     * @var string $ToUserName 接收方帐号（该公众号 ID）
     */
    public string $ToUserName = '';

    /**
     * @var string $FromUserName 发送方帐号（OpenID, 代表用户的唯一标识）
     */
    public string $FromUserName = '';

    /**
     * @var int $CreateTime 消息创建时间（时间戳）
     */
    public int $CreateTime = 0;

    /**
     * @var string $MsgType
     */
    public string $MsgType = 'video';

    /**
     * @var string $ThumbMediaId
     */
    public string $ThumbMediaId = '';

    /**
     * @var int $MsgId
     */
    public int $MsgId = 0;

    /**
     * @var string $MediaId
     */
    public string $MediaId = '';

    /**
     * @var string
     */
    public string $title = '';

    /**
     * @var string
     */
    public string $description = '';

    /**
     * @var string $Encrypt
     */
    public string $Encrypt = '';

    /**
     * @return string
     */
    public function getToUserName(): string
    {
        return $this->ToUserName;
    }

    /**
     * @param string $ToUserName
     */
    public function setToUserName(string $ToUserName): void
    {
        $this->ToUserName = $ToUserName;
    }

    /**
     * @return string
     */
    public function getFromUserName(): string
    {
        return $this->FromUserName;
    }

    /**
     * @param string $FromUserName
     */
    public function setFromUserName(string $FromUserName): void
    {
        $this->FromUserName = $FromUserName;
    }

    /**
     * @return string
     */
    public function getMsgType(): string
    {
        return $this->MsgType;
    }

    /**
     * @param string $MsgType
     */
    public function setMsgType(string $MsgType): void
    {
        $this->MsgType = $MsgType;
    }

    /**
     * @return string
     */
    public function getThumbMediaId(): string
    {
        return $this->ThumbMediaId;
    }

    /**
     * @param string $ThumbMediaId
     */
    public function setThumbMediaId(string $ThumbMediaId): void
    {
        $this->ThumbMediaId = $ThumbMediaId;
    }

    /**
     * @return string
     */
    public function getMediaId(): string
    {
        return $this->MediaId;
    }

    /**
     * @param string $MediaId
     */
    public function setMediaId(string $MediaId): void
    {
        $this->MediaId = $MediaId;
    }

    /**
     * @return string
     */
    public function getEncrypt(): string
    {
        return $this->Encrypt;
    }

    /**
     * @param string $Encrypt
     */
    public function setEncrypt(string $Encrypt): void
    {
        $this->Encrypt = $Encrypt;
    }

    /**
     * @return int
     */
    public function getCreateTime(): int
    {
        return $this->CreateTime;
    }

    /**
     * @return int
     */
    public function getMsgId(): int
    {
        return $this->MsgId;
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
}
