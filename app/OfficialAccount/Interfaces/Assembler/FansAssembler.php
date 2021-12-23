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

use App\OfficialAccount\Interfaces\DTO\Fans\GroupUserDTO;
use App\OfficialAccount\Interfaces\DTO\Fans\IndexDTO;
use App\OfficialAccount\Interfaces\DTO\Fans\MoveGroupDTO;
use App\OfficialAccount\Interfaces\DTO\Fans\UpdateDTO;
use Agarwood\Core\Util\ArrayHelper;
use Swoft\Stdlib\Helper\ObjectHelper;

/**
 * 用户界面层  数据装配器
  *
 */
class FansAssembler
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
        $attributes = ArrayHelper::numericToInt($attributes, ['page', 'perPage']);
        return ObjectHelper::init(new IndexDTO(), $attributes);
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

    /**
     * 客服分组下的粉丝
     *
     * @param array $attributes
     *
     * @return GroupUserDTO
     */
    public static function attributesToGroupUserDTO(array $attributes): GroupUserDTO
    {
        return ObjectHelper::init(new GroupUserDTO(), ArrayHelper::numericToInt($attributes));
    }

    /**
     * 移动分组
     *
     * @param array $attributes
     *
     * @return MoveGroupDTO
     */
    public static function attributesToMoveGroupDTO(array $attributes): MoveGroupDTO
    {
        return ObjectHelper::init(new MoveGroupDTO(), $attributes);
    }
}
