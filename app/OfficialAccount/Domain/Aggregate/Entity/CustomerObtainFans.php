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
 * 客服圈粉表
 * Class CustomerObtainFans
 *
 * @since 2.0
 *
 * @Entity(table="customer_obtain_fans")
 */
class CustomerObtainFans extends Model
{
    /**
     * 创建日期
     *
     * @Column(name="created_at", prop="createdAt")
     *
     * @var string
     */
    private $createdAt;

    /**
     * 微医生uuid
     *
     * @Column(name="customer_uuid", prop="customerUuid")
     *
     * @var string
     */
    private $customerId;

    /**
     * 部门uuid
     *
     * @Column(name="department_uuid", prop="departmentUuid")
     *
     * @var string|null
     */
    private $departmentUuid;

    /**
     *
     * @Id()
     * @Column()
     *
     * @var int
     */
    private $id;

    /**
     * 进粉方式(obtain:圈粉,offline离线自动分配)
     *
     * @Column(name="obtain_status", prop="obtainStatus")
     *
     * @var string|null
     */
    private $obtainStatus;

    /**
     *
     *
     * @Column()
     *
     * @var string
     */
    private $openid;

    /**
     * 速率(该组第n个进粉)
     *
     * @Column()
     *
     * @var int|null
     */
    private $rate;

    /**
     *
     *
     * @Column(name="service_uuid", prop="serviceUuid")
     *
     * @var string|null
     */
    private $platformId;

    /**
     * 更新日期
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
     * @param int $customerId
     *
     * @return self
     */
    public function setCustomerUuid(int $customerId): self
    {
        $this->customerUuid = $customerId;

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
     * @param string|null $obtainStatus
     *
     * @return self
     */
    public function setObtainStatus(?string $obtainStatus): self
    {
        $this->obtainStatus = $obtainStatus;

        return $this;
    }

    /**
     * @param string $openid
     *
     * @return self
     */
    public function setOpenid(string $openid): self
    {
        $this->openid = $openid;

        return $this;
    }

    /**
     * @param int|null $rate
     *
     * @return self
     */
    public function setRate(?int $rate): self
    {
        $this->rate = $rate;

        return $this;
    }

    /**
     * @param string|null $platformId
     *
     * @return self
     */
    public function setServiceUuid(?int $platformId): self
    {
        $this->serviceUuid = $platformId;

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
    public function getCreatedAt(): ?string
    {
        return $this->createdAt;
    }

    /**
     * @return string
     */
    public function getCustomerUuid(): ?string
    {
        return $this->customerUuid;
    }

    /**
     * @return string|null
     */
    public function getDepartmentUuid(): ?string
    {
        return $this->departmentUuid;
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
    public function getObtainStatus(): ?string
    {
        return $this->obtainStatus;
    }

    /**
     * @return string
     */
    public function getOpenid(): ?string
    {
        return $this->openid;
    }

    /**
     * @return int|null
     */
    public function getRate(): ?int
    {
        return $this->rate;
    }

    /**
     * @return string|null
     */
    public function getServiceUuid(): ?string
    {
        return $this->serviceUuid;
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
}
