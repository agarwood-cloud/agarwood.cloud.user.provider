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

use App\Customer\Interfaces\DTO\CustomerToDo\CreateDTO;
use App\Customer\Interfaces\DTO\CustomerToDo\IndexDTO;
use App\Customer\Interfaces\DTO\CustomerToDo\UpdateDTO;
use Agarwood\Core\Util\ArrayHelper;
use Swoft\Stdlib\Helper\ObjectHelper;

/**
 * 用户界面层  数据装配器
 *
 * Class CustomerToDoAssembler
 *
 * @package App\Http\Interfaces\Assembler
 */
class CustomerToDoAssembler
{
    /**
     * 分组列表：数据装配器
     *
     * @param array $attributes
     *
     * @return IndexDTO
     */
    public static function attributesToIndexDTO(array $attributes): IndexDTO
    {
        $attributes = ArrayHelper::numericToInt($attributes);
        return ObjectHelper::init(new IndexDTO(), $attributes);
    }

    /**
     * 新建分组：数据装配器
     *
     * @param array $attributes
     *
     * @return CreateDTO
     */
    public static function attributesToCreateDTO(array $attributes): CreateDTO
    {
        return ObjectHelper::init(new CreateDTO(), $attributes);
    }

    /**
     * 更新分组：数据装配器
     *
     * @param array $attributes
     *
     * @return UpdateDTO
     */
    public static function attributesToUpdateDTO(array $attributes): UpdateDTO
    {
        return ObjectHelper::init(new UpdateDTO(), $attributes);
    }
}
