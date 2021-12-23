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

use App\OfficialAccount\Interfaces\DTO\Callback\DefaultDTO;
use App\OfficialAccount\Interfaces\DTO\Callback\EventDTO;
use App\OfficialAccount\Interfaces\DTO\Callback\FileDTO;
use App\OfficialAccount\Interfaces\DTO\Callback\ImageDTO;
use App\OfficialAccount\Interfaces\DTO\Callback\LinkDTO;
use App\OfficialAccount\Interfaces\DTO\Callback\LocationDTO;
use App\OfficialAccount\Interfaces\DTO\Callback\MessageSendEventDTO;
use App\OfficialAccount\Interfaces\DTO\Callback\SendXmlDTO;
use App\OfficialAccount\Interfaces\DTO\Callback\TextDTO;
use App\OfficialAccount\Interfaces\DTO\Callback\VideoDTO;
use App\OfficialAccount\Interfaces\DTO\Callback\VoiceDTO;
use Agarwood\Core\Util\ArrayHelper;
use Swoft\Stdlib\Helper\ObjectHelper;

/**
 * 对象组装器，负责数据传输对象与领域对象相互转换，不对外暴露
  *
 */
class CallbackAssembler
{
    /**
     * 事件消息装配器
     *
     * @param array $attributes
     *
     * @return EventDTO
     */
    public static function attributesToEventDTO(array $attributes): EventDTO
    {
        return ObjectHelper::init(new EventDTO(), ArrayHelper::numericToInt($attributes, ['CreateTime', 'MsgId', 'MsgID']));
    }

    /**
     * 文本消息装配器
     *
     * @param array $attributes
     *
     * @return TextDTO
     */
    public static function attributesToTextDTO(array $attributes): TextDTO
    {
        return ObjectHelper::init(new TextDTO(), ArrayHelper::numericToInt($attributes, ['CreateTime', 'MsgId', 'MsgID']));
    }

    /**
     * 图片消息装配器
     *
     * @param array $attributes
     *
     * @return ImageDTO
     */
    public static function attributesToImageDTO(array $attributes): ImageDTO
    {
        return ObjectHelper::init(new ImageDTO(), ArrayHelper::numericToInt($attributes, ['CreateTime', 'MsgId', 'MsgID']));
    }

    /**
     * 声音消息装配器
     *
     * @param array $attributes
     *
     * @return VoiceDTO
     */
    public static function attributesToVoiceDTO(array $attributes): VoiceDTO
    {
        return ObjectHelper::init(new VoiceDTO(), ArrayHelper::numericToInt($attributes, ['CreateTime', 'MsgId', 'MsgID']));
    }

    /**
     * 视频消息装配器
     *
     * @param array $attributes
     *
     * @return VideoDTO
     */
    public static function attributesToVideoDTO(array $attributes): VideoDTO
    {
        return ObjectHelper::init(new VideoDTO(), ArrayHelper::numericToInt($attributes, ['CreateTime', 'MsgId', 'MsgID']));
    }

    /**
     * 坐标消息装配器
     *
     * @param array $attributes
     *
     * @return LocationDTO
     */
    public static function attributesToLocationDTO(array $attributes): LocationDTO
    {
        return ObjectHelper::init(new LocationDTO(), ArrayHelper::numericToInt($attributes, ['CreateTime', 'MsgId', 'MsgID']));
    }

    /**
     * 链接消息装配器
     *
     * @param array $attributes
     *
     * @return LinkDTO
     */
    public static function attributesToLinkDTO(array $attributes): LinkDTO
    {
        return ObjectHelper::init(new LinkDTO(), ArrayHelper::numericToInt($attributes, ['CreateTime', 'MsgId', 'MsgID']));
    }

    /**
     * 文件消息装配器
     *
     * @param array $attributes
     *
     * @return FileDTO
     */
    public static function attributesToFileDTO(array $attributes): FileDTO
    {
        return ObjectHelper::init(new FileDTO(), ArrayHelper::numericToInt($attributes, ['CreateTime', 'MsgId', 'MsgID']));
    }

    /**
     * 默认消息装配器
     *
     * @param array $attributes
     *
     * @return DefaultDTO
     */
    public static function attributesToDefaultDTO(array $attributes): DefaultDTO
    {
        return ObjectHelper::init(new DefaultDTO(), ArrayHelper::numericToInt($attributes, ['CreateTime', 'MsgId', 'MsgID']));
    }

    /**
     * 消息转发
     *
     * @param array $attributes
     *
     * @return SendXmlDTO
     */
    public static function attributesToSendXmlDTO(array $attributes): SendXmlDTO
    {
        return ObjectHelper::init(new SendXmlDTO(), ArrayHelper::numericToInt($attributes, ['CreateTime', 'MsgId', 'MsgID']));
    }

    /**
     * @param array $attributes
     *
     * @return \App\OfficialAccount\Interfaces\DTO\Callback\MessageSendEventDTO
     */
    public static function attributesToMassSendJobFinishEventDTO(array $attributes): MessageSendEventDTO
    {
        $targetValue = ['CreateTime', 'MsgId', 'MsgID', 'TotalCount', 'FilterCount', 'SentCount', 'ErrorCount'];
        return ObjectHelper::init(new MessageSendEventDTO(), ArrayHelper::numericToInt($attributes, $targetValue));
    }
}
