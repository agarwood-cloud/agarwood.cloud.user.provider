<?php declare(strict_types=1);
/**
 * This file is part of Agarwood Cloud.
 *
 * @link     https://www.agarwood-cloud.com
 * @document https://www.agarwood-cloud.com/docs
 * @contact  676786620@qq.com
 * @author   agarwood
 */

namespace App\Customer\Interfaces\DTO\Customer;

use Agarwood\Core\Constant\StringConstant;
use Agarwood\Core\Support\Impl\AbstractBaseDTO;
use Swoft\Validator\Annotation\Mapping\Enum;
use Swoft\Validator\Annotation\Mapping\IsString;
use Swoft\Validator\Annotation\Mapping\Mobile;
use Swoft\Validator\Annotation\Mapping\NotEmpty;
use Swoft\Validator\Annotation\Mapping\Required;
use Swoft\Validator\Annotation\Mapping\Validator;

/**
 * @Validator()
 */
class CustomerServiceCreateDTO extends AbstractBaseDTO
{
    /**
     * 账号
     *
     * @Required()
     * @NotEmpty()
     * @IsString()
     *
     * @var string
     */
    public string $account = '';

    /**
     * 删除时间
     *
     * @IsString()
     *
     * @var string
     */
    public string $deletedAt = StringConstant::DATE_TIME_DEFAULT;

    /**
     * 分组ID
     *
     * @IsString()
     *
     * @var string
     */
    public string $groupUuid = '';

    /**
     * @IsString()
     *
     * @var string
     */
    public string $groupName = '';

    /**
     * 名称
     *
     * @Required()
     * @NotEmpty()
     * @IsString()
     *
     * @var string
     */
    public string $name = '';

    /**
     * 密码
     *
     * @Required()
     * @NotEmpty()
     * @IsString()
     *
     * @var string
     */
    public string $password = '';

    /**
     * 手机
     *
     * @Required()
     * @NotEmpty()
     * @Mobile()
     * @IsString()
     *
     * @var string
     */
    public string $phone = '';

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
     * @param string $account
     *
     * @return self
     */
    public function setAccount(string $account): self
    {
        $this->account = $account;

        return $this;
    }

    /**
     * @param string $deletedAt
     *
     * @return self
     */
    public function setDeletedAt(string $deletedAt): self
    {
        $this->deletedAt = $deletedAt;

        return $this;
    }

    /**
     * @param string $groupUuid
     *
     * @return self
     */
    public function setGroupUuid(string $groupUuid): self
    {
        $this->groupUuid = $groupUuid;

        return $this;
    }

    /**
     * @param string $name
     *
     * @return self
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @param string $password
     *
     * @return self
     */
    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @param string $phone
     *
     * @return self
     */
    public function setPhone(string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * @param string $status
     *
     * @return self
     */
    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return string
     */
    public function getAccount(): ?string
    {
        return $this->account;
    }

    /**
     * @return string
     */
    public function getDeletedAt(): ?string
    {
        return $this->deletedAt;
    }

    /**
     * @return string
     */
    public function getGroupUuid(): ?string
    {
        return $this->groupUuid;
    }

    /**
     * @return string
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @return string
     */
    public function getPhone(): ?string
    {
        return $this->phone;
    }

    /**
     * @return string
     */
    public function getStatus(): ?string
    {
        return $this->status;
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
}
