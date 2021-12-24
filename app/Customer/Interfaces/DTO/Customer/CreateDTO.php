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

use Agarwood\Core\Support\Impl\AbstractBaseDTO;

/**
 * @\Swoft\Validator\Annotation\Mapping\Validator()
 */
class CreateDTO extends AbstractBaseDTO
{
    /**
     * 账号
     *
     * @\Swoft\Validator\Annotation\Mapping\Required()
     * @\Swoft\Validator\Annotation\Mapping\NotEmpty()
     * @\Swoft\Validator\Annotation\Mapping\IsString()
     *
     * @var string
     */
    public string $account = '';

    /**
     * 分组ID
     *
     * @\Swoft\Validator\Annotation\Mapping\IsInt()
     *
     * @var int
     */
    public int $groupId = 0;

    /**
     * @\Swoft\Validator\Annotation\Mapping\IsString()
     *
     * @var string
     */
    public string $groupName = '';

    /**
     * 名称
     *
     * @\Swoft\Validator\Annotation\Mapping\Required()
     * @\Swoft\Validator\Annotation\Mapping\NotEmpty()
     * @\Swoft\Validator\Annotation\Mapping\IsString()
     *
     * @var string
     */
    public string $name = '';

    /**
     * 密码
     *
     * @\Swoft\Validator\Annotation\Mapping\Required()
     * @\Swoft\Validator\Annotation\Mapping\NotEmpty()
     * @\Swoft\Validator\Annotation\Mapping\IsString()
     *
     * @var string
     */
    public string $password = '';

    /**
     * 手机
     *
     * @\Swoft\Validator\Annotation\Mapping\Required()
     * @\Swoft\Validator\Annotation\Mapping\NotEmpty()
     * @\Swoft\Validator\Annotation\Mapping\IsString()
     * @\Swoft\Validator\Annotation\Mapping\Mobile()
     *
     * @var string
     */
    public string $phone = '';

    /**
     * usable:可用,disabled:不可用
     *
     * @\Swoft\Validator\Annotation\Mapping\Required()
     * @\Swoft\Validator\Annotation\Mapping\NotEmpty()
     * @\Swoft\Validator\Annotation\Mapping\IsString()
     * @\Swoft\Validator\Annotation\Mapping\Enum(values={"usable","disabled"})
     *
     * @var string
     */
    public string $status = 'usable';

    /**
     * @return string
     */
    public function getAccount(): string
    {
        return $this->account;
    }

    /**
     * @param string $account
     */
    public function setAccount(string $account): void
    {
        $this->account = $account;
    }

    /**
     * @return int
     */
    public function getGroupId(): int
    {
        return $this->groupId;
    }

    /**
     * @param int $groupId
     */
    public function setGroupId(int $groupId): void
    {
        $this->groupId = $groupId;
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
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    /**
     * @return string
     */
    public function getPhone(): string
    {
        return $this->phone;
    }

    /**
     * @param string $phone
     */
    public function setPhone(string $phone): void
    {
        $this->phone = $phone;
    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * @param string $status
     */
    public function setStatus(string $status): void
    {
        $this->status = $status;
    }
}
