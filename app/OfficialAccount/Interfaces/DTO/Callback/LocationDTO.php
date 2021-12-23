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
class LocationDTO extends AbstractBaseDTO
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
    public string $MsgType = 'location';

    /**
     * @var string $Location_X
     */
    public string $Location_X = '';

    /**
     * @var string $Location_Y
     */
    public string $Location_Y = '';

    /**
     * @var string $Scale
     */
    public string $Scale = '';

    /**
     * @var string $Label
     */
    public string $Label = '';

    /**
     * @var int $MsgId
     */
    public int $MsgId = 0;

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
    public function getLocationX(): string
    {
        return $this->Location_X;
    }

    /**
     * @param string $Location_X
     */
    public function setLocationX(string $Location_X): void
    {
        $this->Location_X = $Location_X;
    }

    /**
     * @return string
     */
    public function getLocationY(): string
    {
        return $this->Location_Y;
    }

    /**
     * @param string $Location_Y
     */
    public function setLocationY(string $Location_Y): void
    {
        $this->Location_Y = $Location_Y;
    }

    /**
     * @return string
     */
    public function getScale(): string
    {
        return $this->Scale;
    }

    /**
     * @param string $Scale
     */
    public function setScale(string $Scale): void
    {
        $this->Scale = $Scale;
    }

    /**
     * @return string
     */
    public function getLabel(): string
    {
        return $this->Label;
    }

    /**
     * @param string $Label
     */
    public function setLabel(string $Label): void
    {
        $this->Label = $Label;
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
     * @param int $CreateTime
     */
    public function setCreateTime(int $CreateTime): void
    {
        $this->CreateTime = $CreateTime;
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
}
