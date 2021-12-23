<?php declare(strict_types=1);
/**
 * This file is part of Agarwood Cloud.
 *
 * @link     https://www.agarwood-cloud.com
 * @document https://www.agarwood-cloud.com/docs
 * @contact  676786620@qq.com
 * @author   agarwood
 */

namespace App\Assign\Interfaces\Assembler;

use App\Assign\Interfaces\DTO\Department\ChangeStatusDTO;
use App\Assign\Interfaces\DTO\Department\CreateDTO;
use App\Assign\Interfaces\DTO\Department\IndexDTO;
use App\Assign\Interfaces\DTO\Department\UpdateDTO;
use Agarwood\Core\Util\ArrayHelper;
use Swoft\Stdlib\Helper\ObjectHelper;

class CompetitiveDepartmentAssembler
{
    /**
     * 数据装配器
     *
     * @param array $attributes
     *
     * @return IndexDTO
     */
    public static function attributesToIndexDTO(array $attributes): IndexDTO
    {
        return ObjectHelper::init(new IndexDTO(), ArrayHelper::numericToInt($attributes, ['page', 'perPage']));
    }

    /**
     * 数据装配器
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
     * 数据装配器
     *
     * @param array $attributes
     *
     * @return ChangeStatusDTO
     */
    public static function attributesToChangeDTO(array $attributes): ChangeStatusDTO
    {
        return ObjectHelper::init(new ChangeStatusDTO(), $attributes);
    }

    /**
     * 数据装配器
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
