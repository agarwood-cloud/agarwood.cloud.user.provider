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
use Swoft\Validator\Annotation\Mapping\NotEmpty;
use Swoft\Validator\Annotation\Mapping\Required;
use Swoft\Validator\Annotation\Mapping\Validator;

/**
 * @Validator()
 */
class CreateDTO extends AbstractBaseDTO
{
    /**
     * 客服uuid
     *
     * @Required()
     * @NotEmpty()
     * @IsString()
     *
     * @var string
     */
    public string $customerId = '';

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
     * @Required()
     * @NotEmpty()
     * @IsInt()
     *
     * @var int
     */
    public int $fansPrice = 0;

    /**
     * usable:可用,disabled:不可用
     *
     * @Required()
     * @NotEmpty()
     * @IsString()
     * @Enum(values={"usable","disabled"})
     *
     * @var string
     */
    public string $status = 'usable';

    /**
     * 每日可分配粉丝
     *
     * @IsInt()
     *
     * @var int
     */
    public int $dayAssign = 0;

    /**
     * 每月可分配粉丝
     *
     * @IsInt()
     *
     * @var int
     */
    public int $monthAssign = 0;

    /**
     * @IsInt()
     *
     * @var int
     */
    public int $profitRate = 0;

    /**
     * 综合成本
     *
     * @IsInt()
     *
     * @var int
     */
    public int $cost = 0;

    /**
     * @return string
     */
    public function getCustomerId(): string
    {
        return $this->customerId;
    }

    /**
     * @param string $customerId
     */
    public function setCustomerId(string $customerId): void
    {
        $this->customerId = $customerId;
    }

    /**
     * @return int
     */
    public function getFansPrice(): int
    {
        return $this->fansPrice;
    }

    /**
     * @param int $fansPrice
     */
    public function setFansPrice(int $fansPrice): void
    {
        $this->fansPrice = $fansPrice;
    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * @param string $status
     */
    public function setStatus(string $status): void
    {
        $this->status = $status;
    }

    /**
     * @return int
     */
    public function getDayAssign(): int
    {
        return $this->dayAssign;
    }

    /**
     * @param int $dayAssign
     */
    public function setDayAssign(int $dayAssign): void
    {
        $this->dayAssign = $dayAssign;
    }

    /**
     * @return int
     */
    public function getMonthAssign(): int
    {
        return $this->monthAssign;
    }

    /**
     * @param int $monthAssign
     */
    public function setMonthAssign(int $monthAssign): void
    {
        $this->monthAssign = $monthAssign;
    }

    /**
     * @return int
     */
    public function getProfitRate(): int
    {
        return $this->profitRate;
    }

    /**
     * @param int $profitRate
     */
    public function setProfitRate(int $profitRate): void
    {
        $this->profitRate = $profitRate;
    }

    /**
     * @return int
     */
    public function getCost(): int
    {
        return $this->cost;
    }

    /**
     * @param int $cost
     */
    public function setCost(int $cost): void
    {
        $this->cost = $cost;
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
}
