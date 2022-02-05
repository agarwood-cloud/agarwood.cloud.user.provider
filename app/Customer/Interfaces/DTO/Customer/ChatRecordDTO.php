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
use Swoft\Validator\Annotation\Mapping\IsInt;
use Swoft\Validator\Annotation\Mapping\IsString;
use Swoft\Validator\Annotation\Mapping\Min;
use Swoft\Validator\Annotation\Mapping\Validator;

/**
 * @Validator()
 */
class ChatRecordDTO extends AbstractBaseDTO
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
    public int $perPage = 100;

    /**
     *
     * @IsString()
     *
     * @var string
     */
    public string $startAt = '';

    /**
     *
     * @IsString()
     *
     * @var string
     */
    public string $endAt = '';

    /**
     * @return string
     */
    public function getStartAt(): string
    {
        return $this->startAt;
    }

    /**
     * @param string $startAt
     *
     * @return ChatRecordDTO
     */
    public function setStartAt(string $startAt): ChatRecordDTO
    {
        $this->startAt = $startAt;
        return $this;
    }

    /**
     * @return string
     */
    public function getEndAt(): string
    {
        return $this->endAt;
    }

    /**
     * @param string $endAt
     *
     * @return ChatRecordDTO
     */
    public function setEndAt(string $endAt): ChatRecordDTO
    {
        $this->endAt = $endAt;
        return $this;
    }

    /**
     * @return int
     */
    public function getPage(): int
    {
        return $this->page;
    }

    /**
     * @param int $page
     *
     * @return ChatRecordDTO
     */
    public function setPage(int $page): ChatRecordDTO
    {
        $this->page = $page;
        return $this;
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
     *
     * @return ChatRecordDTO
     */
    public function setPerPage(int $perPage): ChatRecordDTO
    {
        $this->perPage = $perPage;
        return $this;
    }
}
