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

use App\Customer\Interfaces\DTO\Group\CustomerGroupCreateDTO;
use App\Customer\Interfaces\DTO\Group\CustomerGroupIndexDTO;
use App\Customer\Interfaces\DTO\Group\CustomerGroupUpdateDTO;
use Agarwood\Core\Util\ArrayHelper;
use Swoft\Stdlib\Helper\ObjectHelper;

/**
 * 用户界面层  数据装配器
 *
 * Class CustomerGroupAssembler
 *
 * @package App\Http\Interfaces\Assembler
 */
class CustomerGroupAssembler
{
    /**
     * 分组列表：数据装配器
     *
     * @param array $attributes
     *
     * @return CustomerGroupIndexDTO
     */
    public static function attributesToIndexDTO(array $attributes): CustomerGroupIndexDTO
    {
        $attributes = ArrayHelper::numericToInt($attributes);
        return ObjectHelper::init(new CustomerGroupIndexDTO(), $attributes);
    }

    /**
     * 新建分组：数据装配器
     *
     * @param array $attributes
     *
     * @return CustomerGroupCreateDTO
     */
    public static function attributesToCreateDTO(array $attributes): CustomerGroupCreateDTO
    {
        return ObjectHelper::init(new CustomerGroupCreateDTO(), $attributes);
    }

    /**
     * 更新分组：数据装配器
     *
     * @param array $attributes
     *
     * @return CustomerGroupUpdateDTO
     */
    public static function attributesToUpdateDTO(array $attributes): CustomerGroupUpdateDTO
    {
        return ObjectHelper::init(new CustomerGroupUpdateDTO(), $attributes);
    }
}
