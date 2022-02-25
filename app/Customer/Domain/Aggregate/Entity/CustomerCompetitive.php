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
 * 客服圈粉表
 * Class CustomerCompetitive
 *
 * @since 2.0
 *
 * @Entity(table="customer_competitive")
 */
class CustomerCompetitive extends Model
{
    /**
     * 基础抢粉数
     *
     * @Column(name="base_fans", prop="baseFans")
     *
     * @var int|null
     */
    private $baseFans;

    /**
     * 综合成本
     *
     * @Column()
     *
     * @var int|null
     */
    private $cost;

    /**
     * 创建日期
     *
     * @Column(name="created_at", prop="createdAt")
     *
     * @var string
     */
    private $createdAt;

    /**
     * 自定义综合竞争力
     *
     * @Column(name="custom_power", prop="customPower")
     *
     * @var int|null
     */
    private $customPower;

    /**
     * 微医生uuid
     *
     * @Column(name="customer_uuid", prop="customerUuid")
     *
     * @var string
     */
    private $customerUuid;

    /**
     * 每日可分配
     *
     * @Column(name="day_assign", prop="dayAssign")
     *
     * @var int
     */
    private $dayAssign;

    /**
     * 粉丝单价
     *
     * @Column(name="fans_price", prop="fansPrice")
     *
     * @var int
     */
    private $fansPrice;

    /**
     *
     * @Id()
     * @Column()
     *
     * @var int
     */
    private $id;

    /**
     * 每月可分配
     *
     * @Column(name="month_assign", prop="monthAssign")
     *
     * @var int
     */
    private $monthAssign;

    /**
     * 综合竞争力
     *
     * @Column()
     *
     * @var int
     */
    private $power;

    /**
     * 盈利比例%
     *
     * @Column(name="profit_rate", prop="profitRate")
     *
     * @var int|null
     */
    private $profitRate;

    /**
     *
     *
     * @Column(name="service_uuid", prop="serviceUuid")
     *
     * @var string|null
     */
    private $tencentId;

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
     * @param int|null $baseFans
     *
     * @return self
     */
    public function setBaseFans(?int $baseFans): self
    {
        $this->baseFans = $baseFans;

        return $this;
    }

    /**
     * @param int|null $cost
     *
     * @return self
     */
    public function setCost(?int $cost): self
    {
        $this->cost = $cost;

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
     * @param int|null $customPower
     *
     * @return self
     */
    public function setCustomPower(?int $customPower): self
    {
        $this->customPower = $customPower;

        return $this;
    }

    /**
     * @param int $customerId
     *
     * @return self
     */
    public function setCustomerUuid(int $customerId): self
    {
        $this->customerUuid = $customerUuid;

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
     * @param int $fansPrice
     *
     * @return self
     */
    public function setFansPrice(int $fansPrice): self
    {
        $this->fansPrice = $fansPrice;

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
     * @param int $power
     *
     * @return self
     */
    public function setPower(int $power): self
    {
        $this->power = $power;

        return $this;
    }

    /**
     * @param int|null $profitRate
     *
     * @return self
     */
    public function setProfitRate(?int $profitRate): self
    {
        $this->profitRate = $profitRate;

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
     * @return int|null
     */
    public function getBaseFans(): ?int
    {
        return $this->baseFans;
    }

    /**
     * @return int|null
     */
    public function getCost(): ?int
    {
        return $this->cost;
    }

    /**
     * @return string
     */
    public function getCreatedAt(): ?string
    {
        return $this->createdAt;
    }

    /**
     * @return int|null
     */
    public function getCustomPower(): ?int
    {
        return $this->customPower;
    }

    /**
     * @return string
     */
    public function getCustomerUuid(): ?string
    {
        return $this->customerUuid;
    }

    /**
     * @return int
     */
    public function getDayAssign(): ?int
    {
        return $this->dayAssign;
    }

    /**
     * @return int
     */
    public function getFansPrice(): ?int
    {
        return $this->fansPrice;
    }

    /**
     * @return int
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getMonthAssign(): ?int
    {
        return $this->monthAssign;
    }

    /**
     * @return int
     */
    public function getPower(): ?int
    {
        return $this->power;
    }

    /**
     * @return int|null
     */
    public function getProfitRate(): ?int
    {
        return $this->profitRate;
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
