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

use App\OfficialAccount\Domain\Aggregate\Repository\BroadcastingRepository;
use App\OfficialAccount\Domain\BroadcastingDomainService;
use App\OfficialAccount\Interfaces\DTO\Broadcasting\FansGroupDTO;
use App\OfficialAccount\Interfaces\DTO\Broadcasting\SendTextDTO;
use EasyWeChat\OfficialAccount\Application;
use Swoole\Timer;

/**
 * @\Swoft\Bean\Annotation\Mapping\Bean()
 */
class BroadcastingDomainServiceImpl implements BroadcastingDomainService
{
    /**
     * @\Swoft\Bean\Annotation\Mapping\Inject()
     *
     * @var BroadcastingRepository
     */
    protected BroadcastingRepository $broadcastingRepository;

    /**
     * 已发送的列表
     *
     * @param int $tencentId
     * @param array  $toArrayLine
     * @param bool   $isPagination
     *
     * @return array
     */
    public function index(int $tencentId, array $toArrayLine, bool $isPagination): array
    {
        return $this->broadcastingRepository->index($tencentId, $toArrayLine, $isPagination);
    }

    /**
     * 群发文本消息
     *
     * @param string                                  $tencentId
     * @param \EasyWeChat\OfficialAccount\Application $application
     * @param SendTextDTO                             $textDTO
     *
     * @return array
     */
    public function sendText(int $tencentId, Application $application, SendTextDTO $textDTO): array
    {
        Timer::after(5, function () use ($tencentId, $application, $textDTO) {
            // 查找需要发送的组别
            foreach ($textDTO->getSendTo() as $item) {
                $openid = $this->broadcastingRepository->findGroupByUuid($item['groupUuid']);
                // 每个分组必须大于两人， todo 这里也可以修改为多组同时发送
                if (count($openid) >= 2) {
                    $result = $application->broadcasting->sendText($textDTO->getContent(), $openid);
                }

                // 计算发送成功的数量
                if (isset($result['errcode']) && ($result['errcode'] === 0)) {
                    $status = 'success';
                    $msgId  = $result['msg_id'];
                } else {
                    $status = 'fail';
                }

                // 记录到数据库
                $attributes = [
                    'message_type' => 'text',
                    'content'      => $textDTO->getContent(),
                    'group_uuid'   => $item['groupUuid'],
                    'group_name'   => $item['groupName'],
                    'number'       => count($openid),
                    'status'       => $status,
                    'service_uuid' => $tencentId,
                    'msg_id'       => $msgId ?? 0
                ];

                $this->broadcastingRepository->create($attributes);
            }
        });

        return [
            'msg' => '推文消息正在后台发送！！！',
        ];
    }

    /**
     * 分组列表
     *
     * @param string       $tencentId
     * @param FansGroupDTO $dto
     * @param bool         $isPagination
     *
     * @return array
     */
    public function fansGroup(int $tencentId, FansGroupDTO $dto, bool $isPagination): array
    {
        return $this->broadcastingRepository->fansGroup($tencentId, $dto->toArrayLine(), $isPagination);
    }
}
