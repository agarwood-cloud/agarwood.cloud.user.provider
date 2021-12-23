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
use Swoft\Validator\Annotation\Mapping\Enum;
use Swoft\Validator\Annotation\Mapping\IsInt;
use Swoft\Validator\Annotation\Mapping\IsString;
use Swoft\Validator\Annotation\Mapping\Min;
use Swoft\Validator\Annotation\Mapping\Validator;

/**
 * @Validator()
 */
class CustomerServiceIndexDTO extends AbstractBaseDTO
{
    /**
     * 第 ${page} 页
     *
     * @IsInt(message="页码必须为整数")
     * @Min(value=1, message="页码最小值为1")
     *
     * @var int
     */
    public int $page = 1;

    /**
     * 每页共 ${perPage} 条记录
     *
     * 每页条数
     * @IsInt(message="每页条数必须为整数")
     * @Min(value=1, message="每页条数最小值为1")
     *
     * @var int
     */
    public int $perPage = 10;

    /**
     * @IsString()
     * @Enum(values={"","usable","disabled"})
     *
     * @var string|null
     */
    public ?string $status = '';

    /**
     * @IsString()
     *
     *
     * @var string|null
     */
    public ?string $name = '';

    /**
     * @IsString()
     *
     * @var string|null
     */
    public ?string $account = '';

    /**
     * @IsString()
     *
     * @var string|null
     */
    public ?string $groupName = null;

    /**
     * 第 ${page} 页
     *
     * @return int
     */
    public function getPage(): int
    {
        return $this->page;
    }

    /**
     * 第 ${page} 页
     *
     * @param int $page
     */
    public function setPage(int $page): void
    {
        $this->page = $page;
    }

    /**
     * 每页 ${page} 条记录
     *
     * @return int
     */
    public function getPerPage(): int
    {
        return $this->perPage;
    }

    /**
     * 每页 ${page} 条记录
     *
     * @param int $perPage
     */
    public function setPerPage(int $perPage): void
    {
        $this->perPage = $perPage;
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
}
