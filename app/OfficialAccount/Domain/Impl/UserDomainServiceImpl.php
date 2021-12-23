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

use App\OfficialAccount\Domain\Aggregate\Entity\User;
use App\OfficialAccount\Domain\Aggregate\Repository\UserRepository;
use App\OfficialAccount\Domain\UserDomainService;
use App\OfficialAccount\Interfaces\DTO\User\IndexDTO;
use Agarwood\Core\Exception\InvalidParameterException;
use Swoft\Db\Exception\DbException;

/**
 * @\Swoft\Bean\Annotation\Mapping\Bean()
 */
class UserDomainServiceImpl implements UserDomainService
{
    /**
     * @\Swoft\Bean\Annotation\Mapping\Inject()
     *
     * @var UserRepository $userRepository
     */
    protected UserRepository $userRepository;

    /**
     * @param int   $officialAccountId
     * @param array $filter
     *
     * @return array
     */
    public function index(int $officialAccountId, array $filter): array
    {
        return $this->userRepository->index($officialAccountId, $filter);
    }

    /**
     * @param array $attributes
     *
     * @return User
     * @throws DbException
     */
    public function create(array $attributes): User
    {
        return $this->userRepository->create($attributes);
    }

    /**
     * @param string $openid
     * @param array  $attributes
     *
     * @return int|null
     */
    public function update(string $openid, array $attributes): ?int
    {
        return $this->userRepository->update($openid, $attributes);
    }

    /**
     * @param string $openid
     *
     * @return array
     * @throws DbException
     */
    public function view(string $openid): array
    {
        if (!$view = $this->userRepository->view($openid)) {
            throw new InvalidParameterException('查无此open对应的粉丝信息');
        }
        return $view->toArray();
    }

    /**
     * @param string $openid
     *
     * @return bool|null
     */
    public function delete(string $openid): ?bool
    {
        return $this->userRepository->delete($openid);
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
        return $this->userRepository->indexV3($DTO->toArrayLine(), $isPagination);
    }
}
