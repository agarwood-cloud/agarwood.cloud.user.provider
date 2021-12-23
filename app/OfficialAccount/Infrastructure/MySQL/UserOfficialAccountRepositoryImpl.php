<?php declare(strict_types=1);
/**
 * This file is part of Agarwood Cloud.
 *
 * @link     https://www.agarwood-cloud.com
 * @document https://www.agarwood-cloud.com/docs
 * @contact  676786620@qq.com
 * @author   agarwood
 */

namespace App\OfficialAccount\Infrastructure\MySQL;

use App\OfficialAccount\Domain\Aggregate\Repository\UserInfoRepository;
use App\OfficialAccount\Domain\Aggregate\Repository\UserOfficialAccountRepository;
use App\OfficialAccount\Domain\Aggregate\Repository\UserRepository;
use App\OfficialAccount\Interfaces\DTO\User\UserCreateDTO;
use App\OfficialAccount\Interfaces\DTO\User\UserUpdateDTO;
use App\OfficialAccount\Interfaces\DTO\UserInfo\UserInfoCreateDTO;
use App\OfficialAccount\Interfaces\DTO\UserInfo\UserInfoUpdateDTO;
use Agarwood\Core\Exception\BusinessException;
use Swoft\Db\DB;
use Swoft\Stdlib\Helper\ObjectHelper;
use Throwable;

/**
 * @\Swoft\Bean\Annotation\Mapping\Bean()
 */
class UserOfficialAccountRepositoryImpl implements UserOfficialAccountRepository
{
    /**
     * @\Swoft\Bean\Annotation\Mapping\Inject()
     *
     * @var UserRepository
     */
    protected UserRepository $userDao;

    /**
     * @\Swoft\Bean\Annotation\Mapping\Inject()
     *
     * @var UserInfoRepository
     */
    protected UserInfoRepository $userInfoDao;

    /**
     * @inheritDoc
     */
    public function addUserFromCode(array $attributes): array
    {
        $attributes = (new UserCreateDTO())->setBefore($attributes);
        $attributes = (new UserInfoCreateDTO())->setBefore($attributes);

        //数据传输
        /** @var UserCreateDTO $userDTO */
        $userDTO = ObjectHelper::init(new UserCreateDTO(), $attributes);
        /** @var UserInfoCreateDTO $userInfoDTO */
        $userInfoDTO = ObjectHelper::init(new UserInfoCreateDTO(), $attributes);

        // 接待新增的值
        $userAttributes = $userDTO->toArrayNotNull([], true);

        $userInfoAttributes = $userInfoDTO->toArrayNotNull([], true);

        // 保存到数据库
        try {
            DB::beginTransaction();

            // 这里有个坑，如果是字段对应不上，或者是有一个表数据已存在，则报错
            $this->userDao->create($userAttributes);
            $this->userInfoDao->create($userInfoAttributes);
            DB::commit();
        } catch (Throwable $exception) {
            DB::rollBack();
            throw new BusinessException($exception->getMessage());
        }

        return $userAttributes;
    }

    /**
     * @inheritDoc
     */
    public function updateUserByOpenid(string $openid, array $attributes): array
    {
        //这里是已存在用户微信，更新的逻辑
        $attributes = (new UserUpdateDTO())->setBefore($attributes);

        //数据传输
        /** @var UserUpdateDTO $userDTO */
        $userDTO = ObjectHelper::init(new UserUpdateDTO(), $attributes);

        /** @var UserInfoUpdateDTO $userInfoDTO */
        $userInfoDTO = ObjectHelper::init(new UserInfoUpdateDTO(), $attributes);

        // 将要更新的数据
        $userAttributes     = $userDTO->toArrayNotNull([], true);
        $userInfoAttributes = $userInfoDTO->toArrayNotNull([], true);

        try {
            DB::beginTransaction();
            $this->userDao->update($openid, $userAttributes);
            $this->userInfoDao->update($openid, $userInfoAttributes);
            DB::commit();
        } catch (Throwable $exception) {
            DB::rollBack();
            throw new BusinessException($exception->getMessage());
        }

        return $attributes;
    }
}
