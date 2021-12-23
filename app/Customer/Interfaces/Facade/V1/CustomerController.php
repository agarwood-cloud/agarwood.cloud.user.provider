<?php declare(strict_types=1);
/**
 * This file is part of Agarwood Cloud.
 *
 * @link     https://www.agarwood-cloud.com
 * @document https://www.agarwood-cloud.com/docs
 * @contact  676786620@qq.com
 * @author   agarwood
 */

namespace App\Customer\Interfaces\Facade\V1;

use Agarwood\Core\Support\Impl\AbstractBaseController;
use App\Customer\Application\CustomerApplication;
use App\Customer\Interfaces\Assembler\CustomerAssembler;
use App\Customer\Interfaces\DTO\Customer\ChangeStatusDTO;
use App\Customer\Interfaces\DTO\Customer\ChatRecordDTO;
use App\Customer\Interfaces\DTO\Customer\CustomerServiceCreateDTO;
use App\Customer\Interfaces\DTO\Customer\CustomerServiceIndexDTO;
use App\Customer\Interfaces\DTO\Customer\CustomerServiceUpdateDTO;
use App\Customer\Interfaces\DTO\Customer\LoginDTO;
use App\Support\Middleware\OAuthJWTMiddleware;
use App\Support\ParsingToken;
use Swoft\Http\Message\Request;
use Swoft\Http\Message\Response;
use Swoft\Http\Server\Annotation\Mapping\Controller;
use Swoft\Http\Server\Annotation\Mapping\Middleware;
use Swoft\Http\Server\Annotation\Mapping\Middlewares;
use Swoft\Http\Server\Annotation\Mapping\RequestMapping;
use Swoft\Http\Server\Annotation\Mapping\RequestMethod;
use Swoft\Validator\Annotation\Mapping\Validate;
use Swoft\Validator\Annotation\Mapping\ValidateType;

/**
 * @Controller(prefix="/customer/v1")
 * @Middlewares({
 *     @Middleware(OAuthJWTMiddleware::class),
 * })
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
     * 客服列表
     *
     * @RequestMapping(route="customer", method={RequestMethod::GET})
     * @Validate(validator=CustomerServiceIndexDTO::class, type=ValidateType::GET)
     * @param Request $request
     *
     * @return Response|null
     */
    public function actionIndex(Request $request): ?Response
    {
        $dto = CustomerAssembler::attributesToIndexDTO($request->getQueryParams());
        return $this->wrapper()->setData(
            $this->application->indexProvider((int)$this->parsingToken->getOfficialAccountId(), $dto)
        )->response();
    }

    /**
     * 创建客服
     *
     * @param Request  $request
     * @param Response $response
     *
     * @RequestMapping(route="customer", method={ RequestMethod::POST})
     * @Validate(validator=CustomerServiceCreateDTO::class, type=ValidateType::BODY)
     *
     * @return Response|null
     */
    public function actionCreate(Request $request, Response $response): ?Response
    {
        $dto = CustomerAssembler::attributesToCreateDTO((array)$request->getParsedBody());
        return $this->wrapper()->setData(
            $this->application->createProvider((int)$this->parsingToken->getOfficialAccountId(), $dto)
        )->response($response->withStatus(201));
    }

    /**
     * 更新客服信息
     *
     * @param Request $request
     * @param int     $id
     *
     * @return Response|null
     * @Validate(validator=CustomerServiceUpdateDTO::class, type=ValidateType::BODY)
     * @RequestMapping(route="customer/{id}", method={RequestMethod::PUT, RequestMethod::PATCH})
     */
    public function actionUpdate(Request $request, int $id): ?Response
    {
        $dto = CustomerAssembler::attributesToUpdateDTO((array)$request->getParsedBody());
        return $this->wrapper()->setData(
            $this->application->updateProvider($id, $dto)
        )->response();
    }

    /**
     * 删除客服信息
     *
     * @RequestMapping(route="customer/{ids}", method={ RequestMethod::DELETE })
     * @param string   $ids
     * @param Response $response
     *
     * @return Response|null
     */
    public function actionDelete(string $ids, Response $response): ?Response
    {
        return $this->wrapper()->setData([
            'result' => $this->application->deleteProvider($ids)
        ])->response($response->withStatus(204));
    }

    /**
     * 查看客服详情
     *
     * @RequestMapping(route="customer/{id}", method={ RequestMethod::GET })
     * @param int $id
     *
     * @return Response|null
     */
    public function actionView(int $id): ?Response
    {
        return $this->wrapper()->setData(
            $this->application->viewProvider($id)
        )->response();
    }

    /**
     * 生成对应客服的专属二维码，扫码后可直接分配给该客服
     *
     * @RequestMapping(route="customer-scan-subscribe", method={ RequestMethod::GET })
     * @param Request $request
     *
     * @return Response|null
     */
    public function actionScanSubscribe(Request $request): ?Response
    {
        return $this->wrapper()->setData(
            $this->application->scanSubscribeProvider(
                (int)$this->parsingToken->getOfficialAccountId(),
                (int)$this->parsingToken->getCustomerId(),
            )
        )->response();
    }

    /**
     * 更新客服可用状态信息
     *
     * @param Request $request
     * @param int     $id
     *
     * @Validate(validator=ChangeStatusDTO::class, type=ValidateType::BODY)
     * @RequestMapping(route="customer/change-status/{id}", method={ RequestMethod::PUT, RequestMethod::PATCH })
     *
     * @return Response|null
     */
    public function actionChangeStatus(Request $request, int $id): ?Response
    {
        $dto = CustomerAssembler::attributesToChangeStatusDTO((array)$request->getParsedBody());
        return $this->wrapper()->setData(
            $this->application->changeStatusProvider($id, $dto)
        )->response();
    }

    /**
     * 客服后台登陆
     *
     * @Validate(validator=LoginDTO::class, type=ValidateType::BODY)
     * @RequestMapping(route="customer/login", method={RequestMethod::POST })
     *
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
     * 获取聊天记录
     *
     * @RequestMapping(route="customer/chat-record", method={ RequestMethod::GET })
     * @Validate(validator=ChatRecordDTO::class, type=ValidateType::GET)
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
     * 一键清除正在抢粉的客服
     *
     * @RequestMapping(route="customer/obtain-fans-offline", method={ RequestMethod::POST })
     *
     *
     * @return Response|null
     */
    public function actionObtainFansOffline(): ?Response
    {
        return $this->wrapper()->setData(
            $this->application->obtainFansOfflineProvider((int)$this->parsingToken->getOfficialAccountId())
        )->response();
    }
}
