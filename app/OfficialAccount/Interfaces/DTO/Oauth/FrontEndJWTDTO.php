<?php declare(strict_types=1);
/**
 * This file is part of Agarwood Cloud.
 *
 * @link     https://www.agarwood-cloud.com
 * @document https://www.agarwood-cloud.com/docs
 * @contact  676786620@qq.com
 * @author   agarwood
 */

namespace App\OfficialAccount\Interfaces\DTO\Oauth;

use Agarwood\Core\Support\Impl\AbstractBaseDTO;
use Swoft\Validator\Annotation\Mapping\IsString;
use Swoft\Validator\Annotation\Mapping\NotEmpty;
use Swoft\Validator\Annotation\Mapping\Required;

/**
 * 前端获取jwt-token值
 *
 *
 * @\Swoft\Bean\Annotation\Mapping\Bean()
 * @\Swoft\Validator\Annotation\Mapping\Validator()
 *
 */
class FrontEndJWTDTO extends AbstractBaseDTO
{
    /**
     * @Required()
     * @IsString()
     * @NotEmpty()
     *
     * @var string|null
     */
    public ?string $token = '';

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
    public ?string $customer = null;

    /**
     * @IsString()
     *
     * @var string|null
     */
    public ?int $officialAccountId = null;

    /**
     * @IsString()
     *
     * @var string|null
     */
    public ?string $code = null;

    /**
     * 这里是 base64 之后的跳转链接
     *
     * @IsString()
     *
     * @var string|null
     */
    public ?string $state = null;

    /**
     * @Required()
     * @IsString()
     * @NotEmpty()
     *
     * @var string
     */
    public string $jwtToken = '';

    /**
     * @return string|null
     */
    public function getToken(): ?string
    {
        return $this->token;
    }

    /**
     * @param string|null $token
     */
    public function setToken(?string $token): void
    {
        $this->token = $token;
    }

    /**
     * @return string|null
     */
    public function getCode(): ?string
    {
        return $this->code;
    }

    /**
     * @param string|null $code
     */
    public function setCode(?string $code): void
    {
        $this->code = $code;
    }

    /**
     * @return string|null
     */
    public function getState(): ?string
    {
        return $this->state;
    }

    /**
     * @param string|null $state
     */
    public function setState(?string $state): void
    {
        $this->state = $state;
    }

    /**
     * @return string
     */
    public function getJwtToken(): string
    {
        return $this->jwtToken;
    }

    /**
     * @param string $jwtToken
     */
    public function setJwtToken(string $jwtToken): void
    {
        $this->jwtToken = $jwtToken;
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
    public function getServiceUuid(): ?string
    {
        return $this->serviceUuid;
    }

    /**
     * @param string|null $officialAccountId
     */
    public function setServiceUuid(?int $officialAccountId): void
    {
        $this->serviceUuid = $officialAccountId;
    }
}
