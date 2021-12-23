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
class EventDTO extends AbstractBaseDTO
{
    /**
     * @var string $ToUserName 接收方帐号（该公众号 ID）
     */
    protected string $ToUserName = '';

    /**
     * @var string $FromUserName 发送方帐号（OpenID, 代表用户的唯一标识）
     */
    protected string $FromUserName = '';

    /**
     * @var int $CreateTime 消息创建时间（时间戳）
     */
    protected int $CreateTime = 0;

    /**
     * @var int $MsgId 消息 ID（64位整型）
     */
    protected int $MsgId = 0;

    /**
     * @var string $MsgType
     */
    protected string $MsgType = 'event';

    /**
     * @var string $Event 事件类型 （如：subscribe(订阅)、 unsubscribe(取消订阅) ...， CLICK 等）
     */
    protected string $Event = 'subscribe';

    /**
     * @var ?string $EventKey 事件KEY值，比如：qrscene_123123，qrscene_为前缀，后面为二维码的参数值
     *
     */
    protected ?string $EventKey = null;

    /**
     * @var ?string $Ticket 二维码的 ticket，可用来换取二维码图片
     */
    protected ?string $Ticket = null;

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
    public function getEvent(): string
    {
        return $this->Event;
    }

    /**
     * @param string $Event
     */
    public function setEvent(string $Event): void
    {
        $this->Event = $Event;
    }

    /**
     * @return ?string
     */
    public function getEventKey(): ?string
    {
        return $this->EventKey;
    }

    /**
     * @param ?string $EventKey
     */
    public function setEventKey(?string $EventKey): void
    {
        $this->EventKey = $EventKey;
    }

    /**
     * @return ?string
     */
    public function getTicket(): ?string
    {
        return $this->Ticket;
    }

    /**
     * @param ?string $Ticket
     */
    public function setTicket(?string $Ticket): void
    {
        $this->Ticket = $Ticket;
    }
}
