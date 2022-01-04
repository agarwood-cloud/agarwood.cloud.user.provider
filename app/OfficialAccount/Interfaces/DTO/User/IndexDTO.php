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

/**
 * @\Swoft\Validator\Annotation\Mapping\Validator()
 */
class IndexDTO extends AbstractBaseDTO
{
    /**
     * @\Swoft\Validator\Annotation\Mapping\IsInt()
     * @\Swoft\Validator\Annotation\Mapping\Min(value=1)
     *
     * @var int
     */
    public int $page = 1;

    /**
     * @\Swoft\Validator\Annotation\Mapping\IsInt()
     * @\Swoft\Validator\Annotation\Mapping\Min(value=1)
     *
     * @var int
     */
    public int $perPage = 10;

    /**
     * @\Swoft\Validator\Annotation\Mapping\IsString()
     *
     * @var string|null
     */
    public ?string $openid = null;

    /**
     * @\Swoft\Validator\Annotation\Mapping\IsString()
     *
     * @var string|null
     */
    public ?string $nickname = null;

    /**
     * @\Swoft\Validator\Annotation\Mapping\IsString()
     * @\Swoft\Validator\Annotation\Mapping\Enum(values={"","subscribe","unsubscribed","unsubscribe"})
     *
     * @var string|null
     */
    public ?string $subscribe = null;

    /**
     * @\Swoft\Validator\Annotation\Mapping\IsString()
     *
     * @var string|null
     */
    public ?string $customer = null;

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
    public function getOpenid(): ?string
    {
        return $this->openid;
    }

    /**
     * @param string|null $openid
     */
    public function setOpenid(?string $openid): void
    {
        $this->openid = $openid;
    }

    /**
     * @return string|null
     */
    public function getNickname(): ?string
    {
        return $this->nickname;
    }

    /**
     * @param string|null $nickname
     */
    public function setNickname(?string $nickname): void
    {
        $this->nickname = $nickname;
    }

    /**
     * @return string|null
     */
    public function getSubscribe(): ?string
    {
        return $this->subscribe;
    }

    /**
     * @param string|null $subscribe
     */
    public function setSubscribe(?string $subscribe): void
    {
        $this->subscribe = $subscribe;
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
}
