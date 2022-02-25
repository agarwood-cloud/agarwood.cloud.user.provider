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
use Swoft\Validator\Annotation\Mapping\Validator;

/**
 * 微信授权回调信息
 *
 * @Validator()
 *
 */
class WeChatDTO extends AbstractBaseDTO
{
    /**
     * @Required()
     * @IsString()
     * @NotEmpty()
     *
     * @var string
     */
    public string $code = '';

    /**
     * 这里是 base64 之后的跳转链接
     *
     * @Required()
     * @IsString()
     * @NotEmpty()
     *
     * @var string
     */
    public string $state = '';

    /**
     * 服务号的 token 值
     *
     * @Required()
     * @IsString()
     * @NotEmpty()
     *
     * @var string
     */
    public string $token = '';

    /**
     * 链接里面可以直接带上 customerUuid 标记来来那个客服的分享
     *
     * @var int
     */
    public int $customerId = 0;

    /**
     * 链接里面可以直接带上 customer 标记来来那个客服的分享
     *
     * @var string
     */
    public string $customer = '';

    /**
     * 链接里面可以直接带上 serviceUuid 标记来来那个客服的分享
     *
     * @var int
     */
    public int $platformId = 0;

    /**
     * @return string
     */
    public function getCode(): string
    {
        return $this->code;
    }

    /**
     * @param string $code
     */
    public function setCode(string $code): void
    {
        $this->code = $code;
    }

    /**
     * @return string
     */
    public function getState(): string
    {
        return $this->state;
    }

    /**
     * @param string $state
     */
    public function setState(string $state): void
    {
        $this->state = $state;
    }

    /**
     * @return string
     */
    public function getToken(): string
    {
        return $this->token;
    }

    /**
     * @param string $token
     */
    public function setToken(string $token): void
    {
        $this->token = $token;
    }

    /**
     * @return int
     */
    public function getCustomerId(): int
    {
        return $this->customerId;
    }

    /**
     * @param int $customerId
     */
    public function setCustomerId(int $customerId): void
    {
        $this->customerId = $customerId;
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
     * @return int
     */
    public function getServiceId(): int
    {
        return $this->serviceId;
    }

    /**
     * @param int $platformId
     */
    public function setServiceId(int $platformId): void
    {
        $this->serviceId = $platformId;
    }
}
