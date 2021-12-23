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

namespace App\OfficialAccount\Interfaces\DTO\UserInfo;

use Agarwood\Core\Support\Impl\AbstractBaseDTO;
use Swoft\Validator\Annotation\Mapping\IsInt;
use Swoft\Validator\Annotation\Mapping\Min;
use Swoft\Validator\Annotation\Mapping\Validator;

/**
 *
 * @Validator()
 */
class UserInfoIndexDTO extends AbstractBaseDTO
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
}
