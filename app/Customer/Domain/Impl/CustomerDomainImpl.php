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

use Agarwood\Core\WeChat\Factory\WeChat;
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
use App\Customer\Interfaces\Rpc\Client\MallCenter\OfficialAccountsRpc;
use App\OfficialAccount\Infrastructure\Enum\UserEnum;
use App\OfficialAccount\Infrastructure\NoSQL\Enum\MongoDBEnum;
use JsonException;
use MongoDB\Client;
use Swoft\Db\Exception\DbException;
use Swoft\Redis\Redis;

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
     * @var \Agarwood\Core\WeChat\Factory\WeChat
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
     * @param int   $platformId
     * @param array $filter
     *
     * @return array
     */
    public function index(int $platformId, array $filter): array
    {
        return $this->customerQueryRepository->index($platformId, $filter);
    }

    /**
     * @param int   $platformId
     * @param array $attributes
     *
     * @return bool
     */
    public function create(int $platformId, array $attributes): bool
    {
        return $this->customerCommandRepository->create($platformId, $attributes);
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
        //??????????????????????????????????????????????????????
        $this->customerCommandRepository->update($id, $DTO->toArrayNotNull());

        //??????????????????????????????
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
     * @param int $platformId
     * @param int $customerId
     *
     * @return array
     */
    public function scanSubscribe(int $platformId, int $customerId): array
    {
        // ??????????????????
        $app    = $this->officialAccountsRpc->officialAccountApplication($platformId);

        //??????????????????
        $result = $app->qrcode->temporary(UserEnum::SCAN_FROM_CUSTOMER_SUBSCRIBE . $customerId, 7 * 24 * 3600);
        if (is_array($result) && isset($result['ticket']) && is_string($result['ticket'])) {
            return ['url' => $app->qrcode->url($result['ticket'])];
        }
        return ['url' => ''];
    }

    /**
     * ????????????????????????
     *
     * @param int             $id
     * @param ChangeStatusDTO $DTO
     *
     * @return array
     */
    public function changeStatus(int $id, ChangeStatusDTO $DTO): array
    {
        $this->customerCommandRepository->update($id, $DTO->toArrayLine());
        //??????????????????????????????
        return $this->customerQueryRepository->view($id);
    }

    /**
     * ?????????????????????
     *
     * @param int    $platformId
     * @param string $ids
     *
     * @return array
     */
    public function obtainOffline(int $platformId, string $ids): array
    {
        // ??????????????????????????????????????????
        Redis::sRem(AssignEnum::OFFICIAL_ACCOUNTS_ONLINE_LIST . $platformId, $ids);

        // ??????????????????????????????????????????
        $department = $this->customerAssignRepository->getCustomerDepartment($ids);

        // ?????????????????? ??? ??????????????????????????????
        foreach ($department as $value) {
            foreach (explode(',', $ids) as $id) {
                // ??????????????????????????????
                Redis::zRem(BaseAssignStrategyEnum::OFFICIAL_ACCOUNTS_OBTAIN_SETS_LIST . $value, $id);

                // ??????????????????????????????
                Redis::lRem(BaseAssignStrategyEnum::OFFICIAL_ACCOUNTS_ONLINE_BASE_LIST . $value, $id, 0);
            }
        }
        return ['????????????'];
    }

    /**
     * ????????????
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
     * ???????????????????????????
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
        // ??????????????????
        $count = 0;

        // ?????????
        $offset = ($DTO->getPage() - 1) * $DTO->getPerPage();

        // ????????????
        $dataList = [];

        // ????????????
        $filter = ['openid' => $DTO->getOpenid()];

        // ??????????????????
        $filter['created_time'] = ['$gte' => $DTO->getStartAt(), '$lt' => $DTO->getEndAt()];

        $month = array_reverse($month);

        foreach ($month as $monthItem) {

            // ??????
            $document = MongoDBEnum::MONGODB_DOCUMENT_PREFIX . $monthItem['year'];

            // ??????
            if ((int)$monthItem['month'] >= 10) {
                $collectionName = MongoDBEnum::MONGODB_COLLECTION_PREFIX . $monthItem['month'];
            } else {
                $collectionName = MongoDBEnum::MONGODB_COLLECTION_PREFIX . '0' . $monthItem['month'];
            }

            // ????????????
            $collection = $client->{$document}->{$collectionName};

            // ??????????????????
            $currentCount = $collection->countDocuments($filter);

            // ?????????
            $count += $currentCount;
            // ???????????????????????????????????????
            if ($count > $offset) {
                // ??????????????????????????????
                $option = [
                    // ????????????????????? = ?????????????????? - (???????????? - (??????????????? + ?????????????????????))
                    'skip'  => ($skip = $currentCount - ($count - ($offset + count($dataList)))) < 0 ? 0 : $skip, // ?????????
                    'limit' => $DTO->getPerPage() - count($dataList),
                    'sort'  => ['created_time' => -1]
                ];

                $data = $collection->find($filter, $option)->toArray();

                // todo ?????????
                $dataList = array_merge($dataList, $data);

                // ??????????????????????????????????????????
                if (count($dataList) >= $DTO->getPerPage()) {
                    break;
                }
            }
        }

        return $dataList;
    }

    /**
     * ??????????????????
     *
     * @param int $platformId
     *
     * @return array
     */
    public function obtainFansOffline(int $platformId): array
    {
        // ????????????????????????????????????
        $department = $this->departmentRepository->getAllDepartments($platformId);

        foreach ($department as $key => $value) {
            // ???????????????????????????????????????
            Redis::del(BaseAssignStrategyEnum::OFFICIAL_ACCOUNTS_OBTAIN_SETS_LIST . $value['id']);

            // ????????????????????????????????????
            Redis::del(BaseAssignStrategyEnum::OFFICIAL_ACCOUNTS_ONLINE_BASE_LIST . $value['id']);
        }

        // ??????????????????????????????????????????
        Redis::del(BaseAssignStrategyEnum::OFFICIAL_ACCOUNTS_OBTAIN_SETS_LIST . $platformId);

        // ????????????????????????????????????
        Redis::del(BaseAssignStrategyEnum::OFFICIAL_ACCOUNTS_ONLINE_BASE_LIST . $platformId);

        // TODO ?????????????????????
        return ['msg' => '????????????'];
    }

    /**
     * ????????????
     *
     * @param int $platformId
     * @param int $id
     *
     * @return bool
     */
    public function obtainStatus(int $platformId, int $id): bool
    {
        return Redis::sIsMember(AssignEnum::OFFICIAL_ACCOUNTS_ONLINE_LIST . $platformId, (string)$id);
    }
}
