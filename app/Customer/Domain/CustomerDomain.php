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

use App\Customer\Interfaces\DTO\Customer\ChangeStatusDTO;
use App\Customer\Interfaces\DTO\Customer\ChatDTO;
use App\Customer\Interfaces\DTO\Customer\ChatRecordDTO;
use App\Customer\Interfaces\DTO\Customer\UpdateDTO;
use App\Customer\Interfaces\DTO\Customer\LoginDTO;
use MongoDB\Client;

/**
 * @\Swoft\Bean\Annotation\Mapping\Bean()
 */
interface CustomerDomain
{
    /**
     *  获取列表
     *
     * @param array $filter 过滤条件
     * @param int   $officialAccountId
     *
     * @return array
     */
    public function index(int $officialAccountId, array $filter): array;

    /**
     *  新建
     *
     * @param int   $officialAccountId
     * @param array $attributes
     *
     * @return bool
     */
    public function create(int $officialAccountId, array $attributes): bool;

    /**
     * 更新
     *
     * @param int       $id  模板uuid
     * @param UpdateDTO $DTO 更新字段
     *
     * @return array
     */
    public function update(int $id, UpdateDTO $DTO): array;

    /**
     * 预览
     *
     * @param int $id
     *
     * @return array
     */
    public function view(int $id): array;

    /**
     * 删除
     *
     * @param string $ids
     *
     * @return int
     */
    public function delete(string $ids): int;

    /**
     * user.center 领域服务的接口： 生成客服专属的二维码
     *
     * @param int $token
     * @param int $customerId
     *
     * @return array
     */
    public function scanSubscribe(int $token, int $customerId): array;

    /**
     * @param int             $id
     * @param ChangeStatusDTO $DTO
     *
     * @return array
     */
    public function changeStatus(int $id, ChangeStatusDTO $DTO): array;

    /**
     * @param int    $officialAccountId
     * @param string $ids
     *
     * @return array
     */
    public function obtainOffline(int $officialAccountId, string $ids): array;

    /**
     * 领域服务接口： 登陆
     *
     * @param LoginDTO $DTO
     *
     * @return array
     */
    public function login(LoginDTO $DTO): array;

    /**
     *  获取列表
     *
     * @param int     $customerId
     * @param Client  $client
     * @param ChatDTO $DTO
     *
     * @return array
     */
    public function chat(int $customerId, Client $client, ChatDTO $DTO): array;

    /**
     * 获取聊天记录
     *
     * @param int           $customerId
     * @param Client        $client
     * @param ChatRecordDTO $DTO
     * @param array         $month
     *
     * @return array
     */
    public function chatRecord(int $customerId, Client $client, ChatRecordDTO $DTO, array $month): array;

    /**
     * 清除redis的抢粉信息
     *
     * @param int $officialAccountId
     *
     * @return array
     */
    public function obtainFansOffline(int $officialAccountId): array;

    /**
     * 抢粉状态
     *
     * @param int $officialAccountId
     * @param int $id
     *
     * @return bool
     */
    public function obtainStatus(int $officialAccountId, int $id): bool;
}
