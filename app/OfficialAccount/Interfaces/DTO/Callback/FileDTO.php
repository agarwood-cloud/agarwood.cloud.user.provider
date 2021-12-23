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
class FileDTO extends AbstractBaseDTO
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
    public string $MsgType = 'file';

    /**
     * @var string $MsgType
     */
    public string $Title = '';

    /**
     * @var string
     */
    public string $Description = '';

    /**
     * @var string $FileKey
     */
    public string $FileKey = '';

    /**
     * @var string $FileMd5
     */
    public string $FileMd5 = '';

    /**
     * @var string $FileTotalLen
     */
    public string $FileTotalLen = '';

    /**
     * @var int $MsgId
     */
    public int $MsgId = 0;

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
    public function getTitle(): string
    {
        return $this->Title;
    }

    /**
     * @param string $Title
     */
    public function setTitle(string $Title): void
    {
        $this->Title = $Title;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->Description;
    }

    /**
     * @param string $Description
     */
    public function setDescription(string $Description): void
    {
        $this->Description = $Description;
    }

    /**
     * @return string
     */
    public function getFileKey(): string
    {
        return $this->FileKey;
    }

    /**
     * @param string $FileKey
     */
    public function setFileKey(string $FileKey): void
    {
        $this->FileKey = $FileKey;
    }

    /**
     * @return string
     */
    public function getFileMd5(): string
    {
        return $this->FileMd5;
    }

    /**
     * @param string $FileMd5
     */
    public function setFileMd5(string $FileMd5): void
    {
        $this->FileMd5 = $FileMd5;
    }

    /**
     * @return string
     */
    public function getFileTotalLen(): string
    {
        return $this->FileTotalLen;
    }

    /**
     * @param string $FileTotalLen
     */
    public function setFileTotalLen(string $FileTotalLen): void
    {
        $this->FileTotalLen = $FileTotalLen;
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
