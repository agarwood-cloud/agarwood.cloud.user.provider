<?php declare(strict_types=1);
/**
 * This file is part of Agarwood Cloud.
 *
 * @link     https://www.agarwood-cloud.com
 * @document https://www.agarwood-cloud.com/docs
 * @contact  676786620@qq.com
 * @author   agarwood
 */

namespace App\Customer\Domain\Impl;

use App\Assign\Domain\Aggregate\Enum\AssignEnum;
use App\Assign\Domain\Aggregate\Enum\BaseAssignStrategyEnum;
use App\Customer\Domain\Aggregate\Repository\CustomerAssignRepository;
use App\Customer\Domain\Aggregate\Repository\CustomerCommandRepository;
use App\Customer\Domain\Aggregate\Repository\CustomerQueryRepository;
use App\Customer\Domain\Aggregate\Repository\DepartmentRepository;
use App\Customer\Domain\CustomerDomain;
use App\Customer\Interfaces\DTO\Customer\ChangeStatusDTO;
use App\Customer\Interfaces\DTO\Customer\ChatDTO;
use App\Customer\Interfaces\DTO\Customer\ChatRecordDTO;
use App\Customer\Interfaces\DTO\Customer\UpdateDTO;
use App\Customer\Interfaces\DTO\Customer\LoginDTO;
use App\Customer\Interfaces\Rpc\Client\MallCenter\OfficialAccountsRpc;
use App\OfficialAccount\Infrastructure\Enum\UserEnum;
use App\OfficialAccount\Infrastructure\NoSQL\Enum\MongoDBEnum;
use Agarwood\Core\Exception\ForbiddenException;
use JsonException;
use MongoDB\Client;
use Swoft\Db\Exception\DbException;
use Swoft\Redis\Redis;
use Agarwood\WeChat\Factory\WeChat;

/**
 * @\Swoft\Bean\Annotation\Mapping\Bean()
 */
class CustomerDomainImpl implements CustomerDomain
{
    /**
     * @\Swoft\Bean\Annotation\Mapping\Inject()
     *
     * @var \App\Customer\Interfaces\Rpc\Client\MallCenter\OfficialAccountsRpc
     */
    protected OfficialAccountsRpc $officialAccountsRpc;

    /**
     * @\Swoft\Bean\Annotation\Mapping\Inject()
     *
     * @var \Agarwood\WeChat\Factory\WeChat
     */
    protected WeChat $wechat;

    /**
     * @\Swoft\Bean\Annotation\Mapping\Inject()
     *
     * @var \App\Customer\Domain\Aggregate\Repository\CustomerQueryRepository
     */
    protected CustomerQueryRepository $customerQueryRepository;

    /**
     * @\Swoft\Bean\Annotation\Mapping\Inject()
     *
     * @var \App\Customer\Domain\Aggregate\Repository\CustomerAssignRepository
     */
    protected CustomerAssignRepository $customerAssignRepository;

    /**
     * @\Swoft\Bean\Annotation\Mapping\Inject()
     *
     * @var \App\Customer\Domain\Aggregate\Repository\DepartmentRepository
     */
    protected DepartmentRepository $departmentRepository;

    /**
     * @\Swoft\Bean\Annotation\Mapping\Inject()
     *
     * @var \App\Customer\Domain\Aggregate\Repository\CustomerCommandRepository
     */
    public CustomerCommandRepository $customerCommandRepository;

    /**
     * @param int   $officialAccountId
     * @param array $filter
     *
     * @return array
     */
    public function index(int $officialAccountId, array $filter): array
    {
        return $this->customerQueryRepository->index($officialAccountId, $filter);
    }

    /**
     * @param int   $officialAccountId
     * @param array $attributes
     *
     * @return bool
     */
    public function create(int $officialAccountId, array $attributes): bool
    {
        return $this->customerCommandRepository->create($officialAccountId, $attributes);
    }

    /**
     * @param int       $id
     * @param UpdateDTO $DTO
     *
     * @return array
     * @throws DbException
     */
    public function update(int $id, UpdateDTO $DTO): array
    {
        //如果请求参数中不存在，则恢复为默认值
        $this->customerCommandRepository->update($id, $DTO->toArrayNotNull());

        //重新查找并返回结果集
        return $this->customerQueryRepository->view($id);
    }

    /**
     * @param int $id
     *
     * @return array
     */
    public function view(int $id): array
    {
        return $this->customerQueryRepository->view($id);
    }

    /**
     * @param string $ids
     *
     * @return int
     */
    public function delete(string $ids): int
    {
        return $this->customerCommandRepository->delete($ids);
    }

    /**
     * @param int $officialAccountId
     * @param int $customerId
     *
     * @return array
     */
    public function scanSubscribe(int $officialAccountId, int $customerId): array
    {
        // 这里获取实例
        $app    = $this->officialAccountsRpc->officialAccountApplication($officialAccountId);

        //生成临时图片
        $result = $app->qrcode->temporary(UserEnum::SCAN_FROM_CUSTOMER_SUBSCRIBE . $customerId, 7 * 24 * 3600);
        if (is_array($result) && isset($result['ticket']) && is_string($result['ticket'])) {
            return ['url' => $app->qrcode->url($result['ticket'])];
        }
        return ['url' => ''];
    }

    /**
     * 更新客服账号信息
     *
     * @param int             $id
     * @param ChangeStatusDTO $DTO
     *
     * @return array
     */
    public function changeStatus(int $id, ChangeStatusDTO $DTO): array
    {
        $this->customerCommandRepository->update($id, $DTO->toArrayLine());
        //重新查找并返回结果集
        return $this->customerQueryRepository->view($id);
    }

    /**
     * 删除抢粉的客服
     *
     * @param int    $officialAccountId
     * @param string $ids
     *
     * @return array
     */
    public function obtainOffline(int $officialAccountId, string $ids): array
    {
        // 读取集合里面，正在抢粉的信息
        Redis::sRem(AssignEnum::OFFICIAL_ACCOUNTS_ONLINE_LIST . $officialAccountId, $ids);

        // 查找需要删除的客服所在的部门
        $department = $this->customerAssignRepository->getCustomerDepartment($ids);

        // 删除抢粉集合 及 有集合里面的抢粉信息
        foreach ($department as $value) {
            foreach (explode(',', $ids) as $id) {
                // 删除综合竞争力抢粉的
                Redis::zRem(BaseAssignStrategyEnum::OFFICIAL_ACCOUNTS_OBTAIN_SETS_LIST . $value, $id);

                // 删除基础数优化抢粉的
                Redis::lRem(BaseAssignStrategyEnum::OFFICIAL_ACCOUNTS_ONLINE_BASE_LIST . $value, $id, 0);
            }
        }
        return ['删除成功'];
    }

    /**
     * 领域服务接口： 登陆
     *
     * @param LoginDTO $DTO
     *
     * @return array
     */
    public function login(LoginDTO $DTO): array
    {
        // 查找用户
        $user = $this->customerQueryRepository->login($DTO);

        // 验证密码是否正确
        if ($user && password_verify($DTO->getPassword(), $user['password'])) {
            // 生成对应的jwt-token值
            $token = $this->jwt->builder($user['id'])
                ->extendBuilder('id', $user['id'])
                ->extendBuilder('account', $user['account'])
                ->extendBuilder('name', $user['name'])
                ->extendBuilder('serviceId', $user['serviceId'])
                ->token();

            // 删除密码，不返回给前端
            unset($user['password']);

            return array_merge(
                $user,
                ['token' => $token]
            );
        }

        // 这里是验证不通过的
        throw new ForbiddenException('账号密码不正确...');
    }

    /**
     * 聊天列表
     *
     * @param int     $customerId
     * @param Client  $client
     * @param ChatDTO $DTO
     *
     * @return array
     * @throws JsonException
     */
    public function chat(int $customerId, Client $client, ChatDTO $DTO): array
    {
        $document = MongoDBEnum::MONGODB_DOCUMENT_PREFIX . $DTO->getYear();

        if ($DTO->getMonth() >= 10) {
            $collectionName = MongoDBEnum::MONGODB_COLLECTION_PREFIX . $DTO->getMonth();
        } else {
            $collectionName = MongoDBEnum::MONGODB_COLLECTION_PREFIX . '0' . $DTO->getMonth();
        }

        $collection = $client
            ->selectDatabase($document)
            ->selectCollection($collectionName)
            ->aggregate([
                ['$match' => ['custom_uuid' => $customerId]],
                ['$project' => ['openid' => 1, 'data' => 1, 'created_time' => 1, 'send' => 1, 'is_read' => 1]],
                ['$group'   => ['_id' => '$openid', 'data' => ['$last' => '$data'], 'created_time' => ['$last' => '$created_time'], 'send' => ['$last' => '$send'], 'is_read' => ['$last' => '$is_read']]],
                ['$sort'    => ['created_time' => -1]],
                ['$skip'    => ($DTO->getPage() - 1) * $DTO->getPerPage()],
                ['$limit'   => $DTO->getPerPage()],
            ]);

        $dataList = [];
        foreach ($collection->toArray() as $item) {
            $item           = (array)$item;
            $item['openid'] = $item['_id'];
            unset($item['_id']);
            if (isset($item['data'])) {
                $item['data'] = json_decode($item['data'], true, 512, JSON_THROW_ON_ERROR);
            }
            $dataList[] = $item;
        }

        return $dataList;
    }

    /**
     * 获取粉丝的聊天记录
     *
     * @param int           $customerId
     * @param Client        $client
     * @param ChatRecordDTO $DTO
     * @param array         $month
     *
     * @return array
     */
    public function chatRecord(int $customerId, Client $client, ChatRecordDTO $DTO, array $month): array
    {
        // 查询的总条数
        $count = 0;

        // 偏移量
        $offset = ($DTO->getPage() - 1) * $DTO->getPerPage();

        // 数据保存
        $dataList = [];

        // 查询条件
        $filter = ['openid' => $DTO->getOpenid()];

        // 时间区间查询
        $filter['created_time'] = ['$gte' => $DTO->getStartAt(), '$lt' => $DTO->getEndAt()];

        $month = array_reverse($month);

        foreach ($month as $monthItem) {

            // 文档
            $document = MongoDBEnum::MONGODB_DOCUMENT_PREFIX . $monthItem['year'];

            // 集合
            if ((int)$monthItem['month'] >= 10) {
                $collectionName = MongoDBEnum::MONGODB_COLLECTION_PREFIX . $monthItem['month'];
            } else {
                $collectionName = MongoDBEnum::MONGODB_COLLECTION_PREFIX . '0' . $monthItem['month'];
            }

            // 查询数据
            $collection = $client->{$document}->{$collectionName};

            // 当前集合条数
            $currentCount = $collection->countDocuments($filter);

            // 总条数
            $count += $currentCount;
            // 判断数量是否已经到达偏移量
            if ($count > $offset) {
                // 那就可以开始查数据了
                $option = [
                    // 当前集合偏移量 = 当前集合总数 - (当前总数 - (初始偏移量 + 已获取数组长度))
                    'skip'  => ($skip = $currentCount - ($count - ($offset + count($dataList)))) < 0 ? 0 : $skip, // 偏移量
                    'limit' => $DTO->getPerPage() - count($dataList),
                    'sort'  => ['created_time' => -1]
                ];

                $data = $collection->find($filter, $option)->toArray();

                // todo 待优化
                $dataList = array_merge($dataList, $data);

                // 如果查询书已经够了则退出循环
                if (count($dataList) >= $DTO->getPerPage()) {
                    break;
                }
            }
        }

        return $dataList;
    }

    /**
     * 清除抢粉信息
     *
     * @param int $officialAccountId
     *
     * @return array
     */
    public function obtainFansOffline(int $officialAccountId): array
    {
        // 删除公众号的客服在线集合
        $department = $this->departmentRepository->getAllDepartments($officialAccountId);

        foreach ($department as $key => $value) {
            // 这里是删除综合竞争力抢粉的
            Redis::del(BaseAssignStrategyEnum::OFFICIAL_ACCOUNTS_OBTAIN_SETS_LIST . $value['id']);

            // 这里是删除基础优化抢粉的
            Redis::del(BaseAssignStrategyEnum::OFFICIAL_ACCOUNTS_ONLINE_BASE_LIST . $value['id']);
        }

        // 删除该公众号下的所有部门集合
        Redis::del(BaseAssignStrategyEnum::OFFICIAL_ACCOUNTS_OBTAIN_SETS_LIST . $officialAccountId);

        // 删除公众号基础抢粉的队列
        Redis::del(BaseAssignStrategyEnum::OFFICIAL_ACCOUNTS_ONLINE_BASE_LIST . $officialAccountId);

        // TODO 这里没有做判断
        return ['msg' => '删除成功'];
    }

    /**
     * 抢粉状态
     *
     * @param int $officialAccountId
     * @param int $id
     *
     * @return bool
     */
    public function obtainStatus(int $officialAccountId, int $id): bool
    {
        return Redis::sIsMember(AssignEnum::OFFICIAL_ACCOUNTS_ONLINE_LIST . $officialAccountId, (string)$id);
    }
}
