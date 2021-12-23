<?php declare(strict_types=1);
/**
 * This file is part of Agarwood Cloud.
 *
 * @link     https://www.agarwood-cloud.com
 * @document https://www.agarwood-cloud.com/docs
 * @contact  676786620@qq.com
 * @author   agarwood
 */

namespace App\Customer\Interfaces\Assembler;

use App\Customer\Interfaces\DTO\Customer\ChangeStatusDTO;
use App\Customer\Interfaces\DTO\Customer\CustomerServiceCreateDTO;
use App\Customer\Interfaces\DTO\Customer\CustomerServiceIndexDTO;
use App\Customer\Interfaces\DTO\Customer\CustomerServiceUpdateDTO;
use App\Customer\Interfaces\DTO\Customer\LoginDTO;
use Agarwood\Core\Util\ArrayHelper;
use Swoft\Stdlib\Helper\ObjectHelper;

/**
 * 用户界面层  数据装配器
 *
 * Class CustomerServiceAssembler
 *
 * @package App\Http\Interfaces\Assembler
 */
class CustomerServiceAssembler
{
    /**
     * 粉丝列表数据装配器
     *
     * @param array $attributes
     *
     * @return CustomerServiceIndexDTO
     */
    public static function attributesToIndexDTO(array $attributes): CustomerServiceIndexDTO
    {
        $attributes = ArrayHelper::numericToInt($attributes, ['page', 'perPage']);
        return ObjectHelper::init(new CustomerServiceIndexDTO(), $attributes);
    }

    /**
     * 粉丝新建数据装配器
     *
     * @param array $attributes
     *
     * @return CustomerServiceCreateDTO
     */
    public static function attributesToCreateDTO(array $attributes): CustomerServiceCreateDTO
    {
        return ObjectHelper::init(new CustomerServiceCreateDTO(), $attributes);
    }

    /**
     * 粉丝更新数据装配器
     *
     * @param array $attributes
     *
     * @return CustomerServiceUpdateDTO
     */
    public static function attributesToUpdateDTO(array $attributes): CustomerServiceUpdateDTO
    {
        return ObjectHelper::init(new CustomerServiceUpdateDTO(), $attributes);
    }

    /**
     *
     *
     * @param array $attributes
     *
     * @return LoginDTO
     */
    public static function attributesToLoginDTO(array $attributes): LoginDTO
    {
        return ObjectHelper::init(new LoginDTO(), $attributes);
    }

    /**
     * @param array $attributes
     *
     * @return ChangeStatusDTO
     */
    public static function attributesToChangeStatusDTO(array $attributes): ChangeStatusDTO
    {
        return ObjectHelper::init(new ChangeStatusDTO(), $attributes);
    }
}
