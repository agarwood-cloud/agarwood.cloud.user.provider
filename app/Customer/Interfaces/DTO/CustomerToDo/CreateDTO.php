<?php declare(strict_types=1);
/**
 * This file is part of Agarwood Cloud.
 *
 * @link     https://www.agarwood-cloud.com
 * @document https://www.agarwood-cloud.com/docs
 * @contact  676786620@qq.com
 * @author   agarwood
 */

namespace App\Customer\Interfaces\DTO\CustomerToDo;

use Agarwood\Core\Support\Impl\AbstractBaseDTO;
use Swoft\Validator\Annotation\Mapping\Validator;

/**
 * @Validator()
 */
class CreateDTO extends AbstractBaseDTO
{
    /**
     * @\Swoft\Validator\Annotation\Mapping\IsString()
     * @\Swoft\Validator\Annotation\Mapping\Required()
     * @\Swoft\Validator\Annotation\Mapping\NotEmpty()
     *
     * @var string
     */
    public string $content = '';

    /**
     * @\Swoft\Validator\Annotation\Mapping\IsString()
     *
     * @var string
     */
    public string $remark = '';

    /**
     * @\Swoft\Validator\Annotation\Mapping\IsString()
     * @\Swoft\Validator\Annotation\Mapping\Date()
     *
     * @var string|null
     */
    public ?string $deadlineAt = null;

    /**
     * @\Swoft\Validator\Annotation\Mapping\IsString()
     *
     *
     * @var string
     */
    public string $openid = '';

    /**
     * @\Swoft\Validator\Annotation\Mapping\IsString()
     *
     *
     * @var string
     */
    public string $nickname = '';

    /**
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * @param string $content
     */
    public function setContent(string $content): void
    {
        $this->content = $content;
    }

    /**
     * @return string
     */
    public function getRemark(): string
    {
        return $this->remark;
    }

    /**
     * @param string $remark
     */
    public function setRemark(string $remark): void
    {
        $this->remark = $remark;
    }

    /**
     * @return string|null
     */
    public function getDeadlineAt(): ?string
    {
        return $this->deadlineAt;
    }

    /**
     * @param string|null $deadlineAt
     */
    public function setDeadlineAt(?string $deadlineAt): void
    {
        $this->deadlineAt = $deadlineAt;
    }

    /**
     * @return string
     */
    public function getOpenid(): string
    {
        return $this->openid;
    }

    /**
     * @param string $openid
     */
    public function setOpenid(string $openid): void
    {
        $this->openid = $openid;
    }

    /**
     * @return string
     */
    public function getNickname(): string
    {
        return $this->nickname;
    }

    /**
     * @param string $nickname
     */
    public function setNickname(string $nickname): void
    {
        $this->nickname = $nickname;
    }
}
