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
use Swoft\Validator\Annotation\Mapping\Min;
use Swoft\Validator\Annotation\Mapping\Validator;

/**
 * @Validator()
 */
class IndexDTO extends AbstractBaseDTO
{
    /**
     * 第 ${page} 页
     *
     * @IsInt(message="页码必须为整数")
     * @Min(value=1, message="页码最小值为1")
     *
     * @var int
     */
    public int $page = 1;

    /**
     * 每页共 ${perPage} 条记录
     *
     * 每页条数
     * @IsInt(message="每页条数必须为整数")
     * @Min(value=1, message="每页条数最小值为1")
     *
     * @var int
     */
    public int $perPage = 10;

    /**
     * @IsString()
     * @Enum(values={"usable","disabled"})
     *
     * @var string|null
     */
    public ?string $status = null;

    /**
     * @IsString()
     *
     *
     * @var string|null
     */
    public ?string $department = null;

    /**
     * @IsString()
     *
     * @var string|null
     */
    public ?string $leader = null;

    /**
     * @return int
     */
    public function getPage(): int
    {
        return $this->page;
    }

    /**
     * @param int $page
     */
    public function setPage(int $page): void
    {
        $this->page = $page;
    }

    /**
     * @return int
     */
    public function getPerPage(): int
    {
        return $this->perPage;
    }

    /**
     * @param int $perPage
     */
    public function setPerPage(int $perPage): void
    {
        $this->perPage = $perPage;
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
}
