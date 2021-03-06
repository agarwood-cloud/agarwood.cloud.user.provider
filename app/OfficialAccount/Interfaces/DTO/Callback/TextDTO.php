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
class TextDTO extends AbstractBaseDTO
{
    /**
     * @var string $ToUserName appid
     */
    protected string $ToUserName = ''; // 接收方的appid（该公众号 ID）

    /**
     * @var string $FromUserName openid
     */
    protected string $FromUserName = ''; // 发送方的openid（OpenID, 代表用户的唯一标识）

    /**
     * @var int $CreateTime
     */
    protected int $CreateTime = 0; // 消息创建时间（时间戳）

    /**
     * @var int $MsgId
     */
    protected int $MsgId = 0; // 消息 ID（64位整型）

    /**
     * @var string $MsgType
     */
    protected string $MsgType = 'text'; // text

    /**
     * @var string $Content
     */
    protected string $Content = '';

    /**
     * @var string $Encrypt
     */
    protected string $Encrypt = '';

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
    public function getContent(): string
    {
        return $this->Content;
    }

    /**
     * @param string $Content
     */
    public function setContent(string $Content): void
    {
        $this->Content = $Content;
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
}
