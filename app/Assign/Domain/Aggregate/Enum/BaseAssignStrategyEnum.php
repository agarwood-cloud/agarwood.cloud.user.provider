<?php declare(strict_types=1);
/**
 * This file is part of Agarwood Cloud.
 *
 * @link     https://www.agarwood-cloud.com
 * @document https://www.agarwood-cloud.com/docs
 * @contact  676786620@qq.com
 * @author   agarwood
 */

namespace App\Assign\Domain\Aggregate\Enum;

class BaseAssignStrategyEnum extends AssignEnum
{
    /*
    |--------------------------------------------------------------------------
    | 基础数据综合竞争力分配粉丝
    |--------------------------------------------------------------------------
    |
    |    >> (1) 每个人按设置的优先数据，优先分配一定的粉丝
    |    >> (2) 当天如果超了优先分配的粉丝后，则按综合竞争力抢粉
    |
    |
    |
    */

    /**
     * 抢粉的集合
     */
    public const OFFICIAL_ACCOUNTS_OBTAIN_SETS_LIST  = 'official.accounts.obtain.sets.list.';

    /**
     *  基础抢粉的队列
     */
    public const OFFICIAL_ACCOUNTS_ONLINE_BASE_LIST = 'official.accounts.online.base.list.';
}
