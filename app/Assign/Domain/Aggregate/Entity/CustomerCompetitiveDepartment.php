<?php declare(strict_types=1);
/**
 * This file is part of Agarwood Cloud.
 *
 * @link     https://www.agarwood-cloud.com
 * @document https://www.agarwood-cloud.com/docs
 * @contact  676786620@qq.com
 * @author   agarwood
 */

namespace App\Assign\Domain\Aggregate\Entity;

use Swoft\Db\Annotation\Mapping\Column;
use Swoft\Db\Annotation\Mapping\Entity;
use Swoft\Db\Annotation\Mapping\Id;
use Swoft\Db\Eloquent\Model;

/**
 * 圈粉部门设置
 * Class CustomerCompetitiveDepartment
 *
 * @since 2.0
 *
 * @Entity(table="customer_competitive_department")
 */
class CustomerCompetitiveDepartment extends Model
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
     * 每日可分配
     *
     * @Column(name="day_assign", prop="dayAssign")
     *
     * @var int
     */
    private $dayAssign;

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
     * @Id()
     * @Column()
     *
     * @var int
     */
    private $id;

    /**
     * 负责人
     *
     * @Column()
     *
     * @var string
     */
    private $leader;

    /**
     *
     *
     * @Column(name="leader_uuid", prop="leaderUuid")
     *
     * @var string|null
     */
    private $leaderUuid;

    /**
     * 每月可分配
     *
     * @Column(name="month_assign", prop="monthAssign")
     *
     * @var int
     */
    private $monthAssign;

    /**
     * 进粉速率
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
    private $tencentId;

    /**
     * 排序
     *
     * @Column()
     *
     * @var int|null
     */
    private $sort;

    /**
     * 可圈粉状态(usable[可用] disabled[禁用])
     *
     * @Column()
     *
     * @var string
     */
    private $status;

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
     * @param int $dayAssign
     *
     * @return self
     */
    public function setDayAssign(int $dayAssign): self
    {
        $this->dayAssign = $dayAssign;

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
     * @param string $leader
     *
     * @return self
     */
    public function setLeader(string $leader): self
    {
        $this->leader = $leader;

        return $this;
    }

    /**
     * @param string|null $leaderUuid
     *
     * @return self
     */
    public function setLeaderUuid(?string $leaderUuid): self
    {
        $this->leaderUuid = $leaderUuid;

        return $this;
    }

    /**
     * @param int $monthAssign
     *
     * @return self
     */
    public function setMonthAssign(int $monthAssign): self
    {
        $this->monthAssign = $monthAssign;

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
     * @param int|null $sort
     *
     * @return self
     */
    public function setSort(?int $sort): self
    {
        $this->sort = $sort;

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
    public function getCreatedAt(): ?string
    {
        return $this->createdAt;
    }

    /**
     * @return int
     */
    public function getDayAssign(): ?int
    {
        return $this->dayAssign;
    }

    /**
     * @return string|null
     */
    public function getDepartment(): ?string
    {
        return $this->department;
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
    public function getLeader(): ?string
    {
        return $this->leader;
    }

    /**
     * @return string|null
     */
    public function getLeaderUuid(): ?string
    {
        return $this->leaderUuid;
    }

    /**
     * @return int
     */
    public function getMonthAssign(): ?int
    {
        return $this->monthAssign;
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
     * @return int|null
     */
    public function getSort(): ?int
    {
        return $this->sort;
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
}
