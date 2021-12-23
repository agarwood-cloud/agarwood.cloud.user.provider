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

use App\OfficialAccount\Interfaces\DTO\Oauth\FrontEndJWTDTO;
use App\OfficialAccount\Interfaces\DTO\Oauth\JWTTokenDTO;
use App\OfficialAccount\Interfaces\DTO\Oauth\WeChatDTO;
use Agarwood\Core\Util\ArrayHelper;
use Swoft\Stdlib\Helper\ObjectHelper;

/**
 * 用户界面层  数据装配器
  *
 */
class OAuthAssembler
{
    /**
     * 微信回调 数据装配器
     *
     * @param array $attributes
     *
     * @return WeChatDTO
     */
    public static function attributesToOfficialAccountDTO(array $attributes): WeChatDTO
    {
        $attributes = ArrayHelper::numericToInt($attributes);
        return ObjectHelper::init(new WeChatDTO(), $attributes);
    }

    /**
     * JWT 后端验证
     *
     * @param array $attributes
     *
     * @return JWTTokenDTO
     */
    public static function attributesToJWTTokenDTO(array $attributes): JWTTokenDTO
    {
        return ObjectHelper::init(new JWTTokenDTO(), $attributes);
    }

    /**
     * JWT 前端验证
     *
     * @param array $attributes
     *
     * @return FrontEndJWTDTO
     */
    public static function attributesToFontEndJWTDTO(array $attributes): FrontEndJWTDTO
    {
        return ObjectHelper::init(new FrontEndJWTDTO(), $attributes);
    }
}
