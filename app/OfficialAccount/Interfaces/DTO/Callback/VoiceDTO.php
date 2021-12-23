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
class VoiceDTO extends AbstractBaseDTO
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
    public string $MsgType = 'voice';

    /**
     * @var string $ThumbMediaId
     */
    public string $Format = '';

    /**
     * @var int $MsgId
     */
    public int $MsgId = 0;

    /**
     * @var string $MediaId
     */
    public string $MediaId = '';

    /**
     * @var string $Encrypt
     */
    public string $Encrypt = '';

    /**
     * 声音识别
     *
     * @var string|null
     */
    public ?string $Recognition = '';

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
     * @return int
     */
    public function getCreateTime(): int
    {
        return $this->CreateTime;
    }

    /**
     * @param int $CreateTime
     */
    public function setCreateTime(int $CreateTime): void
    {
        $this->CreateTime = $CreateTime;
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
    public function getFormat(): string
    {
        return $this->Format;
    }

    /**
     * @param string $Format
     */
    public function setFormat(string $Format): void
    {
        $this->Format = $Format;
    }

    /**
     * @return int
     */
    public function getMsgId(): int
    {
        return $this->MsgId;
    }

    /**
     * @param int $MsgId
     */
    public function setMsgId(int $MsgId): void
    {
        $this->MsgId = $MsgId;
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
     * @return string|null
     */
    public function getRecognition(): ?string
    {
        return $this->Recognition;
    }

    /**
     * @param string|null $Recognition
     */
    public function setRecognition(?string $Recognition): void
    {
        $this->Recognition = $Recognition;
    }
}
