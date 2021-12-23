<?php declare(strict_types=1);
/**
 * This file is part of Agarwood Cloud.
 *
 * @link     https://www.agarwood-cloud.com
 * @document https://www.agarwood-cloud.com/docs
 * @contact  676786620@qq.com
 * @author   agarwood
 */

namespace App\Customer\Interfaces\DTO\CustomerOverview;

use Agarwood\Core\Support\Impl\AbstractBaseDTO;
use Swoft\Validator\Annotation\Mapping\Date;
use Swoft\Validator\Annotation\Mapping\IsInt;
use Swoft\Validator\Annotation\Mapping\IsString;
use Swoft\Validator\Annotation\Mapping\Min;
use Swoft\Validator\Annotation\Mapping\Validator;

/**
 * @Validator()
 */
class IndexDTO extends AbstractBaseDTO
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
     *
     * @var string|null
     */
    public ?string $account = null;

    /**
     * @IsString()
     *
     * @var string|null
     */
    public ?string $name = null;

    /**
     * @IsString()
     * @Date()
     *
     * @var string|null
     */
    public ?string $startAt = null;

    /**
     * @IsString()
     * @Date()
     *
     * @var string|null
     */
    public ?string $endAt = null;

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
    public function getStartAt(): ?string
    {
        return $this->startAt;
    }

    /**
     * @param string|null $startAt
     */
    public function setStartAt(?string $startAt): void
    {
        $this->startAt = $startAt;
    }

    /**
     * @return string|null
     */
    public function getEndAt(): ?string
    {
        return $this->endAt;
    }

    /**
     * @param string|null $endAt
     */
    public function setEndAt(?string $endAt): void
    {
        $this->endAt = $endAt;
    }
}
