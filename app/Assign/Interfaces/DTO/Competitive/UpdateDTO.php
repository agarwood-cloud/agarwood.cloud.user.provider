<?php declare(strict_types=1);
/**
 * This file is part of Agarwood Cloud.
 *
 * @link     https://www.agarwood-cloud.com
 * @document https://www.agarwood-cloud.com/docs
 * @contact  676786620@qq.com
 * @author   agarwood
 */

namespace App\Assign\Interfaces\DTO\Competitive;

use Agarwood\Core\Support\Impl\AbstractBaseDTO;
use Swoft\Validator\Annotation\Mapping\Enum;
use Swoft\Validator\Annotation\Mapping\IsInt;
use Swoft\Validator\Annotation\Mapping\IsString;
use Swoft\Validator\Annotation\Mapping\Validator;

/**
 * @Validator()
 */
class UpdateDTO extends AbstractBaseDTO
{
    /**
     * 客服uuid
     *
     * @IsString()
     *
     * @var string|null
     */
    public ?string $customerId = null;

    /**
     * 自定义综合竞争力
     *
     * @IsInt()
     *
     * @var int|null
     */
    public ?int $customPower = null;

    /**
     * 粉丝单价
     *
     * @IsInt()
     *
     * @var int|null
     */
    public ?int $fansPrice = null;

    /**
     * usable:可用,disabled:不可用
     *
     * @IsString()
     * @Enum(values={"usable","disabled"})
     *
     * @var string|null
     */
    public ?string $status = 'usable';

    /**
     * 每日可分配粉丝
     *
     * @IsInt()
     *
     * @var int|null
     */
    public ?int $dayAssign = null;

    /**
     * @IsInt()
     *
     * @var int|null
     *
     */
    public ?int $profitRate = null;

    /**
     * 综合成本
     *
     * @IsInt()
     *
     * @var int|null
     */
    public ?int $cost = null;

    /**
     * 每月可分配粉丝
     *
     * @IsInt()
     *
     * @var int|null
     */
    public ?int $monthAssign = null;

    /**
     * 基础抢粉数
     *
     * @\Swoft\Validator\Annotation\Mapping\IsInt()
     *
     * @var int|null
     */
    public ?int $baseFans = null;

    /**
     * @return string|null
     */
    public function getCustomerId(): ?string
    {
        return $this->customerId;
    }

    /**
     * @param string|null $customerId
     */
    public function setCustomerId(?string $customerId): void
    {
        $this->customerId = $customerId;
    }

    /**
     * @return int|null
     */
    public function getCustomPower(): ?int
    {
        return $this->customPower;
    }

    /**
     * @param int|null $customPower
     */
    public function setCustomPower(?int $customPower): void
    {
        $this->customPower = $customPower;
    }

    /**
     * @return int|null
     */
    public function getFansPrice(): ?int
    {
        return $this->fansPrice;
    }

    /**
     * @param int|null $fansPrice
     */
    public function setFansPrice(?int $fansPrice): void
    {
        $this->fansPrice = $fansPrice;
    }

    /**
     * @return string|null
     */
    public function getStatus(): ?string
    {
        return $this->status;
    }

    /**
     * @param string|null $status
     */
    public function setStatus(?string $status): void
    {
        $this->status = $status;
    }

    /**
     * @return int|null
     */
    public function getDayAssign(): ?int
    {
        return $this->dayAssign;
    }

    /**
     * @param int|null $dayAssign
     */
    public function setDayAssign(?int $dayAssign): void
    {
        $this->dayAssign = $dayAssign;
    }

    /**
     * @return int|null
     */
    public function getMonthAssign(): ?int
    {
        return $this->monthAssign;
    }

    /**
     * @param int|null $monthAssign
     */
    public function setMonthAssign(?int $monthAssign): void
    {
        $this->monthAssign = $monthAssign;
    }

    /**
     * @return int|null
     */
    public function getProfitRate(): ?int
    {
        return $this->profitRate;
    }

    /**
     * @param int|null $profitRate
     */
    public function setProfitRate(?int $profitRate): void
    {
        $this->profitRate = $profitRate;
    }

    /**
     * @return int|null
     */
    public function getCost(): ?int
    {
        return $this->cost;
    }

    /**
     * @param int|null $cost
     */
    public function setCost(?int $cost): void
    {
        $this->cost = $cost;
    }

    /**
     * @return int|null
     */
    public function getBaseFans(): ?int
    {
        return $this->baseFans;
    }

    /**
     * @param int|null $baseFans
     */
    public function setBaseFans(?int $baseFans): void
    {
        $this->baseFans = $baseFans;
    }
}
