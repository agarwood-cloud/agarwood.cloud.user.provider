<?php declare(strict_types=1);
/**
 * This file is part of Agarwood Cloud.
 *
 * @link     https://www.agarwood-cloud.com
 * @document https://www.agarwood-cloud.com/docs
 * @contact  676786620@qq.com
 * @author   agarwood
 */

namespace App\Assign\Domain\Impl;

use App\Assign\Domain\Aggregate\Enum\AssignEnum;
use App\Assign\Domain\Aggregate\Enum\BaseAssignStrategyEnum;
use App\Assign\Domain\Aggregate\Repository\AssignRepository;
use App\Assign\Domain\Aggregate\Repository\AssignSettingRepository;
use App\Assign\Domain\BaseAssignStrategy;
use Carbon\Carbon;
use Agarwood\Core\Exception\BusinessException;
use Agarwood\Core\Util\ArrayHelper;
use Exception;
use Swoft\Redis\Redis;

/**
 * @\Swoft\Bean\Annotation\Mapping\Bean()
 */
class BaseAssignStrategyImpl implements BaseAssignStrategy
{
    /**
     * @\Swoft\Bean\Annotation\Mapping\Inject()
     *
     * @var \App\Assign\Domain\Aggregate\Repository\AssignRepository
     */
    protected AssignRepository $assignRepository;

    /**
     * @\Swoft\Bean\Annotation\Mapping\Inject()
     *
     * @var \App\Assign\Domain\Aggregate\Repository\AssignSettingRepository
     */
    protected AssignSettingRepository $assignSettingRepository;

    /**
     * @inheritDoc
     * @throws Exception
     */
    public function assignCustomer(int $officialAccountId): int
    {
        // 1. 部门的抢粉信息（该公众号的所有部门的信息, 包含已排好分配粉丝的先后顺序）
        $department = $this->assignSettingRepository->getDepartments($officialAccountId);

        // 如果没有设置抢粉信息，随机分配一个客服
        if (empty($department)) {
            return $this->randomAssign($officialAccountId);
        }

        // 2. 查找最后一个要分配的部门，推断出当前要分配的部门
        $last = $this->assignRepository->lastOfficialAccountObtainFans($officialAccountId); // 最后一个抢粉的信息

        // 3. 此条件是第一次抢粉时, 如果该部门有人抢粉，则返回抢粉的
        if (empty($last)) {
            // 优先分配一个基础抢粉的列表
            foreach ($department as $item) {
                $customerId = $this->popQueue($item['id']);
                if (is_string($customerId) && $customerId) {
                    return $customerId;
                }
            }

            // 如果有一个部门在抢粉时，则返回一个客服
            foreach ($department as $item) {
                // 查找那个组别在抢粉
                $zSet = $this->popSets($item['id']);
                // 有人在抢粉时
                $customerId = array_key_first($zSet);
                if ($customerId && is_string($customerId)) {
                    return $customerId;
                }
            }

            // 当没有人在抢粉
            return $this->randomAssign($officialAccountId);
        }

        /*
        |--------------------------------------------------------------------------
        | (非第一次抢粉) department_id => rate 组成的key => value值, i.e: $depMap 如下
        |--------------------------------------------------------------------------
        |  [
        |       'dbded281-4752-4951-bc20-8f4f32b81e91' =>  5,
        |       'b3581d56-d8b3-4d52-ad58-f00000788e4b' =>  3
        |  ]
        */
        $depMap = ArrayHelper::map($department, 'id', 'rate');

        /*
        |--------------------------------------------------------------------------
        |  分配的所在分组的逻辑
        |  $depMap[$last['department_id']] ----- 预设置的部门抢粉数组           [ 部门 => 速率 ]
        |  $last['rate']                     ----- 最后一个已抢粉的部门数组       [ 部门 => 第几个抢粉 ]
        |--------------------------------------------------------------------------
        |  1. 当最后一个小于速率时，则仍然是分配当前部门
        |  2. 当最后一个抢粉等于或者大于速度时，则分配下一个分组
        */

        // 开始分配粉丝的所在组别序号
        $start = 0;

        // 目前分粉的所在分组的次序
        $departmentKey = array_column($department, 'id');

        // 当最后一个小于速率时，则仍然是分配当前部门
        if (isset($depMap[$last['department_id']]) && $depMap[$last['department_id']] > $last['rate']) {
            // 当前部门进粉数，如果小于当前的部门的进粉速率时
            $start = (int)array_search($last['department_id'], $departmentKey, true);
        }

        // 当最后一个抢粉等于或者大于速度时，则分配下一个分组
        if (isset($depMap[$last['department_id']]) && $depMap[$last['department_id']] <= $last['rate']) {
            $start = (int)array_search($last['department_id'], $departmentKey, true);
            ++$start;
        }

        // 两个数组加在一起，一个分粉的循环
        $loopDepartment = array_merge($departmentKey, $departmentKey);

        // 优先分配一个基础抢粉的列表
        $baseStart = $start;
        for ($startMax = count($loopDepartment); $baseStart < $startMax; $baseStart++) {
            $customerId = $this->popQueue($loopDepartment[$baseStart]);
            if (is_string($customerId)) {
                return $customerId;
            }
        }

        // 按优化顺序分配粉丝
        $competitiveStart = $start;
        for ($startMax = count($loopDepartment); $competitiveStart < $startMax; $competitiveStart++) {
            $zSet = $this->popSets($loopDepartment[$competitiveStart]);
            // 有人在抢粉时
            $customerId = array_key_first($zSet);
            if ($customerId && is_string($customerId)) {
                return $customerId;
            }
        }

        // 临时的解决方法是，随机分配该公众号一个客服
        return $this->randomAssign($officialAccountId);
    }

    /**
     * @inheritDoc
     */
    public function assignList(int $officialAccountId, int $customerId, int $power = 0): bool
    {
        // 2.检查是否已满足基本的抢粉数
        // $dayObtainFans 今天抢粉数量
        $dayObtainFans = $this->assignRepository->obtainFansBetweenTime(
            $customerId,
            Carbon::today()->toDateTimeString(),
            Carbon::tomorrow()->toDateTimeString()
        );

        // $dayAssignFans 每天抢粉的数量
        $customerCompetitive = $this->assignSettingRepository->hasSettingAssign($customerId);
        if (empty($customerCompetitive)) {
            throw new BusinessException('未设置圈粉信息！');
        }
        $dayAssignFans = $customerCompetitive['day_assign'];

        // 如果超过今天最大的抢粉数量，则不允许再抢粉
        if ($dayAssignFans <= $dayObtainFans) {
            throw new BusinessException('圈粉超过当天允许分配的最大值！');
        }

        // $monthFans 本月的抢粉数量
        $monthFans = $this->assignRepository->obtainFansBetweenTime(
            $customerId,
            Carbon::now()->firstOfMonth()->toDateTimeString(),
            Carbon::now()->toDateTimeString()
        );

        // 如果超过本月最大的抢粉数量，则不允许再抢粉
        if ($customerCompetitive['month_assign'] <= $monthFans) {
            throw new BusinessException('个人圈粉超过当月允许分配的最大值！');
        }

        // 客服所在的部门
        $customer = $this->assignRepository->getCustomer($customerId);
        $group    = $this->assignSettingRepository->customerGroup($customer['group_id']);

        if (empty($group)) {
            throw new BusinessException('未分配部门，无法圈粉！');
        }
        // 部门每天的最大限制
        $departDayFans = $this->assignRepository->obtainFansBetweenTimeByDepartment(
            $group['department_id'],
            Carbon::today()->toDateTimeString(),
            Carbon::tomorrow()->toDateTimeString()
        );

        // 部门每月的最大限制
        $departMontFans = $this->assignRepository->obtainFansBetweenTimeByDepartment(
            $group['department_id'],
            Carbon::now()->firstOfMonth()->toDateTimeString(),
            Carbon::now()->toDateTimeString()
        );

        $departmentArray = $this->assignSettingRepository->customerCompetitiveDepartment($group['department_id']);
        if (($departmentArray && ($departDayFans >= $departmentArray['day_assign'])) || ($departMontFans >= $departmentArray['month_assign'])) {
            throw new BusinessException('该部门已超过当天或者当月最大假分粉限制，无法圈粉！');
        }

        // 3. 记录正在抢粉的客服
        $this->pushSetsStatus($officialAccountId, $customerId);

        // 4. 优先根据基础抢粉数，如果未达到基础抢粉数，则加入到基础抢粉的队列
        if ($dayObtainFans < $customerCompetitive['base_fans']) {
            // 当未达到基础分数时, 加入到基础抢粉的队列，左进右出
            $this->pushQueue($group['department_id'], $customerId);
            return true;
        }

        /*
        |--------------------------------------------------------------------------
        | 如果score 一样时，redis是按字典排序的，[此情况是设置平均抢粉]
        |--------------------------------------------------------------------------
        | 解决方法是: 增加小数点
        |   1. 明天0点的时间戳 - 现在的时间戳 作为小数点后面几位数（精确到秒）
        |   2. 这样就可以保证随着当天内随着时间的增加，值越来越小
        |
        |   Tips: 此方法精确到秒
        */

        $point = ((float)Carbon::tomorrow()->timestamp - (float)Carbon::now()->timestamp) / 100000;

        // 综合竞争力 + 小数
        $power += $point;

        // 为了避免多次点击，相同分数会被一直排在后面的问题，故如果整数部分相同，则不再更新队列
        $powerSorted = $this->hasSets($group['department_id'], $customerId);

        if ($powerSorted && ((int)$powerSorted === (int)$power)) {
            // return (int)$power;
            return true;
        }

        // 4.根据不同的综合竞争力，加入抢粉队列
        $this->pushSets($group['department_id'], $customerId, $power);

        return true;
    }

    /**
     * @inheritDoc
     */
    public function pushSets(int $departmentId, int $customerId, float $power): void
    {
        Redis::zAdd(
            BaseAssignStrategyEnum::OFFICIAL_ACCOUNTS_OBTAIN_SETS_LIST . $departmentId,
            [$customerId => $power]
        );
    }

    /**
     * @inheritDoc
     */
    public function popSets(int $departmentId): array
    {
        return Redis::zPopMax(BaseAssignStrategyEnum::OFFICIAL_ACCOUNTS_OBTAIN_SETS_LIST . $departmentId, 1);
    }

    /**
     * @inheritDoc
     */
    public function hasSets(int $departmentId, int $customerId): float|bool
    {
        return Redis::zScore(BaseAssignStrategyEnum::OFFICIAL_ACCOUNTS_OBTAIN_SETS_LIST . $departmentId, $customerId);
    }

    /**
     * @inheritDoc
     */
    public function pushQueue(int $departmentId, int $customerId): void
    {
        Redis::lPush(BaseAssignStrategyEnum::OFFICIAL_ACCOUNTS_ONLINE_BASE_LIST . $departmentId, (string)$customerId);
    }

    /**
     * @inheritDoc
     */
    public function popQueue(int $departmentId): string|bool
    {
        $customerUuid = Redis::rPop(BaseAssignStrategyEnum::OFFICIAL_ACCOUNTS_ONLINE_BASE_LIST . $departmentId);

        // 删除重复的数据
        if (is_string($customerUuid) && $customerUuid) {
            Redis::lRem(BaseAssignStrategyEnum::OFFICIAL_ACCOUNTS_ONLINE_BASE_LIST . $departmentId, $customerUuid, 0);
        }

        return $customerUuid;
    }

    /**
     * @inheritDoc
     * @throws Exception
     */
    public function randomAssign(int $officialAccountId): int
    {
        // 临时的解决方法是，随机分配该公众号一个客服
        $customerAll = array_column($this->assignRepository->getCustomerUuidByServiceUuid($officialAccountId), 'id');

        // 如果不存在客服信息则返回空值
        if (empty($customerAll)) {
            return 0;
        }

        // 如果存在客服的情况
        return $customerAll[random_int(0, count($customerAll) - 1)];
    }

    /**
     * @inheritDoc
     */
    public function pushSetsStatus(int $officialAccountId, int $customerId): void
    {
        Redis::sAdd(AssignEnum::OFFICIAL_ACCOUNTS_ONLINE_LIST . $officialAccountId, (string)$customerId);
    }
}
