<?php declare(strict_types=1);
/**
 * This file is part of Agarwood Cloud.
 *
 * @link     https://www.agarwood-cloud.com
 * @document https://www.agarwood-cloud.com/docs
 * @contact  676786620@qq.com
 * @author   agarwood
 */

namespace App\OfficialAccount\Application\Bo\CustomerToDo;

use Carbon\Carbon;
use Agarwood\Core\Constant\StringConstant;

/**
 * @\Swoft\Bean\Annotation\Mapping\Bean()
 */
class TimelineBo
{
    /**
     * 格式化数组
     *
     * @param array $user
     * @param array $orders
     * @param array $events
     *
     * @return array
     */
    public function map(array $user, array $orders, array $events): array
    {
        $result = [];

        // 关注时间
        $result[] = [
            'timeline'  => $user['subscribe_at'],
            'timestamp' => Carbon::parse($user['subscribe_at'])->timestamp,
            'event'     => '粉丝[ ' . $user['nickname'] . ' ]' . ' 关注公众账号！'
        ];

        // 取消关注
        if ($user['unsubscribed_at'] !== StringConstant::DATE_TIME_DEFAULT) {
            $result[] = [
                'timeline'  => $user['unsubscribed_at'],
                'timestamp' => Carbon::parse($user['unsubscribed_at'])->timestamp,
                'event'     => '粉丝[ ' . $user['nickname'] . ' ]' . ' 取消关注！'
            ];
        }

        // 我的待办
        foreach ($events as $value) {
            $result[] = [
                'timeline'  => $value['created_at'],
                'timestamp' => Carbon::parse($value['created_at'])->timestamp,
                'event'     => "【跟进事项】
                                标题：{$value['content']}
                                备注：{$value['remark']}
                                最后更新时间：{$value['updated_at']}"
            ];
        }

        // 订单事件
        foreach ($orders as $order) {
            $result[] = [
                'timeline'  => $order['created_at'],
                'timestamp' => Carbon::parse($order['created_at'])->timestamp,
                'event'     => "【订单】
                                收件人：{$order['receiver_name']}
                                订单号：{$order['order_no']}
                                创建时间：{$order['created_at']}
                                订单状态：{$this->orderStatusMap($order['order_status'])}
                                订单商品：{$order['product_sn']} * {$order['num']}"
            ];
        }

        // 排序
        $tempSort = array_column($result, 'timestamp');
        sort($tempSort);
        array_multisort($tempSort, SORT_ASC, $result);

        return $result;
    }

    /**
     * @param string $status
     *
     * @return string
     */
    protected function orderStatusMap(string $status): string
    {
        // 订单状态
        //  [no_payment:未付款,paid:已付款,to_pay:到付,invalid:无效,pay_confirmation:到付确认,
        //  returned:已退回,retransmitted:已重发,return_in:退回中,
        //  shipped:已发货,received:已签收,lost:已丢失,refund:已退款,
        //  to_be_delivered: 待发货]

        $orderStatus = [
            'no_payment'       => '未付款',
            'paid'             => '已付款',
            'to_pay'           => '到付',
            'invalid'          => '无效',
            'pay_confirmation' => '到付确认',
            'returned'         => '已退回',
            'retransmitted'    => '已重发',
            'return_in'        => '退回中',
            'shipped'          => '已发货',
            'received'         => '已签收',
            'lost'             => '已丢失',
            'refund'           => '已退款',
            'to_be_delivered'  => '待发货'
        ];

        return $orderStatus[$status] ?? $status;
    }
}
