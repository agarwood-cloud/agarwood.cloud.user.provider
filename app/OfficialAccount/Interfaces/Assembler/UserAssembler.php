<?php declare(strict_types=1);
/**
 * This file is part of Agarwood Cloud.
 *
 * @link     https://www.agarwood-cloud.com
 * @document https://www.agarwood-cloud.com/docs
 * @contact  676786620@qq.com
 * @author   agarwood
 */

namespace App\OfficialAccount\Interfaces\Assembler;

use Agarwood\Core\Util\ArrayHelper;
use App\OfficialAccount\Interfaces\DTO\User\CreateDTO;
use App\OfficialAccount\Interfaces\DTO\User\IndexDTO;
use App\OfficialAccount\Interfaces\DTO\User\UpdateDTO;
use App\OfficialAccount\Interfaces\DTO\User\UpdateGroupDTO;
use App\OfficialAccount\Interfaces\DTO\User\UserIndexDTO;
use Swoft\Stdlib\Helper\ObjectHelper;

/**
 * 用户界面层  数据装配器
 *
 */
class UserAssembler
{
    /**
     * 粉丝列表数据装配器
     *
     * @param array $attributes
     *
     * @return UserIndexDTO
     */
    public static function attributesToIndexDTO(array $attributes): UserIndexDto
    {
        $attributes = ArrayHelper::numericToInt($attributes);
        return ObjectHelper::init(new UserIndexDTO(), $attributes);
    }

    /**
     * @param array $attributes
     *
     * @return \App\OfficialAccount\Interfaces\DTO\User\CreateDTO
     */
    public static function attributesToCreateDTO(array $attributes): CreateDTO
    {
        return ObjectHelper::init(new CreateDTO(), $attributes);
    }

    /**
     * 粉丝更新数据装配器
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
     * 粉丝更新数据装配器
     *
     * @param array $attributes
     *
     * @return UpdateGroupDTO
     */
    public static function attributesToAssignCustomerDTO(array $attributes): UpdateGroupDTO
    {
        return ObjectHelper::init(new UpdateGroupDTO(), $attributes);
    }

    /**
     * 最近聊天记录的列表
     *
     * @param array $attributes
     *
     * @return IndexDTO
     */
    public static function attributesToIndexV3DTO(array $attributes): IndexDTO
    {
        $attributes = ArrayHelper::numericToInt($attributes, ['page', 'perPage']);
        return ObjectHelper::init(new IndexDTO(), $attributes);
    }
}
