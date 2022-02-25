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
 * Class CustomerGroup
 *
 * @since 2.0
 *
 * @Entity(table="customer_group")
 */
class CustomerGroup extends Model
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
     *
     *
     * @Column(name="deleted_at", prop="deletedAt")
     *
     * @var string|null
     */
    private $deletedAt;

    /**
     * 部门
     *
     * @Column()
     *
     * @var string|null
     */
    private $department;

    /**
     *
     *
     * @Column(name="department_uuid", prop="departmentUuid")
     *
     * @var string|null
     */
    private $departmentUuid;

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
    private $tencentId;

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
     * @param string|null $department
     *
     * @return self
     */
    public function setDepartment(?string $department): self
    {
        $this->department = $department;

        return $this;
    }

    /**
     * @param string|null $departmentUuid
     *
     * @return self
     */
    public function setDepartmentUuid(?string $departmentUuid): self
    {
        $this->departmentUuid = $departmentUuid;

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
    public function getDeletedAt(): ?string
    {
        return $this->deletedAt;
    }

    /**
     * @return string|null
     */
    public function getDepartment(): ?string
    {
        return $this->department;
    }

    /**
     * @return string|null
     */
    public function getDepartmentUuid(): ?string
    {
        return $this->departmentUuid;
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
