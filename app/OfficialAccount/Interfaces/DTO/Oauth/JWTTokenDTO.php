<?php declare(strict_types=1);
/**
 * This file is part of Agarwood Cloud.
 *
 * @link     https://www.agarwood-cloud.com
 * @document https://www.agarwood-cloud.com/docs
 * @contact  676786620@qq.com
 * @author   agarwood
 */

namespace App\OfficialAccount\Interfaces\DTO\Oauth;

use Agarwood\Core\Support\Impl\AbstractBaseDTO;
use Swoft\Validator\Annotation\Mapping\IsString;
use Swoft\Validator\Annotation\Mapping\NotEmpty;
use Swoft\Validator\Annotation\Mapping\Required;
use Swoft\Validator\Annotation\Mapping\Validator;

/**
 * 微信授权回调信息
 *
 *
 * @\Swoft\Bean\Annotation\Mapping\Bean()
 * @Validator()
 *
 */
class JWTTokenDTO extends AbstractBaseDTO
{
    /**
     * @Required()
     * @IsString()
     * @NotEmpty()
     *
     * @var string
     */
    public string $jwtToken = '';

    /**
     * @return string
     */
    public function getJwtToken(): string
    {
        return $this->jwtToken;
    }

    /**
     * @param string $jwtToken
     */
    public function setJwtToken(string $jwtToken): void
    {
        $this->jwtToken = $jwtToken;
    }
}
