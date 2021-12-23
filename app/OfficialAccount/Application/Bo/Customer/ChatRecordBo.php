<?php declare(strict_types=1);
/**
 * This file is part of Agarwood Cloud.
 *
 * @link     https://www.agarwood-cloud.com
 * @document https://www.agarwood-cloud.com/docs
 * @contact  676786620@qq.com
 * @author   agarwood
 */

namespace App\OfficialAccount\Application\Bo\Customer;

use JsonException;

/**
 * @\Swoft\Bean\Annotation\Mapping\Bean()
 */
class ChatRecordBo
{
    /**
     * 将金额由 分 转换成为 元
     *
     * @param array $dataMap
     *
     * @return array
     * @throws JsonException
     */
    public function map(array $dataMap): array
    {
        foreach ($dataMap as &$value) {
            if (isset($value['_id'])) {
                $value['_id'] = (string)$value['_id'];
            }

            if (isset($value['data'])) {
                $value['data'] = json_decode($value['data'], true, 512, JSON_THROW_ON_ERROR);
            }
        }

        return $dataMap;
    }

    /**
     * 加入用户头像的信息
     *
     * @param array $dataMap
     * @param array $userInfo
     *
     * @return array
     */
    public function userInfo(array $dataMap, array $userInfo): array
    {
        foreach ($dataMap as $key => $item) {
            foreach ($userInfo as $value) {
                if (isset($item['openid'], $value['openid']) && ($item['openid'] === $value['openid'])) {
                    $dataMap[$key]['headImgUrl'] = $value['headImgUrl'];
                    $dataMap[$key]['nickname']   = $value['nickname'];
                }
            }
        }

        return $dataMap;
    }
}
