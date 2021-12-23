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

use App\Assign\Interfaces\DTO\Competitive\ChangeStatusDTO;
use App\Assign\Interfaces\DTO\Competitive\CreateDTO;
use App\Assign\Interfaces\DTO\Competitive\IndexDTO;
use App\Assign\Interfaces\DTO\Competitive\ObtainFansDTO;
use App\Assign\Interfaces\DTO\Competitive\UpdateDTO;
use Agarwood\Core\Util\ArrayHelper;
use Swoft\Stdlib\Helper\ObjectHelper;

class CompetitiveAssembler
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
        $attributes = ArrayHelper::numericToInt($attributes, ['page', 'perPage']);
        return ObjectHelper::init(new IndexDTO(), $attributes);
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

    /**
     * 数据装配器
     *
     * @param array $attributes
     *
     * @return ObtainFansDTO
     */
    public static function attributesToObtainFansDTO(array $attributes): ObtainFansDTO
    {
        return ObjectHelper::init(new ObtainFansDTO(), $attributes);
    }
}
