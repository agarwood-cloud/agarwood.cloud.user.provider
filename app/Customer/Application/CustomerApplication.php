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
use App\Customer\Interfaces\DTO\Customer\CreateDTO;
use App\Customer\Interfaces\DTO\Customer\IndexDTO;
use App\Customer\Interfaces\DTO\Customer\UpdateDTO;
use Swoft\Stdlib\Collection;

/**
 * @\Swoft\Bean\Annotation\Mapping\Bean()
 */
interface CustomerApplication
{
    /**
     * Customer Service List Data
     *
     * @param int                                            $platformId
     * @param \App\Customer\Interfaces\DTO\Customer\IndexDTO $DTO
     *
     * @return array
     */
    public function indexProvider(int $platformId, IndexDTO $DTO): array;

    /**
     * Create Customer Service Account
     *
     * @param int                                             $platformId
     * @param \App\Customer\Interfaces\DTO\Customer\CreateDTO $DTO
     *
     * @return \Swoft\Stdlib\Collection
     */
    public function createProvider(int $platformId, CreateDTO $DTO): Collection;

    /**
     * Delete Customer Service Account
     *
     * @param string $ids
     *
     * @return int
     */
    public function deleteProvider(string $ids): int;

    /**
     * Update Customer Service Account
     *
     * @param int                                             $id
     * @param \App\Customer\Interfaces\DTO\Customer\UpdateDTO $DTO
     *
     * @return \Swoft\Stdlib\Collection
     */
    public function updateProvider(int $id, UpdateDTO $DTO): Collection;

    /**
     * View Customer Service Account Info
     *
     * @param int $id
     *
     * @return array
     */
    public function viewProvider(int $id): array;

    /**
     *  Generate QR code
     *
     * @param int $platformId
     * @param int $customerId
     *
     * @return array
     */
    public function scanSubscribeProvider(int $platformId, int $customerId): array;

    /**
     * Change Status
     *
     * @param int             $id
     * @param ChangeStatusDTO $DTO
     *
     * @return Collection
     */
    public function changeStatusProvider(int $id, ChangeStatusDTO $DTO): Collection;

    /**
     * Clear queue
     *
     * @param int    $platformId
     * @param string $ids
     *
     * @return array
     */
    public function obtainOfflineProvider(int $platformId, string $ids): array;

    /**
     * Chat Record List
     *
     * @param int     $platformId
     * @param int     $customerId
     * @param ChatDTO $DTO
     *
     * @return array
     */
    public function chatProvider(int $platformId, int $customerId, ChatDTO $DTO): array;

    /**
     * Chat Record
     *
     * @param int           $customerId
     * @param ChatRecordDTO $DTO
     *
     * @return array
     */
    public function chatRecordProvider(int $customerId, ChatRecordDTO $DTO): array;

    /**
     * All Customer Service Quit Queue
     *
     * @param int $platformId
     *
     * @return array
     */
    public function obtainFansOfflineProvider(int $platformId): array;

    /**
     * Customer Service Status
     *
     * @param int $platformId
     * @param int $id
     *
     * @return array
     */
    public function obtainStatusProvider(int $platformId, int $id): array;
}
