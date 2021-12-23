<?php declare(strict_types=1);
/**
 * This file is part of Agarwood Cloud.
 *
 * @link     https://www.agarwood-cloud.com
 * @document https://www.agarwood-cloud.com/docs
 * @contact  676786620@qq.com
 * @author   agarwood
 */

namespace App\Customer\Application\Impl;

use App\Customer\Application\CustomerApplication;
use App\Customer\Domain\CustomerDomainService;
use App\Customer\Infrastructure\Cache\RedisUser;
use App\Customer\Interfaces\Bo\Customer\ChatRecordBo;
use App\Customer\Interfaces\DTO\Customer\ChangeStatusDTO;
use App\Customer\Interfaces\DTO\Customer\ChatDTO;
use App\Customer\Interfaces\DTO\Customer\ChatRecordDTO;
use App\Customer\Interfaces\DTO\Customer\CustomerServiceCreateDTO;
use App\Customer\Interfaces\DTO\Customer\CustomerServiceIndexDTO;
use App\Customer\Interfaces\DTO\Customer\CustomerServiceUpdateDTO;
use App\Customer\Interfaces\DTO\Customer\LoginDTO;
use App\Customer\Interfaces\Rpc\Client\MallCenter\ServiceRpc;
use Carbon\Carbon;
use Swoft\Stdlib\Collection;
use JsonException;

/**
 * @\Swoft\Bean\Annotation\Mapping\Bean()
 */
class CustomerApplicationImpl implements CustomerApplication
{
    /**
     * 分组领域服务
     *
     * @\Swoft\Bean\Annotation\Mapping\Inject()
     *
     * @var CustomerDomainService
     */
    protected CustomerDomainService $domain;

    /**
     * @\Swoft\Bean\Annotation\Mapping\Inject()
     *
     * @var ChatRecordBo
     */
    protected ChatRecordBo $bo;

    /**
     * @\Swoft\Bean\Annotation\Mapping\Inject()
     *
     * @var RedisUser
     */
    protected RedisUser $user;

    /**
     * @\Swoft\Bean\Annotation\Mapping\Inject()
     *
     * @var ServiceRpc
     */
    protected ServiceRpc $mallCenterServiceRpcClient;

    /**
     * @inheritDoc
     */
    public function indexProvider(int $officialAccountId, CustomerServiceIndexDTO $DTO): array
    {
        return $this->domain->index($officialAccountId, $DTO->toArrayNotEmpty([], true));
    }

    /**
     * @inheritDoc
     */
    public function createProvider(int $officialAccountId, CustomerServiceCreateDTO $DTO): Collection
    {
        //增加部分系统自己添加的参数 i.e: uuid
        $attributes               = $DTO->toArrayLine();
        $attributes['service_id'] = $officialAccountId;
        // 密码加密
        $attributes['password'] = password_hash($DTO->getPassword(), PASSWORD_DEFAULT);

        $this->domain->create($attributes);
        //这里可以设置更多的返回值
        return Collection::make($DTO);
    }

    /**
     * @inheritDoc
     */
    public function deleteProvider(string $ids): int
    {
        return $this->domain->delete($ids);
    }

    /**
     * @inheritDoc
     */
    public function updateProvider(int $id, CustomerServiceUpdateDTO $DTO): Collection
    {
        $update = $this->domain->update($id, $DTO);
        return Collection::make($update);
    }

    /**
     * @inheritDoc
     */
    public function viewProvider(int $id): array
    {
        return $this->domain->view($id);
    }

    /**
     * @inheritDoc
     */
    public function scanSubscribeProvider(int $token, int $customerId): array
    {
        return $this->domain->scanSubscribe($token, $customerId);
    }

    /**
     * @inheritDoc
     */
    public function changeStatusProvider(int $id, ChangeStatusDTO $DTO): Collection
    {
        $update = $this->domain->changeStatus($id, $DTO);
        return Collection::make($update);
    }

    /**
     * @param int    $officialAccountId
     * @param string $ids
     *
     * @return array
     */
    public function obtainOfflineProvider(int $officialAccountId, string $ids): array
    {
        return $this->domain->obtainOffline($officialAccountId, $ids);
    }

    /**
     * 登陆
     *
     * @param LoginDTO $DTO
     *
     * @return array
     */
    public function loginProvider(LoginDTO $DTO): array
    {
        return $this->domain->login($DTO);
    }

    /**
     * 获取聊天记录的列表
     *
     * @param int     $officialAccountId
     * @param int     $customerId
     * @param ChatDTO $DTO
     *
     * @return array
     * @throws \EasyWeChat\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function chatProvider(int $officialAccountId, int $customerId, ChatDTO $DTO): array
    {
        $client = MongoClient::getInstance();

        $chat = $this->domain->chat($customerId, $client, $DTO);

        $openid = array_unique(array_column($chat, 'openid'));

        $userInfo = $this->user->getUsersCacheFromRedis($openid);

        // 获取腾讯接口的openid信息
        if (count($userInfo) !== count($openid)) {
            $app   = $this->mallCenterServiceRpcClient->officialAccountApplication($officialAccountId);
            $users = $app->user->select($openid);

            if (is_array($users) && isset($users['user_info_list'])) {
                foreach ($users['user_info_list'] as $user) {
                    $userInfo[$user['openid']]['openid']     = $user['openid'];
                    $userInfo[$user['openid']]['nickname']   = $user['nickname']   ?? '取关用户';
                    $userInfo[$user['openid']]['headImgUrl'] = $user['headimgurl'] ?? '';
                }
            }
        }

        // 加入粉丝的头像
        return $this->bo->userInfo($chat, $userInfo);
    }

    /**
     * 查找聊天记录
     *
     * @param int           $customerId
     * @param ChatRecordDTO $DTO
     *
     * @return array
     * @throws JsonException
     */
    public function chatRecordProvider(int $customerId, ChatRecordDTO $DTO): array
    {
        // mongo
        $client = MongoClient::getInstance();

        // 月份列表，查询时间相隔xx个月
        $difMonth = (new Carbon($DTO->getEndAt()))->month - (new Carbon($DTO->getStartAt()))->month;

        $month[0]['year']  = (new Carbon($DTO->getStartAt()))->year;
        $month[0]['month'] = (new Carbon($DTO->getStartAt()))->month;

        for ($i = 1; $i <= $difMonth; $i++) {
            $month[$i]['year']  = (new Carbon($DTO->getStartAt()))->addMonths($i)->year;
            $month[$i]['month'] = (new Carbon($DTO->getStartAt()))->addMonths($i)->month;
        }
        // $month 的格式 [ [year => 2021, month => 1], [year => 2021, month => 3] ]

        $data = $this->domain->chatRecord($customerId, $client, $DTO, $month);

        return $this->bo->map($data);
    }

    /**
     * 一键下线功能
     *
     * @param int $officialAccountId
     *
     * @return array
     */
    public function obtainFansOfflineProvider(int $officialAccountId): array
    {
        return $this->domain->obtainFansOffline($officialAccountId);
    }

    /**
     * 查看抢粉状态
     *
     * @param int $officialAccountId
     * @param int $id
     *
     * @return array
     */
    public function obtainStatusProvider(int $officialAccountId, int $id): array
    {
        return ['status' => $this->domain->obtainStatus($officialAccountId, $id)];
    }
}
