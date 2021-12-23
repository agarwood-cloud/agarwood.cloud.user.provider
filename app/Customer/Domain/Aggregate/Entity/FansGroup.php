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
 *
 * Class FansGroup
 *
 * @since 2.0
 *
 * @Entity(table="fans_group")
 */
class FansGroup extends Model
{
    /**
     * 创建时间
     *
     * @Column(name="created_at", prop="createdAt")
     *
     * @var string|null
     */
    private $createdAt;

    /**
     * 客服
     *
     * @Column()
     *
     * @var string|null
     */
    private $customer;

    /**
     * 客服uuid
     *
     * @Column(name="customer_uuid", prop="customerUuid")
     *
     * @var string|null
     */
    private $customerId;

    /**
     *
     *
     * @Column(name="deleted_at", prop="deletedAt")
     *
     * @var string|null
     */
    private $deletedAt;

    /**
     * 分组名称
     *
     * @Column(name="group_name", prop="groupName")
     *
     * @var string|null
     */
    private $groupName;

    /**
     *
     * @Id()
     * @Column()
     *
     * @var int
     */
    private $id;

    /**
     * 父类分组名
     *
     * @Column(name="p_group_name", prop="pGroupName")
     *
     * @var string|null
     */
    private $pGroupName;

    /**
     * 父类UUID
     *
     * @Column(name="p_uuid", prop="pUuid")
     *
     * @var string|null
     */
    private $pUuid;

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
    private $officialAccountId;

    /**
     * 更新时间
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
     * @param string|null $customer
     *
     * @return self
     */
    public function setCustomer(?string $customer): self
    {
        $this->customer = $customer;

        return $this;
    }

    /**
     * @param string|null $customerId
     *
     * @return self
     */
    public function setCustomerUuid(?int $customerId): self
    {
        $this->customerUuid = $customerId;

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
     * @param string|null $groupName
     *
     * @return self
     */
    public function setGroupName(?string $groupName): self
    {
        $this->groupName = $groupName;

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
     * @param string|null $pGroupName
     *
     * @return self
     */
    public function setPGroupName(?string $pGroupName): self
    {
        $this->pGroupName = $pGroupName;

        return $this;
    }

    /**
     * @param string|null $pUuid
     *
     * @return self
     */
    public function setPUuid(?string $pUuid): self
    {
        $this->pUuid = $pUuid;

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
     * @param string|null $officialAccountId
     *
     * @return self
     */
    public function setServiceUuid(?int $officialAccountId): self
    {
        $this->serviceUuid = $officialAccountId;

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
     * @return string|null
     */
    public function getCreatedAt(): ?string
    {
        return $this->createdAt;
    }

    /**
     * @return string|null
     */
    public function getCustomer(): ?string
    {
        return $this->customer;
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
    public function getDeletedAt(): ?string
    {
        return $this->deletedAt;
    }

    /**
     * @return string|null
     */
    public function getGroupName(): ?string
    {
        return $this->groupName;
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
    public function getPGroupName(): ?string
    {
        return $this->pGroupName;
    }

    /**
     * @return string|null
     */
    public function getPUuid(): ?string
    {
        return $this->pUuid;
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
