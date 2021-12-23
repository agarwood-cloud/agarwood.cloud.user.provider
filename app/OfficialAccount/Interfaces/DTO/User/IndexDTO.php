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
use Swoft\Validator\Annotation\Mapping\IsArray;
use Swoft\Validator\Annotation\Mapping\IsInt;
use Swoft\Validator\Annotation\Mapping\Min;
use Swoft\Validator\Annotation\Mapping\NotEmpty;
use Swoft\Validator\Annotation\Mapping\Validator;

/**
 *
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
    public int $perPage = 20;

    /**
     * @IsArray()
     * @NotEmpty()
     *
     * @var array
     */
    public array $openid = [];

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
     * @return IndexDTO
     */
    public function setPage(int $page): IndexDTO
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
     * @return IndexDTO
     */
    public function setPerPage(int $perPage): IndexDTO
    {
        $this->perPage = $perPage;
        return $this;
    }

    /**
     * @return array
     */
    public function getOpenid(): array
    {
        return $this->openid;
    }

    /**
     * @param array $openid
     *
     * @return IndexDTO
     */
    public function setOpenid(array $openid): IndexDTO
    {
        $this->openid = $openid;
        return $this;
    }
}
