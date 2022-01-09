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
use App\Customer\Interfaces\DTO\Customer\LoginDTO;
use Swoft\Stdlib\Collection;

/**
 * @\Swoft\Bean\Annotation\Mapping\Bean()
 */
interface CustomerApplication
{
    /**
     * Customer Service List Data
     *
     * @param int                                            $officialAccountId
     * @param \App\Customer\Interfaces\DTO\Customer\IndexDTO $DTO
     *
     * @return array
     */
    public function indexProvider(int $officialAccountId, IndexDTO $DTO): array;

    /**
     * Create Customer Service Account
     *
     * @param int                                             $officialAccountId
     * @param \App\Customer\Interfaces\DTO\Customer\CreateDTO $DTO
     *
     * @return \Swoft\Stdlib\Collection
     */
    public function createProvider(int $officialAccountId, CreateDTO $DTO): Collection;

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
     * @param int $officialAccountId
     * @param int $customerId
     *
     * @return array
     */
    public function scanSubscribeProvider(int $officialAccountId, int $customerId): array;

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
     * @param int    $officialAccountId
     * @param string $ids
     *
     * @return array
     */
    public function obtainOfflineProvider(int $officialAccountId, string $ids): array;

    /**
     * Customer Service Login
     *
     * @param LoginDTO $DTO
     *
     * @return array
     */
    public function loginProvider(LoginDTO $DTO): array;

    /**
     * Chat Record List
     *
     * @param int     $officialAccountId
     * @param int     $customerId
     * @param ChatDTO $DTO
     *
     * @return array
     */
    public function chatProvider(int $officialAccountId, int $customerId, ChatDTO $DTO): array;

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
     * @param int $officialAccountId
     *
     * @return array
     */
    public function obtainFansOfflineProvider(int $officialAccountId): array;

    /**
     * Customer Service Status
     *
     * @param int $officialAccountId
     * @param int $id
     *
     * @return array
     */
    public function obtainStatusProvider(int $officialAccountId, int $id): array;
}
