<?php declare(strict_types=1);
/**
 * This file is part of Agarwood Cloud.
 *
 * @link     https://www.agarwood-cloud.com
 * @document https://www.agarwood-cloud.com/docs
 * @contact  676786620@qq.com
 * @author   agarwood
 */

namespace App\OfficialAccount\Infrastructure\Enum;

class UserEnum
{
    /**
     * 这个是扫码事件
     *
     * 扫描客服的二维码进行来的粉丝 ( 已关注的 )
     */
    public const SCAN_FROM_CUSTOMER_SUBSCRIBE = 'scan_from_customer_subscribe_';

    /**
     * 这个是扫码关注事件 ( 未关注的 ) 与 已关注的区别是多了  qrscene_
     */
    public const SCAN_FROM_CUSTOMER_UNSUBSCRIBE = 'qrscene_scan_from_customer_subscribe_';
}
