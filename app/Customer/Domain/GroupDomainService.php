<?php declare(strict_types=1);
/**
 * This file is part of Agarwood Cloud.
 *
 * @link     https://www.agarwood-cloud.com
 * @document https://www.agarwood-cloud.com/docs
 * @contact  676786620@qq.com
 * @author   agarwood
 */

namespace App\Customer\Domain;

use App\Customer\Domain\Aggregate\Entity\CustomerGroup;
use App\Customer\Domain\Aggregate\Entity\FansGroup;
use App\Customer\Interfaces\DTO\Group\CustomerGroupUpdateDTO;
use App\Customer\Interfaces\DTO\Group\FansGroupUpdateDTO;

interface GroupDomainService
{
    /**
     *  获取列表
     *
     *  粉丝分组列表数据（最多支持三级分类）
     *
     * //第一步，先取出第一页的顶级元素
     * //第二步，把与顶级相关的相关的二级，三级分类取出来（最多支持三级）
     * //第三步，组成树型结构
     *
     * @param int $tencentId
     * @param array  $filter 过滤条件
     *
     * @return array
     */
    public function customerIndex(int $tencentId, array $filter): array;

    /**
     *  获取列表
     *
     *  粉丝分组列表数据（最多支持三级分类）
     *
     * //第一步，先取出第一页的顶级元素
     * //第二步，把与顶级相关的相关的二级，三级分类取出来（最多支持三级）
     * //第三步，组成树型结构
     *
     * @param int $tencentId
     * @param array  $filter 过滤条件
     *
     * @return array
     */
    public function fansIndex(int $tencentId, array $filter): array;

    /**
     * agarwood.cloud.user.center.provider - 领域服务接口： 新建
     *
     * @param array $attributes
     *
     * @return CustomerGroup
     */
    public function customerCreate(array $attributes): CustomerGroup;

    /**
     * agarwood.cloud.user.center.provider - 领域服务接口： 新建
     *
     * @param array $attributes
     *
     * @return FansGroup
     */
    public function fansCreate(array $attributes): FansGroup;

    /**
     * agarwood.cloud.user.center.provider - 领域服务接口： 更新
     *
     * @param string                 $uuid 分组uuid
     * @param CustomerGroupUpdateDTO $DTO
     *
     * @return CustomerGroup|null
     */
    public function customerUpdate(string $uuid, CustomerGroupUpdateDTO $DTO): ?CustomerGroup;

    /**
     * agarwood.cloud.user.center.provider - 领域服务接口： 更新
     *
     * @param string             $uuid 分组uuid
     * @param FansGroupUpdateDTO $DTO
     *
     * @return FansGroup|null
     */
    public function fansUpdate(string $uuid, FansGroupUpdateDTO $DTO): ?FansGroup;

    /**
     * agarwood.cloud.user.center.provider - 领域服务接口： 预览
     *
     * @param int $id
     *
     * @return array
     */
    public function customerView(int $id): array;

    /**
     * agarwood.cloud.user.center.provider - 领域服务接口： 预览
     *
     * @param int $id
     *
     * @return array
     */
    public function fansView(int $id): array;

    /**
     * agarwood.cloud.user.center.provider - 领域服务接口： 删除
     *
     * @param int $id
     *
     * @return bool|null
     */
    public function customerDelete(int $id): ?bool;

    /**
     * agarwood.cloud.user.center.provider - 领域服务接口： 删除
     *
     * @param int $id
     *
     * @return bool|null
     */
    public function fansDelete(int $id): ?bool;

    /**
     * 客服的粉丝分组
     *
     * @param int   $tencentId
     * @param int   $customerId
     * @param array $filter
     *
     * @return array
     */
    public function customer(int $tencentId, int $customerId, array $filter): array;
}
