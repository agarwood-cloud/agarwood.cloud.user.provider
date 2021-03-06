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
use App\OfficialAccount\Domain\DefaultMessageHandlerDomain;
use App\OfficialAccount\Domain\EventMessageHandlerDomain;
use App\OfficialAccount\Domain\ImageMessageHandlerDomain;
use App\OfficialAccount\Domain\LinkMessageHandlerDomain;
use App\OfficialAccount\Domain\LocationMessageHandlerDomain;
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
     * @var \App\OfficialAccount\Domain\LocationMessageHandlerDomain
     */
    public LocationMessageHandlerDomain $locationMessageHandlerDomain;

    /**
     * @\Swoft\Bean\Annotation\Mapping\Inject()
     *
     * @var \App\OfficialAccount\Domain\LinkMessageHandlerDomain
     */
    public LinkMessageHandlerDomain $linkMessageHandlerDomain;

    /**
     * @\Swoft\Bean\Annotation\Mapping\Inject()
     *
     * @var \App\OfficialAccount\Domain\DefaultMessageHandlerDomain
     */
    public DefaultMessageHandlerDomain $defaultMessageHandlerDomain;

    /**
     * ??????????????????
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
        | 1. default ??? event????????????????????????????????????????????????????????????
        | 2. default ???????????????????????????redis???????????????????????????????????????
        | 3. event ????????????????????????????????? mysql
        |-----------------------------------------------------------------
        */

        $app = $this->officialAccountsRpc->officialAccountApplication((int)$platformId);

        $enterpriseId = $this->officialAccountsRpc->getEnterpriseId((int)$platformId);

        // ??????????????? && ????????????
        $this->welcomeSubscribeDomain->welcomeSubscribe((int)$platformId, $app);
        $this->welcomeSubscribeDomain->autoReply((int)$platformId, $app);

        // ???????????????
        $this->eventMessageHandlerDomain->eventSubscribe($enterpriseId, (int)$platformId, $app);
        $this->eventMessageHandlerDomain->eventUnsubscribe($enterpriseId, (int)$platformId, $app);
        $this->eventMessageHandlerDomain->eventClick($enterpriseId, (int)$platformId, $app);
        $this->eventMessageHandlerDomain->eventScan($enterpriseId, (int)$platformId, $app);
        $this->eventMessageHandlerDomain->eventView($enterpriseId, (int)$platformId, $app);

        // ?????????????????????, ???????????????????????????????????????????????????
        $this->defaultMessageHandlerDomain->defaultMessage($enterpriseId, (int)$platformId, $app);

        // ????????????
        $this->textMessageHandlerDomain->textMessage((int)$platformId, $app);

        // ????????????
        $this->voiceMessageHandlerDomain->voiceMessage((int)$platformId, $app);

        // ????????????
        $this->videoMessageHandlerDomain->videoMessage((int)$platformId, $app);

        // ????????????
        $this->imageMessageHandlerDomain->imageMessage((int)$platformId, $app);

        // todo ????????????

        // ??????????????????
        $this->locationMessageHandlerDomain->locationMessage((int)$platformId, $app);

        // ??????
        $this->linkMessageHandlerDomain->linkMessage((int)$platformId, $app);

        // todo ????????????

        // todo ????????????

        // ?????????????????????
        return $app->server->serve();
    }
}
