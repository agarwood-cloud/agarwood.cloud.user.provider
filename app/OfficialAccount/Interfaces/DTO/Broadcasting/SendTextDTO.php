<?php declare(strict_types=1);
/**
 * This file is part of Agarwood Cloud.
 *
 * @link     https://www.agarwood-cloud.com
 * @document https://www.agarwood-cloud.com/docs
 * @contact  676786620@qq.com
 * @author   agarwood
 */

namespace App\OfficialAccount\Interfaces\DTO\Broadcasting;

use Agarwood\Core\Support\Impl\AbstractBaseDTO;
use Swoft\Validator\Annotation\Mapping\Validator;

/**
 *
 * @Validator()
 */
class SendTextDTO extends AbstractBaseDTO
{
    /**
     * @\Swoft\Validator\Annotation\Mapping\IsArray()
     * @\Swoft\Validator\Annotation\Mapping\NotEmpty()
     *
     * @var array
     */
    public array $sendTo = [];

    /**
     * 文本的消息内容
     *
     * @\Swoft\Validator\Annotation\Mapping\IsString()
     * @\Swoft\Validator\Annotation\Mapping\NotEmpty()
     *
     * @var string
     */
    public string $content = '';

    /**
     * @return array
     */
    public function getSendTo(): array
    {
        return $this->sendTo;
    }

    /**
     * @param array $sendTo
     */
    public function setSendTo(array $sendTo): void
    {
        $this->sendTo = $sendTo;
    }

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
}
