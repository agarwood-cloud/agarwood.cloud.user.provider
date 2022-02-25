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

use App\Customer\Domain\Aggregate\Entity\CustomerGroup;
use App\Customer\Domain\Aggregate\Entity\FansGroup;
use App\Customer\Domain\Aggregate\Repository\GroupRepository;
use App\Customer\Domain\GroupDomainService;
use Agarwood\Core\Exception\InvalidParameterException;
use Swoft\Db\Exception\DbException;

/**
 * @\Swoft\Bean\Annotation\Mapping\Bean()
 */
class GroupDomainServiceImpl implements GroupDomainService
{
    /**
     * @\Swoft\Bean\Annotation\Mapping\Inject()
     *
     * @var GroupRepository $groupRepository
     */
    protected GroupRepository $groupRepository;

    /**
     * @inheritDoc
     * @throws DbException
     */
    public function customerIndex(int $tencentId, array $filter, bool $isPagination = true): array
    {
        //第一页的数据
        $firstPage = $this->groupRepository->customerGroupFirstPage($tencentId, $filter, $isPagination);

        //第二级
        $secondUuid = array_column($firstPage['list'], 'id');
        $son        = $this->groupRepository->getCustomerGroupByUuid($secondUuid);

        //第三级
        $grandson = [];
        if (!empty($son)) {
            $threeUuid = array_column($son, 'id');
            $grandson  = $this->groupRepository->getCustomerGroupByUuid($threeUuid);
        }

        //合并数组
        $firstPage['list'] = array_merge($firstPage['list'], $son, $grandson);

        //组成树型
        $firstPage['list'] = $this->getTree($firstPage['list'], '');

        return $firstPage;
    }

    /**
     * @inheritDoc
     */
    public function customerCreate(array $attributes): CustomerGroup
    {
        return $this->groupRepository->createCustomerGroup($attributes);
    }

    /**
     * @inheritDoc
     */
    public function fansCreate(array $attributes): FansGroup
    {
        return $this->groupRepository->createFansGroup($attributes);
    }

    /**
     * @inheritDoc
     * @throws DbException
     */
    public function customerUpdate(string $id, $DTO): ?CustomerGroup
    {
        //检查是否存在
        $group = $this->groupRepository->findCustomerGroupByUuid($id);
        if (!$group) {
            throw new InvalidParameterException('查无此id对应的分组信息');
        }

        //如果请求参数中不存在，则恢复为默认值
        $attributes = $DTO->toArrayNotNull();
        $this->groupRepository->updateCustomerGroup($id, $attributes);

        //重新查找并返回结果集
        return $this->groupRepository->findCustomerGroupByUuid($id);
    }

    /**
     * @inheritDoc
     * @throws DbException
     */
    public function fansUpdate(string $id, $DTO): ?FansGroup
    {
        //检查是否存在
        $group = $this->groupRepository->findFansGroupByUuid($id);
        if (!$group) {
            throw new InvalidParameterException('查无此id对应的分组信息');
        }

        //如果请求参数中不存在，则恢复为默认值
        $attributes = $DTO->toArrayNotNull([], true);
        $this->groupRepository->updateFansGroup($id, $attributes);

        //重新查找并返回结果集
        return $this->groupRepository->findFansGroupByUuid($id);
    }

    /**
     * @inheritDoc
     * @throws DbException
     */
    public function customerView(int $id): array
    {
        if (!$view = $this->groupRepository->viewCustomerGroup($id)) {
            throw new InvalidParameterException('查无此id对应的分组信息');
        }
        return $view->toArray();
    }

    /**
     * @inheritDoc
     * @throws DbException
     */
    public function fansView(int $id): array
    {
        if (!$view = $this->groupRepository->viewFansGroup($id)) {
            throw new InvalidParameterException('查无此id对应的分组信息');
        }
        return $view->toArray();
    }

    /**
     * @inheritDoc
     */
    public function customerDelete(int $id): ?bool
    {
        return $this->groupRepository->deleteCustomerGroup($id);
    }

    /**
     * @inheritDoc
     */
    public function fansDelete(int $id): ?bool
    {
        return $this->groupRepository->deleteFansGroup($id);
    }

    /**
     * 树型结构
     *
     * @param $data
     * @param $pId
     *
     * @return array
     */
    protected function getTree($data, $pId): array
    {
        $tree = [];
        foreach ($data as $k => $v) {
            if ($v['pUuid'] === $pId) {
                //父亲找到儿子
                $v['son'] = $this->getTree($data, $v['id']);
                $tree[]   = $v;
                unset($data[$k]);
            }
        }
        return $tree;
    }

    /**
     * @inheritDoc
     * @throws DbException
     */
    public function fansIndex(int $tencentId, array $filter, bool $isPagination = true): array
    {
        //第一页的数据
        $firstPage = $this->groupRepository->fansGroupFirstPage($tencentId, $filter, $isPagination);

        //第二级
        $secondUuid = array_column($firstPage['list'], 'id');
        $son        = $this->groupRepository->getFansGroupByUuid($tencentId, $secondUuid);

        //第三级
        $grandson = [];
        if (!empty($son)) {
            $threeUuid = array_column($son, 'id');
            $grandson  = $this->groupRepository->getFansGroupByUuid($tencentId, $threeUuid);
        }

        //合并数组
        $firstPage['list'] = array_merge($firstPage['list'], $son, $grandson);

        //组成树型
        $firstPage['list'] = $this->getTree($firstPage['list'], '');

        return $firstPage;
    }

    /**
     * 客服粉丝分组
     *
     * @param int   $tencentId
     * @param int   $customerId
     * @param array $filter
     *
     * @return array
     */
    public function customer(int $tencentId, int $customerId, array $filter): array
    {
        //第一页的数据
        $firstPage = $this->groupRepository->customerFansGroupFirstPage($tencentId, $customerId, $filter, $isPagination);

        //第二级
        $secondUuid = array_column($firstPage['list'], 'id');
        $son        = $this->groupRepository->getFansGroupByUuid($tencentId, $secondUuid);

        //第三级
        $grandson = [];
        if (!empty($son)) {
            $threeUuid = array_column($son, 'id');
            $grandson  = $this->groupRepository->getFansGroupByUuid($tencentId, $threeUuid);
        }

        //合并数组
        $firstPage['list'] = array_merge($firstPage['list'], $son, $grandson);

        //组成树型
        $firstPage['list'] = $this->getTree($firstPage['list'], '');

        return $firstPage;
    }
}
