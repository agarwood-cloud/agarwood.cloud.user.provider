<?php declare(strict_types=1);
/**
 * This file is part of Agarwood Cloud.
 *
 * @link     https://www.agarwood-cloud.com
 * @document https://www.agarwood-cloud.com/docs
 * @contact  676786620@qq.com
 * @author   agarwood
 */

namespace App\Customer\Interfaces\DTO\Group;

use Agarwood\Core\Constant\StringConstant;
use Agarwood\Core\Support\Impl\AbstractBaseDTO;
use Swoft\Validator\Annotation\Mapping\IsString;
use Swoft\Validator\Annotation\Mapping\NotEmpty;
use Swoft\Validator\Annotation\Mapping\Required;
use Swoft\Validator\Annotation\Mapping\Validator;

/**
 * @Validator()
 */
class CustomerGroupCreateDTO extends AbstractBaseDTO
{
    /**
     *
     * @var string
     */
    protected string $deletedAt = StringConstant::DATE_TIME_DEFAULT;

    /**
     * 服务号 uuid
     *
     * @Required()
     * @IsString()
     *
     * @var string
     */
    public int $officialAccountId = 0;

    /**
     * 分组名称
     *
     * @Required()
     * @IsString()
     * @NotEmpty()
     *
     * @var string
     */
    protected string $groupName = '';

    /**
     * 备注
     *
     * @IsString()
     *
     * @var string
     */
    protected string $remark = '';

    /**
     * 部门
     *
     * @IsString()
     *
     * @var string
     */
    protected string $department = '';

    /**
     * 部门uuid
     *
     * @IsString()
     *
     * @var string
     */
    protected string $departmentUuid = '';

    /**
     * 父类UUID
     * @IsString()
     *
     * @var string|null
     */
    protected ?string $pUuid = '';

    /**
     * 父类分组名
     *
     * @IsString()
     *
     * @var string|null
     */
    protected ?string $pGroupName = '';

    /**
     * @return string
     */
    public function getDeletedAt(): string
    {
        return $this->deletedAt;
    }

    /**
     * @param string $deletedAt
     */
    public function setDeletedAt(string $deletedAt): void
    {
        $this->deletedAt = $deletedAt;
    }

    /**
     * @return string
     */
    public function getServiceUuid(): string
    {
        return $this->serviceUuid;
    }

    /**
     * @param int $officialAccountId
     */
    public function setServiceUuid(int $officialAccountId): void
    {
        $this->serviceUuid = $officialAccountId;
    }

    /**
     * @return string
     */
    public function getGroupName(): string
    {
        return $this->groupName;
    }

    /**
     * @param string $groupName
     */
    public function setGroupName(string $groupName): void
    {
        $this->groupName = $groupName;
    }

    /**
     * @return string
     */
    public function getRemark(): string
    {
        return $this->remark;
    }

    /**
     * @param string $remark
     */
    public function setRemark(string $remark): void
    {
        $this->remark = $remark;
    }

    /**
     * @return string|null
     */
    public function getPUuid(): ?string
    {
        return $this->pUuid;
    }

    /**
     * @param string|null $pUuid
     */
    public function setPUuid(?string $pUuid): void
    {
        $this->pUuid = $pUuid;
    }

    /**
     * @return string|null
     */
    public function getPGroupName(): ?string
    {
        return $this->pGroupName;
    }

    /**
     * @param string|null $pGroupName
     */
    public function setPGroupName(?string $pGroupName): void
    {
        $this->pGroupName = $pGroupName;
    }

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
    public function getDepartmentUuid(): string
    {
        return $this->departmentUuid;
    }

    /**
     * @param string $departmentUuid
     */
    public function setDepartmentUuid(string $departmentUuid): void
    {
        $this->departmentUuid = $departmentUuid;
    }
}
