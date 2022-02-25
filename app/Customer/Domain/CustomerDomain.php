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
use MongoDB\Client;

/**
 * @\Swoft\Bean\Annotation\Mapping\Bean()
 */
interface CustomerDomain
{
    /**
     * customer list data
     *
     * @param array $filter condition
     * @param int   $platformId
     *
     * @return array
     */
    public function index(int $platformId, array $filter): array;

    /**
     *  create
     *
     * @param int   $platformId
     * @param array $attributes
     *
     * @return bool
     */
    public function create(int $platformId, array $attributes): bool;

    /**
     * update
     *
     * @param int       $id  模板uuid
     * @param UpdateDTO $DTO 更新字段
     *
     * @return array
     */
    public function update(int $id, UpdateDTO $DTO): array;

    /**
     * view
     *
     * @param int $id
     *
     * @return array
     */
    public function view(int $id): array;

    /**
     * delete
     *
     * @param string $ids
     *
     * @return int
     */
    public function delete(string $ids): int;

    /**
     * scan QR code
     *
     * @param int $platformId
     * @param int $customerId
     *
     * @return array
     */
    public function scanSubscribe(int $platformId, int $customerId): array;

    /**
     * @param int             $id
     * @param ChangeStatusDTO $DTO
     *
     * @return array
     */
    public function changeStatus(int $id, ChangeStatusDTO $DTO): array;

    /**
     * @param int    $platformId
     * @param string $ids
     *
     * @return array
     */
    public function obtainOffline(int $platformId, string $ids): array;

    /**
     *  chat list data
     *
     * @param int     $customerId
     * @param Client  $client
     * @param ChatDTO $DTO
     *
     * @return array
     */
    public function chat(int $customerId, Client $client, ChatDTO $DTO): array;

    /**
     * chat record data
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
     * @param int $platformId
     *
     * @return array
     */
    public function obtainFansOffline(int $platformId): array;

    /**
     * @param int $platformId
     * @param int $id
     *
     * @return bool
     */
    public function obtainStatus(int $platformId, int $id): bool;
}
