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
use Swoft\Validator\Annotation\Mapping\IsString;
use Swoft\Validator\Annotation\Mapping\NotEmpty;
use Swoft\Validator\Annotation\Mapping\Required;
use Swoft\Validator\Annotation\Mapping\Validator;

/**
 * @Validator()
 */
class LoginDTO extends AbstractBaseDTO
{
    /**
     *
     * @Required()
     * @NotEmpty()
     * @IsString()
     *
     * @var string
     */
    public string $username = '';

    /**
     *
     * @IsString()
     *
     * @var string
     */
    public string $token = '';

    /**
     *
     * @Required()
     * @NotEmpty()
     * @IsString()
     *
     * @var string
     */
    public int $officialAccountId = 0;

    /**
     *
     * @Required()
     * @NotEmpty()
     * @IsString()
     *
     * @var string
     */
    public string $password = '';

    /**
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * @param string $username
     */
    public function setUsername(string $username): void
    {
        $this->username = $username;
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
    public function getToken(): string
    {
        return $this->token;
    }

    /**
     * @param string $token
     */
    public function setToken(string $token): void
    {
        $this->token = $token;
    }

    /**
     * @return string
     */
    public function getServiceUuid(): string
    {
        return $this->serviceUuid;
    }

    /**
     * @param int $officialAccountId
     */
    public function setServiceUuid(int $officialAccountId): void
    {
        $this->serviceUuid = $officialAccountId;
    }
}
