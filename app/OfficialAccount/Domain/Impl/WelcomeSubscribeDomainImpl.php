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

use App\OfficialAccount\Domain\WelcomeSubscribeDomain;
use EasyWeChat\Kernel\Messages\Message;
use EasyWeChat\OfficialAccount\Application;
use ReflectionException;

/**
 * @\Swoft\Bean\Annotation\Mapping\Bean()
 */
class WelcomeSubscribeDomainImpl implements WelcomeSubscribeDomain
{
    /**
     * 自动回复
     *
     * @param int                                     $platformId
     * @param \EasyWeChat\OfficialAccount\Application $application
     *
     * @throws \EasyWeChat\Kernel\Exceptions\InvalidArgumentException
     * @throws ReflectionException
     */
    public function autoReply(int $platformId, Application $application): void
    {
        // todo
    }

    /**
     * 欢迎关注语
     *
     * @param int                                     $platformId
     * @param \EasyWeChat\OfficialAccount\Application $application
     *
     * @throws \EasyWeChat\Kernel\Exceptions\InvalidArgumentException
     * @throws ReflectionException
     */
    public function welcomeSubscribe(int $platformId, Application $application): void
    {
        $application->server->push(function ($message) {
            // 关注事件
            if ($message['MsgType'] === 'event' && $message['Event'] === 'subscribe') {
                return '欢迎关注 Agarwood Cloud!';
            }
            return '';
        }, Message::EVENT);
    }
}
