<?php declare(strict_types=1);
/**
 * This file is part of Agarwood Cloud.
 *
 * @link     https://www.agarwood-cloud.com
 * @document https://www.agarwood-cloud.com/docs
 * @contact  676786620@qq.com
 * @author   agarwood
 */

namespace App\OfficialAccount\Interfaces\DTO\Fans;

use Agarwood\Core\Support\Impl\AbstractBaseDTO;
use Swoft\Validator\Annotation\Mapping\Validator;

/**
 *
 * @Validator()
 */
class MoveGroupDTO extends AbstractBaseDTO
{
    /**
     * @\Swoft\Validator\Annotation\Mapping\Required()
     * @\Swoft\Validator\Annotation\Mapping\IsString()
     * @\Swoft\Validator\Annotation\Mapping\NotEmpty()
     *
     * @var string
     */
    public string $openid = '';

    /**
     * @\Swoft\Validator\Annotation\Mapping\Required()
     * @\Swoft\Validator\Annotation\Mapping\IsString()
     * @\Swoft\Validator\Annotation\Mapping\NotEmpty()
     *
     * @var string
     */
    public string $groupUuid = '';

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
    public function getGroupUuid(): string
    {
        return $this->groupUuid;
    }

    /**
     * @param string $groupUuid
     */
    public function setGroupUuid(string $groupUuid): void
    {
        $this->groupUuid = $groupUuid;
    }
}
