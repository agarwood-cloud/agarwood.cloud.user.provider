<?php declare(strict_types=1);
/**
 * This file is part of Agarwood Cloud.
 *
 * @link     https://www.agarwood-cloud.com
 * @document https://www.agarwood-cloud.com/docs
 * @contact  676786620@qq.com
 * @author   agarwood
 */

namespace App\Customer\Interfaces\Facade\V3;

use Agarwood\Core\Support\Impl\AbstractBaseController;
use App\Customer\Application\CustomerApplication;
use App\Customer\Interfaces\Assembler\CustomerAssembler;
use App\Customer\Interfaces\DTO\Customer\ChatDTO;
use App\Customer\Interfaces\DTO\Customer\ChatRecordDTO;
use App\Customer\Interfaces\DTO\Customer\LoginDTO;
use App\Support\Middleware\OAuthJWTMiddleware;
use App\Support\ParsingToken;
use Swoft\Http\Message\Request;
use Swoft\Http\Message\Response;
use Swoft\Http\Server\Annotation\Mapping\Controller;
use Swoft\Http\Server\Annotation\Mapping\Middleware;
use Swoft\Http\Server\Annotation\Mapping\RequestMapping;
use Swoft\Http\Server\Annotation\Mapping\RequestMethod;
use Swoft\Validator\Annotation\Mapping\Validate;
use Swoft\Validator\Annotation\Mapping\ValidateType;

/**
 * @Controller(prefix="/customer/v3")
 */
class CustomerController extends AbstractBaseController
{
    /**
     * @\Swoft\Bean\Annotation\Mapping\Inject()
     *
     * @var \App\Support\ParsingToken $parsingToken
     */
    public ParsingToken $parsingToken;

    /**
     * @\Swoft\Bean\Annotation\Mapping\Inject()
     *
     * @var CustomerApplication
     */
    protected CustomerApplication $application;

    /**
     * 生成对应客服的专属二维码，扫码后可直接分配给该客服
     *
     * @RequestMapping(route="customer/scan-subscribe", method={RequestMethod::GET})
     * @Middleware(OAuthJWTMiddleware::class)
     * @param Request $request
     *
     * @return Response|null
     */
    public function actionScanSubscribe(Request $request): ?Response
    {
        return $this->wrapper()->setData(
            $this->application->scanSubscribeProvider(
                (int)$this->parsingToken->getOfficialAccountId(),
                (int)$this->parsingToken->getCustomerId()
            )
        )->response();
    }

    /**
     * 客服登陆接口
     *
     * @RequestMapping(route="customer/login", method={ RequestMethod::POST })
     * @Validate(validator=LoginDTO::class, type=ValidateType::BODY)
     * @param Request $request
     *
     * @return Response|null
     */
    public function actionLogin(Request $request): ?Response
    {
        $dto = CustomerAssembler::attributesToLoginDTO((array)$request->getParsedBody());
        return $this->wrapper()->setData(
            $this->application->loginProvider($dto)
        )->response();
    }

    /**
     * 获取聊天列表
     *
     * @RequestMapping(route="customer/chat", method={ RequestMethod::GET })
     * @Validate(validator=ChatDTO::class, type=ValidateType::GET)
     * @Middleware(OAuthJWTMiddleware::class)
     *
     * @param Request $request
     *
     * @return Response|null
     */
    public function actionChat(Request $request): ?Response
    {
        $dto = CustomerAssembler::attributesToChatDTO($request->getQueryParams());
        return $this->wrapper()->setData(
            $this->application->chatProvider((int)$this->parsingToken->getOfficialAccountId(), (int)$this->parsingToken->getCustomerId(), $dto)
        )->response();
    }

    /**
     * 获取聊天记录
     *
     * @RequestMapping(route="customer/chat-record", method={ RequestMethod::GET })
     * @Validate(validator=ChatRecordDTO::class, type=ValidateType::GET)
     * @Middleware(OAuthJWTMiddleware::class)
     *
     * @param Request $request
     *
     * @return Response|null
     */
    public function actionChatRecord(Request $request): ?Response
    {
        $dto = CustomerAssembler::attributesToChatRecordDTO($request->getQueryParams());
        return $this->wrapper()->setData(
            $this->application->chatRecordProvider((int)$this->parsingToken->getCustomerId(), $dto)
        )->response();
    }

    /**
     * 剔除客服抢粉的功能
     *
     * @RequestMapping(route="customer/obtain-offline/{ids}", method={RequestMethod::DELETE })
     *
     * @param string   $ids
     * @param Response $response
     *
     * @return Response|null
     */
    public function actionObtainOffline(string $ids, Response $response): ?Response
    {
        return $this->wrapper()->setData(
            $this->application->obtainOfflineProvider((int)$this->parsingToken->getOfficialAccountId(), $ids)
        )->response($response->withStatus(204));
    }

    /**
     * 查看客服是否抢粉
     *
     * @RequestMapping(route="customer/obtain-status/{id}", method={ RequestMethod::GET })
     *
     * @param int $id
     *
     * @return Response|null
     */
    public function actionObtainStatus(int $id): ?Response
    {
        return $this->wrapper()->setData(
            $this->application->obtainStatusProvider((int)$this->parsingToken->getOfficialAccountId(), $id)
        )->response();
    }
}
