<?php declare(strict_types=1);
/**
 * This file is part of Agarwood Cloud.
 *
 * @link     https://www.agarwood-cloud.com
 * @document https://www.agarwood-cloud.com/docs
 * @contact  676786620@qq.com
 * @author   agarwood
 */

namespace App\OfficialAccount\Domain\Impl;

use App\OfficialAccount\Domain\Aggregate\Repository\UserCommandRepository;
use App\OfficialAccount\Domain\Aggregate\Repository\UserQueryRepository;
use App\OfficialAccount\Domain\UserDomain;
use App\OfficialAccount\Interfaces\DTO\User\IndexDTO;
use Swoft\Db\Exception\DbException;

/**
 * @\Swoft\Bean\Annotation\Mapping\Bean()
 */
class UserDomainImpl implements UserDomain
{
    /**
     * @\Swoft\Bean\Annotation\Mapping\Inject()
     *
     * @var UserQueryRepository $userQueryRepository
     */
    public UserQueryRepository $userQueryRepository;

    /**
     * @\Swoft\Bean\Annotation\Mapping\Inject()
     *
     * @var \App\OfficialAccount\Domain\Aggregate\Repository\UserCommandRepository
     */
    public UserCommandRepository $userCommandRepository;

    /**
     * @param int   $officialAccountId
     * @param array $filter
     *
     * @return array
     */
    public function index(int $officialAccountId, array $filter): array
    {
        return $this->userQueryRepository->index($officialAccountId, $filter);
    }

    /**
     * @param string $openid
     *
     * @return array
     * @throws DbException
     */
    public function view(string $openid): array
    {
        return $this->userQueryRepository->findByOpenid($openid);
    }

    /**
     * @param string $openid
     * @param array  $attributes
     *
     * @return int
     */
    public function update(string $openid, array $attributes): int
    {
        return $this->userCommandRepository->updateByOpenid($openid, $attributes);
    }

    /**
     * @param string $openid
     *
     * @return int
     */
    public function delete(string $openid): int
    {
        return $this->userCommandRepository->delete($openid);
    }

    /**
     * 粉丝列表数据
     *
     * @param IndexDTO $DTO
     * @param bool     $isPagination
     *
     * @return array
     */
    public function indexV3(IndexDTO $DTO, bool $isPagination): array
    {
        return $this->userQueryRepository->indexV3($DTO->toArrayLine(), $isPagination);
    }
}
