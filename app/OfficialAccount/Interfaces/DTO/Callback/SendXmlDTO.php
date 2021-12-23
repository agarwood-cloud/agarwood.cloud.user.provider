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
class SendXmlDTO extends AbstractBaseDTO
{

    // 以下只是常用的部分字段，有些字符不完整的

    /**
     * @var string $ToUserName 接收方帐号（该公众号 ID）
     */
    protected string $ToUserName = '';

    /**
     * @var string $FromUserName 发送方帐号（OpenID, 代表用户的唯一标识）
     */
    protected string $FromUserName = '';

    /**
     * @var string|null $Event 事件类型 （如：subscribe(订阅)、unsubscribe(取消订阅) ...， CLICK 等）
     */
    protected ?string $Event = null;

    /**
     * @var int
     */
    protected int $CreateTime = 0;

    /**
     * @var int
     */
    protected int $MsgId = 0;

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
     * @return string|null
     */
    public function getEvent(): ?string
    {
        return $this->Event;
    }

    /**
     * @param string|null $Event
     */
    public function setEvent(?string $Event): void
    {
        $this->Event = $Event;
    }
}
