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

use App\OfficialAccount\Interfaces\DTO\AutoReply\CreateDTO;
use App\OfficialAccount\Interfaces\DTO\AutoReply\IndexDTO;
use App\OfficialAccount\Interfaces\DTO\AutoReply\SaveDTO;
use App\OfficialAccount\Interfaces\DTO\AutoReply\UpdateDTO;
use Agarwood\Core\Util\ArrayHelper;
use Swoft\Stdlib\Helper\ObjectHelper;

/**
 * 用户界面层  数据装配器
  *
 */
class AutoReplyAssembler
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

    /**
     * 新建或者保存
     *
     * @param array $attributes
     *
     * @return \App\OfficialAccount\Interfaces\DTO\AutoReply\SaveDTO
     */
    public static function attributesToSaveDTO(array $attributes): SaveDTO
    {
        return ObjectHelper::init(new SaveDTO(), $attributes);
    }
}
