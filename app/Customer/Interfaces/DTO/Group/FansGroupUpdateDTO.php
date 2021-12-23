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

use Agarwood\Core\Support\Impl\AbstractBaseDTO;
use Swoft\Validator\Annotation\Mapping\IsString;
use Swoft\Validator\Annotation\Mapping\Validator;

/**
 * @Validator()
 */
class FansGroupUpdateDTO extends AbstractBaseDTO
{
    /**
     * 父类UUID
     * @IsString()
     *
     * @var string|null
     */
    protected ?string $pUuid = null;

    /**
     * 分组名称
     *
     * @IsString()
     *
     * @var string|null
     */
    protected ?string $groupName = null;

    /**
     * 备注
     * @IsString()
     *
     * @var string|null
     */
    protected ?string $remark = null;

    /**
     * 父类分组名
     * @IsString()
     *
     * @var string|null
     */
    protected ?string $pGroupName = null;

    /**
     * @IsString()
     *
     * @var string|null
     */
    protected ?string $customer = null;

    /**
     * @IsString()
     *
     * @var string|null
     */
    protected ?int $customerId = null;

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
    public function getPGroupName(): ?string
    {
        return $this->pGroupName;
    }

    /**
     * @return string|null
     */
    public function getGroupName(): ?string
    {
        return $this->groupName;
    }

    /**
     * @param string|null $groupName
     */
    public function setGroupName(?string $groupName): void
    {
        $this->groupName = $groupName;
    }

    /**
     * @return string|null
     */
    public function getCustomer(): ?string
    {
        return $this->customer;
    }

    /**
     * @param string|null $customer
     */
    public function setCustomer(?string $customer): void
    {
        $this->customer = $customer;
    }

    /**
     * @return string|null
     */
    public function getCustomerUuid(): ?string
    {
        return $this->customerUuid;
    }

    /**
     * @param string|null $customerUuid
     */
    public function setCustomerUuid(?int $customerId): void
    {
        $this->customerUuid = $customerUuid;
    }
}
