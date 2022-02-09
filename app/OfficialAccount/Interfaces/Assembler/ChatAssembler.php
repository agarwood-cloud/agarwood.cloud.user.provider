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
use App\OfficialAccount\Interfaces\DTO\Chat\ChatDTO;
use App\OfficialAccount\Interfaces\DTO\Chat\ChatRecordDTO;
use App\OfficialAccount\Interfaces\DTO\Chat\VoiceDTO;
use App\OfficialAccount\Interfaces\DTO\Chat\ImageDTO;
use App\OfficialAccount\Interfaces\DTO\Chat\NewsItemDTO;
use App\OfficialAccount\Interfaces\DTO\Chat\TextDTO;
use App\OfficialAccount\Interfaces\DTO\Chat\VideoDTO;
use Swoft\Stdlib\Helper\ObjectHelper;

/**
 * 用户界面层  数据装配器
  *
 */
class ChatAssembler
{
    /**
     * 文本消息
     *
     * @param array $attributes
     *
     * @return TextDTO
     */
    public static function attributesToTextMessageDTO(array $attributes): TextDTO
    {
        return ObjectHelper::init(new TextDTO(), $attributes);
    }

    /**
     * 图片消息
     *
     * @param array $attributes
     *
     * @return ImageDTO
     */
    public static function attributesToImageMessageDTO(array $attributes): ImageDTO
    {
        return ObjectHelper::init(new ImageDTO(), $attributes);
    }

    /**
     * 视频消息
     *
     * @param array $attributes
     *
     * @return VideoDTO
     */
    public static function attributesToVideoMessageDTO(array $attributes): VideoDTO
    {
        return ObjectHelper::init(new VideoDTO(), $attributes);
    }

    /**
     * @param array $attributes
     *
     * @return VoiceDTO
     */
    public static function attributesToVoiceMessageDTO(array $attributes): VoiceDTO
    {
        return ObjectHelper::init(new VoiceDTO(), $attributes);
    }

    /**
     * @param array $attributes
     *
     * @return NewsItemDTO
     */
    public static function attributesToNewsItemMessageDTO(array $attributes): NewsItemDTO
    {
        return ObjectHelper::init(new NewsItemDTO(), $attributes);
    }

    /**
     * @param array $attributes
     *
     * @return ChatDTO
     */
    public static function attributesToChatDTO(array $attributes): ChatDTO
    {
        return ObjectHelper::init(new ChatDTO(), $attributes);
    }

    /**
     * @param array $attributes
     *
     * @return ChatRecordDTO
     */
    public static function attributesToChatRecordDTO(array $attributes): ChatRecordDTO
    {
        return ObjectHelper::init(new ChatRecordDTO(), ArrayHelper::numericToInt($attributes, ['perPage', 'page']));
    }
}
