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

use Agarwood\Core\Util\ArrayHelper;
use App\Customer\Interfaces\DTO\Customer\ChangeStatusDTO;
use App\Customer\Interfaces\DTO\Customer\ChatDTO;
use App\Customer\Interfaces\DTO\Customer\ChatRecordDTO;
use App\Customer\Interfaces\DTO\Customer\CreateDTO;
use App\Customer\Interfaces\DTO\Customer\IndexDTO;
use App\Customer\Interfaces\DTO\Customer\UpdateDTO;
use App\Customer\Interfaces\DTO\Customer\LoginDTO;
use Swoft\Stdlib\Helper\ObjectHelper;

/**
 * 用户界面层  数据装配器
 *
 * Class CustomerAssembler
 *
 * @package App\Http\Interfaces\Assembler
 */
class CustomerAssembler
{
    /**
     * 登陆接口数据装配
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
     * 最近聊天记录的列表
     *
     * @param array $attributes
     *
     * @return ChatDTO
     */
    public static function attributesToChatDTO(array $attributes): ChatDTO
    {
        $attributes = ArrayHelper::numericToInt($attributes, ['page', 'perPage', 'year', 'month']);
        return ObjectHelper::init(new ChatDTO(), $attributes);
    }

    /**
     * 粉丝的聊天记录
     *
     * @param array $attributes
     *
     * @return ChatRecordDTO
     */
    public static function attributesToChatRecordDTO(array $attributes): ChatRecordDTO
    {
        return ObjectHelper::init(new ChatRecordDTO(), ArrayHelper::numericToInt($attributes, ['page', 'perPage', 'year', 'month']));
    }

    /**
     * @param array $attributes
     *
     * @return \App\Customer\Interfaces\DTO\Customer\IndexDTO
     */
    public static function attributesToIndexDTO(array $attributes): IndexDTO
    {
        return ObjectHelper::init(new IndexDTO(), ArrayHelper::numericToInt($attributes, ['page', 'perPage']));
    }

    /**
     * @param array $attributes
     *
     * @return \App\Customer\Interfaces\DTO\Customer\CreateDTO
     */
    public static function attributesToCreateDTO(array $attributes): CreateDTO
    {
        return ObjectHelper::init(new CreateDTO(), $attributes);
    }

    public static function attributesToUpdateDTO(array $attributes): UpdateDTO
    {
        return ObjectHelper::init(new UpdateDTO(), $attributes);
    }

    public static function attributesToChangeStatusDTO(array $attributes): ChangeStatusDTO
    {
        return ObjectHelper::init(new ChangeStatusDTO(), $attributes);
    }
}
