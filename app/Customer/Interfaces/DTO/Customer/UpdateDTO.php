<?php
declare(strict_types=1);
/**
 * This file is part of Agarwood Cloud.
 *
 * @link     https://www.agarwood-cloud.com
 * @document https://www.agarwood-cloud.com/docs
 * @contact  676786620@qq.com
 * @author   agarwood
 */

namespace App\Customer\Interfaces\DTO\Customer;

use Agarwood\Core\Support\Impl\AbstractBaseDTO;

/**
 * @\Swoft\Validator\Annotation\Mapping\Validator()
 */
class UpdateDTO extends AbstractBaseDTO
{
    /**
     * 账号
     *
     * @\Swoft\Validator\Annotation\Mapping\Required()
     * @\Swoft\Validator\Annotation\Mapping\IsString()
     * @\Swoft\Validator\Annotation\Mapping\NotEmpty()
     *
     * @var ?string
     */
    protected ?string $account = null;

    /**
     * 分组ID
     *
     * @\Swoft\Validator\Annotation\Mapping\IsInt()
     *
     * @var int|null
     */
    public ?int $groupId = null;

    /**
     * @\Swoft\Validator\Annotation\Mapping\IsString()
     *
     * @var ?string
     */
    public ?string $groupName = null;

    /**
     * 名称
     *
     * @\Swoft\Validator\Annotation\Mapping\IsString()
     *
     * @var string|null
     */
    public ?string $name = null;

    /**
     * 密码
     *
     * @\Swoft\Validator\Annotation\Mapping\IsString()
     *
     * @var string|null
     */
    public ?string $password = null;

    /**
     * 手机
     *
     * @\Swoft\Validator\Annotation\Mapping\Mobile()
     * @\Swoft\Validator\Annotation\Mapping\IsString()
     *
     * @var ?string
     */
    public ?string $phone = null;

    /**
     * 服务号
     *
     * @\Swoft\Validator\Annotation\Mapping\IsInt()
     *
     * @var int|null
     */
    public ?int $officialAccountId = null;

    /**
     * usable:可用,disabled:不可用
     *
     * @\Swoft\Validator\Annotation\Mapping\IsString()
     * @\Swoft\Validator\Annotation\Mapping\Enum(values={"usable","disabled"})
     *
     * @var string|null
     */
    public ?string $status = null;

    /**
     * @return string|null
     */
    public function getAccount(): ?string
    {
        return $this->account;
    }

    /**
     * @param string|null $account
     */
    public function setAccount(?string $account): void
    {
        $this->account = $account;
    }

    /**
     * @return int|null
     */
    public function getGroupId(): ?int
    {
        return $this->groupId;
    }

    /**
     * @param int|null $groupId
     */
    public function setGroupId(?int $groupId): void
    {
        $this->groupId = $groupId;
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
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string|null $name
     */
    public function setName(?string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string|null
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    /**
     * @param string|null $password
     */
    public function setPassword(?string $password): void
    {
        $this->password = $password;
    }

    /**
     * @return string|null
     */
    public function getPhone(): ?string
    {
        return $this->phone;
    }

    /**
     * @param string|null $phone
     */
    public function setPhone(?string $phone): void
    {
        $this->phone = $phone;
    }

    /**
     * @return int|null
     */
    public function getOfficialAccountId(): ?int
    {
        return $this->officialAccountId;
    }

    /**
     * @param int|null $officialAccountId
     */
    public function setOfficialAccountId(?int $officialAccountId): void
    {
        $this->officialAccountId = $officialAccountId;
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
}
