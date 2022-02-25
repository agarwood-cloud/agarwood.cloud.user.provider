<?php declare(strict_types=1);
/**
 * This file is part of Agarwood Cloud.
 *
 * @link     https://www.agarwood-cloud.com
 * @document https://www.agarwood-cloud.com/docs
 * @contact  676786620@qq.com
 * @author   agarwood
 */

namespace App\OfficialAccount\Application\Impl;

use App\OfficialAccount\Application\CallbackApplication;
use App\OfficialAccount\Domain\EventMessageHandlerDomain;
use App\OfficialAccount\Domain\ImageMessageHandlerDomain;
use App\OfficialAccount\Domain\SendToNodeDomain;
use App\OfficialAccount\Domain\TextMessageHandlerDomain;
use App\OfficialAccount\Domain\VideoMessageHandlerDomain;
use App\OfficialAccount\Domain\VoiceMessageHandlerDomain;
use App\OfficialAccount\Domain\WelcomeSubscribeDomain;
use App\OfficialAccount\Interfaces\Rpc\Client\MallCenter\OfficialAccountsRpc;
use Symfony\Component\HttpFoundation\Response;

/**
 * @\Swoft\Bean\Annotation\Mapping\Bean()
 */
class CallbackApplicationImpl implements CallbackApplication
{
    /**
     * @\Swoft\Bean\Annotation\Mapping\Inject()
     *
     * @var \App\OfficialAccount\Interfaces\Rpc\Client\MallCenter\OfficialAccountsRpc
     */
    public OfficialAccountsRpc $officialAccountsRpc;

    /**
     * @\Swoft\Bean\Annotation\Mapping\Inject()
     *
     * @var \App\OfficialAccount\Domain\EventMessageHandlerDomain
     */
    public EventMessageHandlerDomain $eventMessageHandlerDomain;

    /**
     * @\Swoft\Bean\Annotation\Mapping\Inject()
     *
     * @var \App\OfficialAccount\Domain\TextMessageHandlerDomain
     */
    public TextMessageHandlerDomain $textMessageHandlerDomain;

    /**
     * @\Swoft\Bean\Annotation\Mapping\Inject()
     *
     * @var \App\OfficialAccount\Domain\VoiceMessageHandlerDomain
     */
    public VoiceMessageHandlerDomain $voiceMessageHandlerDomain;

    /**
     * @\Swoft\Bean\Annotation\Mapping\Inject()
     *
     * @var \App\OfficialAccount\Domain\VideoMessageHandlerDomain
     */
    public VideoMessageHandlerDomain $videoMessageHandlerDomain;

    /**
     * @\Swoft\Bean\Annotation\Mapping\Inject()
     *
     * @var \App\OfficialAccount\Domain\WelcomeSubscribeDomain
     */
    public WelcomeSubscribeDomain $welcomeSubscribeDomain;

    /**
     * @\Swoft\Bean\Annotation\Mapping\Inject()
     *
     * @var \App\OfficialAccount\Domain\ImageMessageHandlerDomain
     */
    public ImageMessageHandlerDomain $imageMessageHandlerDomain;

    /**
     * @\Swoft\Bean\Annotation\Mapping\Inject()
     *
     * @var \App\OfficialAccount\Domain\SendToNodeDomain
     */
    public SendToNodeDomain $sendToNodeDomain;

    /**
     * 微信事件回调
     *
     * @param int|string $platformId
     *
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \EasyWeChat\Kernel\Exceptions\BadRequestException
     * @throws \EasyWeChat\Kernel\Exceptions\InvalidArgumentException
     * @throws \EasyWeChat\Kernel\Exceptions\InvalidConfigException
     */
    public function officialAccountProvider(int|string $platformId): Response
    {
        /*
        |-----------------------------------------------------------------
        | 1. default 和 event事件可以向下传播，其它事件处理完成则返回
        | 2. default 把用户的信息缓存到redis，避免每次都读取数据库的值
        | 3. event 确保把用户的信息都写到 mysql
        |-----------------------------------------------------------------
        */

        $app = $this->officialAccountsRpc->officialAccountApplication((int)$platformId);

        // 关注欢迎语 && 自动回复
        $this->welcomeSubscribeDomain->welcomeSubscribe((int)$platformId, $app);
        $this->welcomeSubscribeDomain->autoReply((int)$platformId, $app);

        // 事件处理器
        $this->eventMessageHandlerDomain->eventSubscribe((int)$platformId, $app);
        $this->eventMessageHandlerDomain->eventUnsubscribe((int)$platformId, $app);
        $this->eventMessageHandlerDomain->eventClick((int)$platformId, $app);
        $this->eventMessageHandlerDomain->eventScan((int)$platformId, $app);
        $this->eventMessageHandlerDomain->eventView((int)$platformId, $app);

        // 默认事件处理器, 缓存粉丝信息
        // $this->defaultMessageHandlerDomain->defaultMessage((int)$platformId, $app);

        // 文本消息
        $this->textMessageHandlerDomain->textMessage((int)$platformId, $app);

        // 音频消息
        $this->voiceMessageHandlerDomain->voiceMessage((int)$platformId, $app);

        // 视频消息
        $this->videoMessageHandlerDomain->videoMessage((int)$platformId, $app);

        // 图片消息
        $this->imageMessageHandlerDomain->imageMessage((int)$platformId, $app);

        // todo 文件消息

        // todo 地理位置消息

        // todo 其它消息

        // todo 群发消息

        // 返回服务端消息
        return $app->server->serve();
    }
}
