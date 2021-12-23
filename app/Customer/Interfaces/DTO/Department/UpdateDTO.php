<?php declare(strict_types=1);
/**
 * This file is part of Agarwood Cloud.
 *
 * @link     https://www.agarwood-cloud.com
 * @document https://www.agarwood-cloud.com/docs
 * @contact  676786620@qq.com
 * @author   agarwood
 */

namespace App\Customer\Interfaces\DTO\Department;

use Agarwood\Core\Support\Impl\AbstractBaseDTO;
use Swoft\Validator\Annotation\Mapping\IsInt;
use Swoft\Validator\Annotation\Mapping\IsString;
use Swoft\Validator\Annotation\Mapping\Validator;

/**
 * @Validator()
 */
class UpdateDTO extends AbstractBaseDTO
{
    /**
     * 部门
     *
     * @IsString()
     *
     * @var string|null
     */
    public ?string $department = null;

    /**
     * 每日可分配粉丝
     *
     * @IsInt()
     *
     * @var int|null
     */
    public ?int $dayAssign = null;

    /**
     * 每月可分配粉丝
     *
     * @Required()
     * @IsInt()
     *
     * @var int|null
     */
    public ?int $monthAssign = null;

    /**
     * 进粉速率
     *
     * @Required()
     * @IsInt()
     *
     * @var int|null
     */
    public ?int $rate = null;

    /**
     * 排序
     *
     * @Required()
     * @IsInt()
     *
     * @var int|null
     */
    public ?int $sort = null;

    /**
     * @IsString()
     *
     * @var string|null
     */
    public ?string $leader = null;

    /**
     * @IsString()
     *
     * @var string|null
     */
    public ?string $leaderUuid = null;

    /**
     * @return string|null
     */
    public function getDepartment(): ?string
    {
        return $this->department;
    }

    /**
     * @param string|null $department
     */
    public function setDepartment(?string $department): void
    {
        $this->department = $department;
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
    public function getRate(): ?int
    {
        return $this->rate;
    }

    /**
     * @param int|null $rote
     */
    public function setRate(?int $rote): void
    {
        $this->rate = $rote;
    }

    /**
     * @return int|null
     */
    public function getSort(): ?int
    {
        return $this->sort;
    }

    /**
     * @param int|null $sort
     */
    public function setSort(?int $sort): void
    {
        $this->sort = $sort;
    }

    /**
     * @return string|null
     */
    public function getLeader(): ?string
    {
        return $this->leader;
    }

    /**
     * @param string|null $leader
     */
    public function setLeader(?string $leader): void
    {
        $this->leader = $leader;
    }

    /**
     * @return string|null
     */
    public function getLeaderUuid(): ?string
    {
        return $this->leaderUuid;
    }

    /**
     * @param string|null $leaderUuid
     */
    public function setLeaderUuid(?string $leaderUuid): void
    {
        $this->leaderUuid = $leaderUuid;
    }
}
