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

use App\OfficialAccount\Interfaces\DTO\Broadcasting\FansGroupDTO;
use App\OfficialAccount\Interfaces\DTO\Broadcasting\IndexDTO;
use App\OfficialAccount\Interfaces\DTO\Broadcasting\SendTextDTO;
use Agarwood\Core\Util\ArrayHelper;
use Swoft\Stdlib\Helper\ObjectHelper;

/**
 * 用户界面层  数据装配器
  *
 */
class BroadcastingAssembler
{
    /**
     * 数据装配器
     *
     * @param array $attributes
     *
     * @return SendTextDTO
     */
    public static function attributesToSendTextDTO(array $attributes): SendTextDTO
    {
        return ObjectHelper::init(new SendTextDTO(), $attributes);
    }

    /**
     * @param array $attributes
     *
     * @return \App\OfficialAccount\Interfaces\DTO\Broadcasting\IndexDTO
     */
    public static function attributesToIndexDTO(array $attributes): IndexDTO
    {
        return ObjectHelper::init(new IndexDTO(), ArrayHelper::numericToInt($attributes));
    }

    /**
     * @param array $attributes
     *
     * @return \App\OfficialAccount\Interfaces\DTO\Broadcasting\FansGroupDTO
     */
    public static function attributesToFansGroupDTO(array $attributes): FansGroupDTO
    {
        return ObjectHelper::init(new FansGroupDTO(), ArrayHelper::numericToInt($attributes));
    }
}
