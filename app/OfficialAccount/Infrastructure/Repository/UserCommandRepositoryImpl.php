<?php declare(strict_types=1);
/**
 * This file is part of Agarwood Cloud.
 *
 * @link     https://www.agarwood-cloud.com
 * @document https://www.agarwood-cloud.com/docs
 * @contact  676786620@qq.com
 * @author   agarwood
 */

namespace App\OfficialAccount\Infrastructure\Repository;

use App\OfficialAccount\Domain\Aggregate\Entity\User;
use App\OfficialAccount\Domain\Aggregate\Repository\UserCommandRepository;
use App\OfficialAccount\Interfaces\Assembler\UserAssembler;
use Carbon\Carbon;

/**
 * @\Swoft\Bean\Annotation\Mapping\Bean()
 */
class UserCommandRepositoryImpl implements UserCommandRepository
{
    /**
     * 新建用户
     *
     * @param array $attributes
     *
     * @return bool
     */
    public function addUserFromWeChat(array $attributes): bool
    {
        $dto = UserAssembler::attributesToCreateDTO($attributes);

        // 转
        $value = $dto->toArrayNotNull([], true);

        //将时间修改为日期格式
        $value['head_img_url'] = $dto->getHeadImgUrl();
        $value['subscribe']    = $attributes['subscribe'] ? 'subscribe' : 'unsubscribe';
        $value['union_id']     = $dto->getUnionId();

        // 关注时间
        if ($dto->getSubscribeTime() > 0) {
            $value['subscribe_at'] = Carbon::createFromTimestamp($dto->getSubscribeTime(), 'PRC')->toDateTimeString();
        } else {
            $value['subscribe_at'] = Carbon::now()->toDateTimeString();
        }

        // 删除不必要的字段
        unset(
            $value['headimgurl'],
            $value['unionid'],
            $value['subscribe_time'],
            $value['tagid_list'],
            $value['groupid'],
            $value['qr_scene'],
            $value['qr_scene_str']
        );

        return User::new($value)->save();
    }

    /**
     * 更新用户信息
     *
     * @param string $openid
     * @param array  $attributes
     *
     * @return int
     */
    public function updateByOpenidFromWeChat(string $openid, array $attributes): int
    {
        $dto = UserAssembler::attributesToUpdateDTO($attributes);

        // 转
        $value = $dto->toArrayNotNull([], true);

        // 处理不对应的字段
        $value['head_img_url'] = $dto->getHeadImgUrl() ?? '';

        // 删除不必要的字段
        unset(
            $value['headimgurl'],
            $value['unionid'],
            $value['subscribe_time'],
            $value['tagid_list'],
            $value['groupid'],
            $value['qr_scene'],
            $value['qr_scene_str']
        );

        return User::where('openid', '=', $openid)->update($value);
    }

    /**
     * @param string $openid
     * @param array  $attributes
     *
     * @return int
     */
    public function updateByOpenid(string $openid, array $attributes): int
    {
        return User::where('openid', '=', $openid)->update($attributes);
    }
}
