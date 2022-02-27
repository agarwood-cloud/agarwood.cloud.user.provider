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
 * 客服表
 * Class Customer
 *
 * @since 2.0
 *
 * @Entity(table="customer")
 */
class Customer extends Model
{
    /**
     * 账号
     *
     * @Column()
     *
     * @var string
     */
    private string $account = '';

    /**
     * 创建时间
     *
     * @Column(name="created_at", prop="createdAt")
     *
     * @var string
     */
    private string $createdAt = '';

    /**
     * 删除时间
     *
     * @Column(name="deleted_at", prop="deletedAt")
     *
     * @var string
     */
    private string $deletedAt = '';

    /**
     * 所在分组名称
     *
     * @Column(name="group_name", prop="groupName")
     *
     * @var string
     */
    private string $groupName = '';

    /**
     * 分组ID
     *
     * @Column(name="group_uuid", prop="groupUuid")
     *
     * @var string
     */
    private string $groupUuid = '';

    /**
     *
     * @Id()
     * @Column()
     *
     * @var int
     */
    private int $id = 0;

    /**
     * 名称
     *
     * @Column()
     *
     * @var string
     */
    private $name;

    /**
     * 密码
     *
     * @Column(hidden=true)
     *
     * @var string
     */
    private $password;

    /**
     * 手机
     *
     * @Column()
     *
     * @var string
     */
    private $phone;

    /**
     * 服务号uuid
     *
     * @Column(name="service_uuid", prop="serviceUuid")
     *
     * @var string
     */
    private string $platformId = '';

    /**
     * 服务号uuid
     *
     * @Column(name="enterpriseId", prop="enterpriseId")
     *
     * @var string
     */
    private $enterpriseIdId;

    /**
     * usable:可用,disabled:不可用
     *
     * @Column()
     *
     * @var string
     */
    private $status;

    /**
     * 更新时间
     *
     * @Column(name="updated_at", prop="updatedAt")
     *
     * @var string
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
     * @param string $account
     *
     * @return self
     */
    public function setAccount(string $account): self
    {
        $this->account = $account;

        return $this;
    }

    /**
     * @param string $createdAt
     *
     * @return self
     */
    public function setCreatedAt(string $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * @param string $deletedAt
     *
     * @return self
     */
    public function setDeletedAt(string $deletedAt): self
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
     * @param string $groupUuid
     *
     * @return self
     */
    public function setGroupUuid(string $groupUuid): self
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
     * @param string $name
     *
     * @return self
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @param string $password
     *
     * @return self
     */
    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @param string $phone
     *
     * @return self
     */
    public function setPhone(string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * @param int $platformId
     *
     * @return self
     */
    public function setServiceUuid(int $platformId): self
    {
        $this->serviceUuid = $platformId;

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
     * @param string $updatedAt
     *
     * @return self
     */
    public function setUpdatedAt(string $updatedAt): self
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
    public function getAccount(): ?string
    {
        return $this->account;
    }

    /**
     * @return string
     */
    public function getCreatedAt(): ?string
    {
        return $this->createdAt;
    }

    /**
     * @return string
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
     * @return string
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
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    /**
     * @return string
     */
    public function getPhone(): ?string
    {
        return $this->phone;
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
     * @return string
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

    /**
     * @return string
     */
    public function getPlatformId(): string
    {
        return $this->PlatformId;
    }

    /**
     * @param string $platformId
     */
    public function setPlatformId(string $platformId): void
    {
        $this->PlatformId = $platformId;
    }

    /**
     * @return string
     */
    public function getEnterpriseId(): string
    {
        return $this->enterpriseId;
    }

    /**
     * @param string $enterpriseIdId
     */
    public function setEnterpriseId(string $enterpriseIdId): void
    {
        $this->enterpriseId = $enterpriseIdId;
    }
}
