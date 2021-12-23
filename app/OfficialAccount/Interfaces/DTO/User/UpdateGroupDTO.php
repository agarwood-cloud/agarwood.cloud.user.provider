<?php declare(strict_types=1);
/**
 * This file is part of Agarwood Cloud.
 *
 * @link     https://www.agarwood-cloud.com
 * @document https://www.agarwood-cloud.com/docs
 * @contact  676786620@qq.com
 * @author   agarwood
 */

namespace App\OfficialAccount\Interfaces\DTO\User;

use Agarwood\Core\Support\Impl\AbstractBaseDTO;
use Swoft\Validator\Annotation\Mapping\IsString;
use Swoft\Validator\Annotation\Mapping\Validator;

/**
 * @Validator()
 *
 */
class UpdateGroupDTO extends AbstractBaseDTO
{
    /**
     * @IsString()
     *
     * @var string|null
     */
    public ?string $customer = null;

    /**
     * @IsString()
     *
     * @var string|null
     */
    public ?int $customerId = null;

    /**
     * @IsString()
     *
     * @var string|null
     */
    public ?string $remark = null;

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
}
