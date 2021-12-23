<?php declare(strict_types=1);
/**
 * This file is part of Agarwood Cloud.
 *
 * @link     https://www.agarwood-cloud.com
 * @document https://www.agarwood-cloud.com/docs
 * @contact  676786620@qq.com
 * @author   agarwood
 */

namespace App\Customer\Application;

use App\Customer\Interfaces\DTO\Customer\ChangeStatusDTO;
use App\Customer\Interfaces\DTO\Customer\ChatDTO;
use App\Customer\Interfaces\DTO\Customer\ChatRecordDTO;
use App\Customer\Interfaces\DTO\Customer\CustomerServiceCreateDTO;
use App\Customer\Interfaces\DTO\Customer\CustomerServiceIndexDTO;
use App\Customer\Interfaces\DTO\Customer\CustomerServiceUpdateDTO;
use App\Customer\Interfaces\DTO\Customer\LoginDTO;
use Swoft\Stdlib\Collection;

/**
 * @\Swoft\Bean\Annotation\Mapping\Bean()
 */
interface CustomerApplication
{
    /**
     * 应用层
     *      客服列表服务接口
     *
     *
     * @param int                     $officialAccountId
     * @param CustomerServiceIndexDTO $DTO
     *
     * @return array
     */
    public function indexProvider(int $officialAccountId, CustomerServiceIndexDTO $DTO): array;

    /**
     * 应用层
     *      新建客服服务接口
     *
     * @param int                      $officialAccountId
     * @param CustomerServiceCreateDTO $DTO
     *
     * @return Collection
     */
    public function createProvider(int $officialAccountId, CustomerServiceCreateDTO $DTO): Collection;

    /**
     *  应用层
     *      删除客服服务接口
     *
     * @param string $ids
     *
     * @return int
     */
    public function deleteProvider(string $ids): int;

    /**
     *  应用层
     *      更新客服服务接口
     *
     * @param int                      $id
     * @param CustomerServiceUpdateDTO $DTO
     *
     * @return Collection
     */
    public function updateProvider(int $id, CustomerServiceUpdateDTO $DTO): Collection;

    /**
     * 应用层
     *      查看列表服务接口
     *
     * @param int $id
     *
     * @return array
     */
    public function viewProvider(int $id): array;

    /**
     * 应用层
     *      生成专属二维码接口
     *
     * @param int $token
     * @param int $customerId
     *
     * @return array
     */
    public function scanSubscribeProvider(int $token, int $customerId): array;

    /**
     *  应用层
     *      更新客服服务接口
     *
     * @param int             $id
     * @param ChangeStatusDTO $DTO
     *
     * @return Collection
     */
    public function changeStatusProvider(int $id, ChangeStatusDTO $DTO): Collection;

    /**
     *  应用层
     *      删除客服抢粉的接口
     *
     * @param int    $officialAccountId
     * @param string $ids
     *
     * @return array
     */
    public function obtainOfflineProvider(int $officialAccountId, string $ids): array;

    /**
     * 应用层
     *      客服列表服务接口
     *
     *
     * @param LoginDTO $DTO
     *
     * @return array
     */
    public function loginProvider(LoginDTO $DTO): array;

    /**
     * 获取最近的聊天列表
     *
     * @param int     $officialAccountId
     * @param int     $customerId
     * @param ChatDTO $DTO
     *
     * @return array
     */
    public function chatProvider(int $officialAccountId, int $customerId, ChatDTO $DTO): array;

    /**
     * 查找粉丝的聊天记录
     *
     * @param int           $customerId
     * @param ChatRecordDTO $DTO
     *
     * @return array
     */
    public function chatRecordProvider(int $customerId, ChatRecordDTO $DTO): array;

    /**
     * 一键下线功能
     *
     * @param int $officialAccountId
     *
     * @return array
     */
    public function obtainFansOfflineProvider(int $officialAccountId): array;

    /**
     * 查看抢粉状态
     *
     * @param int $officialAccountId
     * @param int $id
     *
     * @return array
     */
    public function obtainStatusProvider(int $officialAccountId, int $id): array;
}
