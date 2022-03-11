<?php declare(strict_types=1);
/**
 * This file is part of Agarwood Cloud.
 *
 * @link     https://www.agarwood-cloud.com
 * @document https://www.agarwood-cloud.com/docs
 * @contact  676786620@qq.com
 * @author   agarwood
 */

namespace App\OfficialAccount\Interfaces\Rpc\Service;

use Agarwood\Rpc\UserCenter\UserCenterOrderEventRpcInterface;
use App\Customer\Domain\Aggregate\Repository\CustomerToDoRepository;
// use App\OfficialAccount\Infrastructure\NoSQL\MongoDB;
use Carbon\Carbon;
use JsonException;

/**
 * @\Swoft\Rpc\Server\Annotation\Mapping\Service()
 * @deprecated 暂时不用
 */
class UserCenterOrderEventRpc implements UserCenterOrderEventRpcInterface
{
//    /**
//     * @\Swoft\Bean\Annotation\Mapping\Inject()
//     *
//     * @var MongoDB
//     */
//    protected MongoDB $mongoDB;

    /**
     * @\Swoft\Bean\Annotation\Mapping\Inject()
     *
     * @var CustomerToDoRepository
     */
    protected CustomerToDoRepository $customerToDoDao;

    /**
     * 粉丝创建订单
     *
     * @inheritDoc
     * @throws JsonException
     */
    public function orderCreateByUser(string $openid, string $orderNo, array $order): void
    {
        $content = '【系统消息】粉丝创建订单（ ' . $orderNo . ' ）成功！';

        $this->sendToCustomerService->textMessage(
            $order['customerUuid'],
            $openid,
            $order['nickname'] ?? $openid,
            $content,
            Uuid::uuid4()->toString()
        );

        $this->saveToMongoDB($order['openid'], $order['customerUuid'], $content);
    }

    /**
     * 客服创建订单
     *
     * @inheritDoc
     * @throws JsonException
     */
    public function orderCreateByCustomer(int $customerId, string $orderNo, array $order): void
    {
        // 通知客服已成功创建订单.

        $content = '【系统消息】你手动为粉丝创建订单（ ' . $orderNo . ' ）成功！';

        $this->sendToCustomerService->textMessage(
            $customerUuid,
            $order['openid'],
            $order['nickname'] ?? $order['openid'],
            $content,
            Uuid::uuid4()->toString()
        );

        $this->saveToMongoDB($order['openid'], $order['customerUuid'], $content);
    }

    /**
     * 订单支付成功
     *
     * @inheritDoc
     * @throws JsonException
     */
    public function orderPaymentSuccess(string $outTradeNo, string $transactionId, array $order): void
    {
        // 提示客服订单已支付成功，做好要进物流

        $content = '【系统消息】微信单号（ ' . $outTradeNo . ' ）支付成功！，支付流水号为（' . $transactionId . '）';

        $this->sendToCustomerService->textMessage(
            $order['customerUuid'],
            $order['openid'],
            $order['nickname'] ?? $order['openid'],
            $content,
            Uuid::uuid4()->toString()
        );

        $this->saveToMongoDB($order['openid'], $order['customerUuid'], $content);
    }

    /**
     * 订单发货
     *
     * @inheritDoc
     * @throws JsonException
     */
    public function orderExpress(string $orderNo, array $order): void
    {
        // 提示订单已发货
        $content = '【系统消息】订单（ ' . $orderNo . ' ）已发货！';

        $this->sendToCustomerService->textMessage(
            $order['customerUuid'],
            $order['openid'],
            $order['nickname'] ?? $order['openid'],
            $content,
            Uuid::uuid4()->toString()
        );

        // 保存到mongodb
        $this->saveToMongoDB($order['openid'], $order['customerUuid'], $content);

        // 我的待办
        $todo = '用户[' . $order['receiverName'] . ']的订单[' . $orderNo . ']已发货，待跟进物流并指导产品的使用';

        $attributes = [
            'platform_id'   => $order['serviceUuid'],
            'customer_uuid' => $order['customerUuid'],
            'openid'        => $order['openid'],
            'nickname'      => $order['nickname'] ?? '',
            'content'       => $todo,
            'status'        => CustomerToDoStatusEnum::STATUS_TODO
        ];

        $this->customerToDoDao->create($attributes);
    }

    /**
     * 订单签收
     *
     * @inheritDoc
     * @throws JsonException
     */
    public function orderSignForExpress(string $orderNo, array $order): void
    {
        // 提示客服，客户已签收订单，做好后续的使用指导

        $content = '【系统消息】客户已签收订单（ ' . $orderNo . ' ）！';

        $this->sendToCustomerService->textMessage(
            $order['customerUuid'],
            $order['openid'],
            $order['nickname'] ?? $order['openid'],
            $content,
            Uuid::uuid4()->toString()
        );

        // 保存到mongodb
        $this->saveToMongoDB($order['openid'], $order['customerUuid'], $content);

        // 我的待办
        $todo = '用户[' . $order['receiverName'] . ']已签收，待回访客户并指导产品的使用';

        $attributes = [
            'platform_id'   => $order['serviceUuid'],
            'customer_uuid' => $order['customerUuid'],
            'openid'        => $order['openid'],
            'nickname'      => $order['nickname'] ?? '',
            'content'       => $todo,
            'status'        => 'todo'
        ];
        $this->customerToDoDao->create($attributes);
    }

    /**
     * 保存信息到mongoDB
     *
     * @param string $openid
     * @param int    $customerId
     * @param string $content
     *
     * @return void
     * @throws JsonException
     */
    private function saveToMongoDB(string $openid, int $customerId, string $content): void
    {
        $data = [
            'openid'        => $openid,
            'custom_uuid'   => $customerId,
            'send'          => 'user',
            'data'          => json_encode([
                'msg_source' => $openid,
                'msg_type'   => 'text',
                'content'    => $content
            ], JSON_THROW_ON_ERROR),
            'is_read'       => 0,
            'created_time'  => Carbon::now()->toDateTimeString(),
            'response_time' => 0,
        ];
        $this->mongoDB->save($data);
    }

    /**
     * 消息通知
     *
     * @param string $orderNo
     * @param int    $customerId
     * @param string $customer
     * @param string $openid
     * @param string $message
     */
    public function orderNotification(string $orderNo, int $customerId, string $customer, string $openid, string $message): void
    {
        // TODO: Implement orderNotification() method.
    }
}
