<?php declare(strict_types=1);
/**
 * This file is part of Agarwood Cloud.
 *
 * @link     https://www.agarwood-cloud.com
 * @document https://www.agarwood-cloud.com/docs
 * @contact  676786620@qq.com
 * @author   agarwood
 */

namespace App\Customer\Infrastructure\MySQL;

use App\Customer\Domain\Aggregate\Entity\Customer;
use App\Customer\Domain\Aggregate\Repository\CustomerOverviewRepository;
use Agarwood\Core\Constant\StringConstant;
use Swoft\Db\DB;

/**
 * @\Swoft\Bean\Annotation\Mapping\Bean()
 */
class CustomerOverviewRepositoryImpl implements CustomerOverviewRepository
{
    /**
     * 管理员管理列表数据
     *
     * @param int   $officialAccountId
     * @param array $filter
     *
     * @return array
     */
    public function index(int $officialAccountId, array $filter): array
    {
        return DB::table(Customer::tableName())
            ->select(
                'id',
                'name',
                'account',
                'phone'
            )
            ->where('deleted_at', '=', StringConstant::DATE_TIME_DEFAULT)  // 未删除
            ->where('oa_id', '=', $officialAccountId)
            ->when($filter['name'], function ($query, $name) {
                return $query->where('name', 'like', '%' . $name . '%');
            })
            ->when($filter['account'], function ($query, $account) {
                return $query->where('account', 'like', '%' . $account . '%');
            })
            ->when([$filter['start_at'], $filter['end_at']], function ($query, $param) {
                return $query->whereBetween('created_at', $param);
            })
            ->paginate($filter['page'], $filter['per_page']);
    }
}
