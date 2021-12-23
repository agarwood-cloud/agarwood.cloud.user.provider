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
     * 部门
     *
     * @Required()
     * @NotEmpty()
     * @IsString()
     *
     * @var string
     */
    public string $department = '';

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
     * @Required()
     * @NotEmpty()
     * @IsInt()
     *
     * @var int
     */
    public int $dayAssign = 0;

    /**
     * 每月可分配粉丝
     *
     * @Required()
     * @NotEmpty()
     * @IsInt()
     *
     * @var int
     */
    public int $monthAssign = 0;

    /**
     * 进粉速率
     *
     * @Required()
     * @NotEmpty()
     * @IsInt()
     *
     * @var int
     */
    public int $rate = 0;

    /**
     * 排序
     *
     * @Required()
     * @NotEmpty()
     * @IsInt()
     *
     * @var int
     */
    public int $sort = 0;

    /**
     * @IsString()
     *
     * @var string
     */
    public string $leader = '';

    /**
     * @IsString()
     *
     * @var string
     */
    public string $leaderUuid = '';

    /**
     * @return string
     */
    public function getDepartment(): string
    {
        return $this->department;
    }

    /**
     * @param string $department
     */
    public function setDepartment(string $department): void
    {
        $this->department = $department;
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
    public function getRate(): int
    {
        return $this->rate;
    }

    /**
     * @param int $rote
     */
    public function setRate(int $rote): void
    {
        $this->rate = $rote;
    }

    /**
     * @return int
     */
    public function getSort(): int
    {
        return $this->sort;
    }

    /**
     * @param int $sort
     */
    public function setSort(int $sort): void
    {
        $this->sort = $sort;
    }

    /**
     * @return string
     */
    public function getLeader(): string
    {
        return $this->leader;
    }

    /**
     * @param string $leader
     */
    public function setLeader(string $leader): void
    {
        $this->leader = $leader;
    }

    /**
     * @return string
     */
    public function getLeaderUuid(): string
    {
        return $this->leaderUuid;
    }

    /**
     * @param string $leaderUuid
     */
    public function setLeaderUuid(string $leaderUuid): void
    {
        $this->leaderUuid = $leaderUuid;
    }
}
