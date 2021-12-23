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
class FansGroupCreateDTO extends AbstractBaseDTO
{
    /**
     * @IsString()
     *
     * @var string
     */
    public int $officialAccountId = 0;

    /**
     * 父类UUID
     * @IsString()
     *
     * @var string|null
     */
    protected ?string $pUuid = '';

    /**
     * 所属客服
     *
     * @Required()
     * @IsString()
     *
     * @var int
     */
    protected int $customerId = 0;

    /**
     * 所属客服
     *
     * @Required()
     * @IsString()
     *
     * @var string
     */
    protected string $customer = '';

    /**
     *
     * @var string|null
     */
    protected ?string $deletedAt = StringConstant::DATE_TIME_DEFAULT;

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
     * @var string|null
     */
    protected ?string $remark = null;

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
     * @return string
     */
    public function getCustomerUuid(): string
    {
        return $this->customerUuid;
    }

    /**
     * @param int $customerId
     */
    public function setCustomerUuid(int $customerId): void
    {
        $this->customerUuid = $customerId;
    }

    /**
     * @return string
     */
    public function getCustomer(): string
    {
        return $this->customer;
    }

    /**
     * @param string $customer
     */
    public function setCustomer(string $customer): void
    {
        $this->customer = $customer;
    }

    /**
     * @return string|null
     */
    public function getDeletedAt(): ?string
    {
        return $this->deletedAt;
    }

    /**
     * @param string|null $deletedAt
     */
    public function setDeletedAt(?string $deletedAt): void
    {
        $this->deletedAt = $deletedAt;
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
     * @return string|null
     */
    public function getRemark(): ?string
    {
        return $this->remark;
    }

    /**
     * @param string|null $remark
     */
    public function setRemark(?string $remark): void
    {
        $this->remark = $remark;
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
}
