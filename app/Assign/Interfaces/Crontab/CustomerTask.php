<?php declare(strict_types=1);
/**
 * This file is part of Agarwood Cloud.
 *
 * @link     https://www.agarwood-cloud.com
 * @document https://www.agarwood-cloud.com/docs
 * @contact  676786620@qq.com
 * @author   agarwood
 */

namespace App\Assign\Interfaces\Crontab;

use App\Assign\Domain\Aggregate\Enum\AssignEnum;
use App\Assign\Domain\Aggregate\Enum\BaseAssignStrategyEnum;
use Swoft\Redis\Redis;

/**
 * @\Swoft\Crontab\Annotaion\Mapping\Scheduled()
 */
class CustomerTask
{
    /**
     *  每天1点清空抢粉的数据
     *
     * @\Swoft\Crontab\Annotaion\Mapping\Cron("0 0 1 * * *")
     */
    public function obtainOffline(): void
    {
        // todo 这里是临时的解决方案
        $groupOnline = Redis::keys(BaseAssignStrategyEnum::OFFICIAL_ACCOUNTS_OBTAIN_SETS_LIST . '*');
        foreach ($groupOnline as $item) {
            // 这里有一个坑，这里会自动加上前缀，所以容易出问题
            Redis::del(ltrim($item, env('MASTER_REDIS_PREFIX')));
        }

        // 清除正在抢粉的人数
        $obtainFansCustomer = Redis::keys(AssignEnum::OFFICIAL_ACCOUNTS_ONLINE_LIST . '*');
        foreach ($obtainFansCustomer as $item) {

            // 这里有一个坑，这里会自动加上前缀，所以容易出问题
            Redis::del(ltrim($item, env('MASTER_REDIS_PREFIX')));
        }

        // 清除基础抢粉数据
        $baseFans = Redis::keys(BaseAssignStrategyEnum::OFFICIAL_ACCOUNTS_ONLINE_BASE_LIST . '*');
        foreach ($baseFans as $item) {

            // 这里有一个坑，这里会自动加上前缀，所以容易出问题
            Redis::del(ltrim($item, env('MASTER_REDIS_PREFIX')));
        }
    }
}
