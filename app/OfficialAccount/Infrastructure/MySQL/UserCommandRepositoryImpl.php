<?php declare(strict_types=1);
/**
 * This file is part of Agarwood Cloud.
 *
 * @link     https://www.agarwood-cloud.com
 * @document https://www.agarwood-cloud.com/docs
 * @contact  676786620@qq.com
 * @author   agarwood
 */

namespace App\OfficialAccount\Infrastructure\MySQL;

use App\OfficialAccount\Domain\Aggregate\Entity\User;
use App\OfficialAccount\Domain\Aggregate\Repository\UserCommandRepository;
use App\OfficialAccount\Interfaces\Assembler\UserAssembler;
use Carbon\Carbon;
use Godruoyi\Snowflake\Snowflake;
use Swoft\Db\DB;

/**
 * @\Swoft\Bean\Annotation\Mapping\Bean()
 */
class UserCommandRepositoryImpl implements UserCommandRepository
{
    /**
     * create user info
     *
     * @param array $attributes
     *
     * @return bool
     */
    public function addUserFromWeChat(array $attributes): bool
    {
        $dto = UserAssembler::attributesToCreateDTO($attributes);

        // 转
        $value = $dto->toArrayLine();

        //将时间修改为日期格式
        $value['head_img_url']    = $dto->getHeadimgurl();
        $value['subscribe']       = $attributes['subscribe'] ? 'subscribe' : 'unsubscribe';
        $value['union_id']        = $dto->getUnionid();
        $value['subscribe_scene'] = $attributes['subscribe_scene'];
        $value['created_at']      = Carbon::now()->toDateTimeString();
        $value['updated_at']      = Carbon::now()->toDateTimeString();

        // 企业id
        $value['enterprise_id'] = $attributes['enterprise_id'] ?? 0;
        $value['platform_id']   = $attributes['platform_id']   ?? 0;

        // 雪花id
        $snowflake   = new Snowflake;
        $value['id'] = (int)$snowflake->id();

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
            $value['qr_scene_str'],
            $value['language'],
            $value['remark'],
        );

        return DB::table(User::tableName())
            ->insert($value);
    }

    /**
     * update user info
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
        // $value['head_img_url'] = $attributes['headimgurl'] ?? ''; 重新关注没有头像，不需要更新
        $value['union_id']     = $attributes['unionid']    ?? '';
        $value['subscribe']    = $attributes['subscribe'] ? 'subscribe' : 'unsubscribe';

        // 删除不必要的字段
        unset(
            $value['headimgurl'],
            $value['unionid'],
            $value['subscribe_time'],
            $value['tagid_list'],
            $value['groupid'],
            $value['qr_scene'],
            $value['qr_scene_str'],
            $value['language'],
            $value['remark'],
            $value['nickname'],
        );

        return User::where('openid', '=', $openid)->update($value);
    }

    /**
     * update info by openid
     *
     * @param string $openid
     * @param array  $attributes
     *
     * @return int
     */
    public function updateByOpenid(string $openid, array $attributes): int
    {
        return DB::table(User::tableName())
            ->where('openid', '=', $openid)
            ->update($attributes);
    }

    /**
     * Delete User By Openid
     *
     * @param string $openid
     *
     * @return int
     */
    public function delete(string $openid): int
    {
        return DB::table(User::tableName())
            ->where('openid', '=', $openid)
            ->where('deleted_at', '=', Carbon::createFromTimestamp(0, 'UTC')->toDateTimeString())
            ->update(['deleted_at' => Carbon::now()->toDateTimeString()]);
    }
}
