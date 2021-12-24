<?php declare(strict_types=1);
/**
 * This file is part of Agarwood Cloud.
 *
 * @link     https://www.agarwood-cloud.com
 * @document https://www.agarwood-cloud.com/docs
 * @contact  676786620@qq.com
 * @author   agarwood
 */

namespace App\Customer\Domain\Aggregate\Repository;

use App\Customer\Interfaces\DTO\Customer\LoginDTO;

/**
 * @\Swoft\Bean\Annotation\Mapping\Bean()
 */
interface CustomerQueryRepository
{
    /**
     * 服务号管理列表数据
     *
     * @param array $filter
     * @param int   $officialAccountId
     *
     * @return array
     */
    public function index(int $officialAccountId, array $filter): array;

    /**
     * @param int $id
     *
     * @return array
     */
    public function view(int $id): array;

    /**
     * @param LoginDTO $DTO
     *
     * @return array|null
     */
    public function login(LoginDTO $DTO): ?array;
}
