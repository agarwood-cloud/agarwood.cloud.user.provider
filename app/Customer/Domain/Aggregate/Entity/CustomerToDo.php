<?php declare(strict_types=1);
/**
 * This file is part of Agarwood Cloud.
 *
 * @link     https://www.agarwood-cloud.com
 * @document https://www.agarwood-cloud.com/docs
 * @contact  676786620@qq.com
 * @author   agarwood
 */

namespace App\Customer\Domain\Aggregate\Entity;

use Swoft\Db\Annotation\Mapping\Column;
use Swoft\Db\Annotation\Mapping\Entity;
use Swoft\Db\Annotation\Mapping\Id;
use Swoft\Db\Eloquent\Model;

/**
 * 工作空间
 * Class CustomerToDo
 *
 * @since 2.0
 *
 * @Entity(table="customer_to_do")
 */
class CustomerToDo extends Model
{
    /**
     * 待办内容
     *
     * @Column()
     *
     * @var string
     */
    private $content;

    /**
     *
     *
     * @Column(name="created_at", prop="createdAt")
     *
     * @var string|null
     */
    private $createdAt;

    /**
     *
     *
     * @Column(name="customer_uuid", prop="customerUuid")
     *
     * @var string|null
     */
    private $customerUuid;

    /**
     * 截止时间
     *
     * @Column(name="deadline_at", prop="deadlineAt")
     *
     * @var string|null
     */
    private $deadlineAt;

    /**
     *
     *
     * @Column(name="deleted_at", prop="deletedAt")
     *
     * @var string|null
     */
    private $deletedAt;

    /**
     *
     * @Id()
     * @Column()
     *
     * @var int
     */
    private $id;

    /**
     * 粉丝昵称
     *
     * @Column()
     *
     * @var string|null
     */
    private $nickname;

    /**
     * 关联的粉丝openid
     *
     * @Column()
     *
     * @var string|null
     */
    private $openid;

    /**
     * 备注
     *
     * @Column()
     *
     * @var string|null
     */
    private $remark;

    /**
     *
     *
     * @Column(name="service_uuid", prop="serviceUuid")
     *
     * @var string|null
     */
    private $tencentId;

    /**
     * 状态[todo:待办,doing:正在处理,finish:处理完成]
     *
     * @Column()
     *
     * @var string|null
     */
    private $status;

    /**
     *
     *
     * @Column(name="updated_at", prop="updatedAt")
     *
     * @var string|null
     */
    private $updatedAt;

    /**
     *
     *
     * @Column()
     *
     * @var string
     */
    private $uuid;

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
     * @param string|null $customerUuid
     *
     * @return self
     */
    public function setCustomerUuid(?int $customerId): self
    {
        $this->customerUuid = $customerUuid;

        return $this;
    }

    /**
     * @param string|null $deadlineAt
     *
     * @return self
     */
    public function setDeadlineAt(?string $deadlineAt): self
    {
        $this->deadlineAt = $deadlineAt;

        return $this;
    }

    /**
     * @param string|null $deletedAt
     *
     * @return self
     */
    public function setDeletedAt(?string $deletedAt): self
    {
        $this->deletedAt = $deletedAt;

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
     * @param string|null $nickname
     *
     * @return self
     */
    public function setNickname(?string $nickname): self
    {
        $this->nickname = $nickname;

        return $this;
    }

    /**
     * @param string|null $openid
     *
     * @return self
     */
    public function setOpenid(?string $openid): self
    {
        $this->openid = $openid;

        return $this;
    }

    /**
     * @param string|null $remark
     *
     * @return self
     */
    public function setRemark(?string $remark): self
    {
        $this->remark = $remark;

        return $this;
    }

    /**
     * @param string|null $tencentId
     *
     * @return self
     */
    public function setServiceUuid(?int $tencentId): self
    {
        $this->serviceUuid = $tencentId;

        return $this;
    }

    /**
     * @param string|null $status
     *
     * @return self
     */
    public function setStatus(?string $status): self
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @param string|null $updatedAt
     *
     * @return self
     */
    public function setUpdatedAt(?string $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

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
     * @return string|null
     */
    public function getCustomerUuid(): ?string
    {
        return $this->customerUuid;
    }

    /**
     * @return string|null
     */
    public function getDeadlineAt(): ?string
    {
        return $this->deadlineAt;
    }

    /**
     * @return string|null
     */
    public function getDeletedAt(): ?string
    {
        return $this->deletedAt;
    }

    /**
     * @return int
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getNickname(): ?string
    {
        return $this->nickname;
    }

    /**
     * @return string|null
     */
    public function getOpenid(): ?string
    {
        return $this->openid;
    }

    /**
     * @return string|null
     */
    public function getRemark(): ?string
    {
        return $this->remark;
    }

    /**
     * @return string|null
     */
    public function getServiceUuid(): ?string
    {
        return $this->serviceUuid;
    }

    /**
     * @return string|null
     */
    public function getStatus(): ?string
    {
        return $this->status;
    }

    /**
     * @return string|null
     */
    public function getUpdatedAt(): ?string
    {
        return $this->updatedAt;
    }

    /**
     * @return string
     */
    public function getUuid(): ?string
    {
        return $this->uuid;
    }
}
