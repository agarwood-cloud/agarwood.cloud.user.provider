<?php declare(strict_types=1);
/**
 * This file is part of Agarwood Cloud.
 *
 * @link     https://www.agarwood-cloud.com
 * @document https://www.agarwood-cloud.com/docs
 * @contact  676786620@qq.com
 * @author   agarwood
 */

namespace App\OfficialAccount\Application;

use App\OfficialAccount\Interfaces\DTO\User\IndexDTO;
use App\OfficialAccount\Interfaces\DTO\User\UpdateDTO;
use App\OfficialAccount\Interfaces\DTO\User\UpdateGroupDTO;
use Swoft\Stdlib\Collection;

/**
 * @\Swoft\Bean\Annotation\Mapping\Bean()
 */
interface UserApplication
{
    /**
     * User List
     *
     * @param int|null                                          $officialAccountId
     * @param \App\OfficialAccount\Interfaces\DTO\User\IndexDTO $DTO
     *
     * @return array
     */
    public function indexProvider(?int $officialAccountId, IndexDTO $DTO): array;

    /**
     * @param string $openid
     *
     * @return array
     */
    public function viewProvider(string $openid): array;

    /**
     * @param string $openid
     *
     * @return int
     */
    public function deleteProvider(string $openid): int;

    /**
     * @param string                                             $openid
     * @param \App\OfficialAccount\Interfaces\DTO\User\UpdateDTO $DTO
     *
     * @return \Swoft\Stdlib\Collection
     */
    public function updateProvider(string $openid, UpdateDTO $DTO): Collection;
}
