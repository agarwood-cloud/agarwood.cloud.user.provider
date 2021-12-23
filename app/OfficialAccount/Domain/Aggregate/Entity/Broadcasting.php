<?php declare(strict_types=1);
/**
 * This file is part of Agarwood Cloud.
 *
 * @link     https://www.agarwood-cloud.com
 * @document https://www.agarwood-cloud.com/docs
 * @contact  676786620@qq.com
 * @author   agarwood
 */

namespace App\OfficialAccount\Domain\Aggregate\Entity;

use Swoft\Db\Annotation\Mapping\Column;
use Swoft\Db\Annotation\Mapping\Entity;
use Swoft\Db\Annotation\Mapping\Id;
use Swoft\Db\Eloquent\Model;

/**
 *
 * @since 2.0
 *
 * @Entity(table="broadcasting")
 */
class Broadcasting extends Model
{
    /**
     * 群发的链接
     *
     * @Column(name="article_url", prop="articleUrl")
     *
     * @var string
     */
    private $articleUrl;

    /**
     * 文本消息内容
     *
     * @Column()
     *
     * @var string
     */
    private $content;

    /**
     * 发送时间
     *
     * @Column(name="created_at", prop="createdAt")
     *
     * @var string|null
     */
    private $createdAt;

    /**
     * 发送失败的粉丝数
     *
     * @Column(name="error_count", prop="errorCount")
     *
     * @var int
     */
    private $errorCount;

    /**
     * 过滤后准备发送的粉丝数
     *
     * @Column(name="filter_count", prop="filterCount")
     *
     * @var int
     */
    private $filterCount;

    /**
     *
     *
     * @Column(name="group_name", prop="groupName")
     *
     * @var string
     */
    private $groupName;

    /**
     * 粉丝群组
     *
     * @Column(name="group_uuid", prop="groupUuid")
     *
     * @var string|null
     */
    private $groupUuid;

    /**
     *
     * @Id()
     * @Column()
     *
     * @var int
     */
    private $id;

    /**
     * 消息类型
     *
     * @Column(name="message_type", prop="messageType")
     *
     * @var string
     */
    private $messageType;

    /**
     *
     *
     * @Column(name="msg_id", prop="msgId")
     *
     * @var int
     */
    private $msgId;

    /**
     * 发送成功的粉丝数
     *
     * @Column(name="sent_count", prop="sentCount")
     *
     * @var int
     */
    private $sentCount;

    /**
     *
     *
     * @Column(name="service_uuid", prop="serviceUuid")
     *
     * @var string
     */
    private $officialAccountId;

    /**
     * 群发任务状态
     *
     * @Column()
     *
     * @var string
     */
    private $status;

    /**
     * 发送的人数
     *
     * @Column(name="total_count", prop="totalCount")
     *
     * @var int
     */
    private $totalCount;

    /**
     *
     *
     * @Column()
     *
     * @var string
     */
    private $uuid;

    /**
     * @param string $articleUrl
     *
     * @return self
     */
    public function setArticleUrl(string $articleUrl): self
    {
        $this->articleUrl = $articleUrl;

        return $this;
    }

    /**
     * @param string $content
     *
     * @return self
     */
    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    /**
     * @param string|null $createdAt
     *
     * @return self
     */
    public function setCreatedAt(?string $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * @param int $errorCount
     *
     * @return self
     */
    public function setErrorCount(int $errorCount): self
    {
        $this->errorCount = $errorCount;

        return $this;
    }

    /**
     * @param int $filterCount
     *
     * @return self
     */
    public function setFilterCount(int $filterCount): self
    {
        $this->filterCount = $filterCount;

        return $this;
    }

    /**
     * @param string $groupName
     *
     * @return self
     */
    public function setGroupName(string $groupName): self
    {
        $this->groupName = $groupName;

        return $this;
    }

    /**
     * @param string|null $groupUuid
     *
     * @return self
     */
    public function setGroupUuid(?string $groupUuid): self
    {
        $this->groupUuid = $groupUuid;

        return $this;
    }

    /**
     * @param int $id
     *
     * @return self
     */
    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @param string $messageType
     *
     * @return self
     */
    public function setMessageType(string $messageType): self
    {
        $this->messageType = $messageType;

        return $this;
    }

    /**
     * @param int $msgId
     *
     * @return self
     */
    public function setMsgId(int $msgId): self
    {
        $this->msgId = $msgId;

        return $this;
    }

    /**
     * @param int $sentCount
     *
     * @return self
     */
    public function setSentCount(int $sentCount): self
    {
        $this->sentCount = $sentCount;

        return $this;
    }

    /**
     * @param int $officialAccountId
     *
     * @return self
     */
    public function setServiceUuid(int $officialAccountId): self
    {
        $this->serviceUuid = $officialAccountId;

        return $this;
    }

    /**
     * @param string $status
     *
     * @return self
     */
    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @param int $totalCount
     *
     * @return self
     */
    public function setTotalCount(int $totalCount): self
    {
        $this->totalCount = $totalCount;

        return $this;
    }

    /**
     * @param string $uuid
     *
     * @return self
     */
    public function setUuid(string $uuid): self
    {
        $this->uuid = $uuid;

        return $this;
    }

    /**
     * @return string
     */
    public function getArticleUrl(): ?string
    {
        return $this->articleUrl;
    }

    /**
     * @return string
     */
    public function getContent(): ?string
    {
        return $this->content;
    }

    /**
     * @return string|null
     */
    public function getCreatedAt(): ?string
    {
        return $this->createdAt;
    }

    /**
     * @return int
     */
    public function getErrorCount(): ?int
    {
        return $this->errorCount;
    }

    /**
     * @return int
     */
    public function getFilterCount(): ?int
    {
        return $this->filterCount;
    }

    /**
     * @return string
     */
    public function getGroupName(): ?string
    {
        return $this->groupName;
    }

    /**
     * @return string|null
     */
    public function getGroupUuid(): ?string
    {
        return $this->groupUuid;
    }

    /**
     * @return int
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getMessageType(): ?string
    {
        return $this->messageType;
    }

    /**
     * @return int
     */
    public function getMsgId(): ?int
    {
        return $this->msgId;
    }

    /**
     * @return int
     */
    public function getSentCount(): ?int
    {
        return $this->sentCount;
    }

    /**
     * @return string
     */
    public function getServiceUuid(): ?string
    {
        return $this->serviceUuid;
    }

    /**
     * @return string
     */
    public function getStatus(): ?string
    {
        return $this->status;
    }

    /**
     * @return int|null
     */
    public function getTotalCount(): ?int
    {
        return $this->totalCount;
    }

    /**
     * @return string|null
     */
    public function getUuid(): ?string
    {
        return $this->uuid;
    }
}
