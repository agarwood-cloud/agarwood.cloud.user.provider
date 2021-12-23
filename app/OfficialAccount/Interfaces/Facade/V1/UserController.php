<?php declare(strict_types=1);
/**
 * This file is part of Agarwood Cloud.
 *
 * @link     https://www.agarwood-cloud.com
 * @document https://www.agarwood-cloud.com/docs
 * @contact  676786620@qq.com
 * @author   agarwood
 */

namespace App\OfficialAccount\Interfaces\Facade\V1;

use Agarwood\Core\Support\Impl\AbstractBaseController;
use App\OfficialAccount\Application\UserApplication;
use App\OfficialAccount\Interfaces\Assembler\UserAssembler;
use App\OfficialAccount\Interfaces\DTO\User\UpdateGroupDTO;
use App\OfficialAccount\Interfaces\DTO\User\CreateDTO;
use App\OfficialAccount\Interfaces\DTO\User\UserIndexDTO;
use App\OfficialAccount\Interfaces\DTO\User\UpdateDTO;
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
 * @Controller(prefix="/official-account/v1")
 * @Middlewares({
 *      @Middleware(OAuthJWTMiddleware::class),
 * })
 */
class UserController extends AbstractBaseController
{
    /**
     * @\Swoft\Bean\Annotation\Mapping\Inject()
     *
     * @var \App\Support\ParsingToken $parsingToken
     */
    public ParsingToken $parsingToken;

    /**
     * 应用层
     *
     * @\Swoft\Bean\Annotation\Mapping\Inject()
     * @var UserApplication
     */
    protected UserApplication $application;

    /**
     * 粉丝列表
     *
     * @RequestMapping(route="user", method={RequestMethod::GET})
     * @Validate(validator=UserIndexDTO::class, type=ValidateType::GET)
     * @param Request $request
     *
     * @return Response|null
     */
    public function actionIndex(Request $request): ?Response
    {
        $dto = UserAssembler::attributesToIndexDTO($request->getQueryParams());
        return $this->wrapper()->setData(
            $this->application->indexProvider(
                $this->parsingToken->getOfficialAccountId(),
                $dto
            )
        )->response();
    }

    /**
     * 新建客户信息
     *
     * @param Request  $request
     * @param Response $response
     *
     * @RequestMapping(route="user", method={ RequestMethod::POST})
     * @Validate(validator=CreateDTO::class, type=ValidateType::BODY)
     *
     * @return Response|null
     */
    public function actionCreate(Request $request, Response $response): ?Response
    {
        $dto = UserAssembler::attributesToCreateDTO((array)$request->getParsedBody());
        return $this->wrapper()->setData(
            $this->application->createProvider($dto)
        )->response($response->withStatus(201));
    }

    /**
     * 更新粉丝信息
     *
     * @param Request $request
     * @param string  $openid
     *
     * @return Response|null
     * @Validate(validator=UpdateDTO::class, type=ValidateType::BODY)
     * @RequestMapping(route="user/{openid}", method={RequestMethod::PUT, RequestMethod::PATCH})
     */
    public function actionUpdate(Request $request, string $openid): ?Response
    {
        $dto = UserAssembler::attributesToUpdateDTO((array)$request->getParsedBody());
        return $this->wrapper()->setData(
            $this->application->updateProvider($openid, $dto)
        )->response();
    }

    /**
     * 更新粉丝信息
     *
     * @param Request $request
     * @param string  $openid
     *
     * @return Response|null
     * @Validate(validator=UpdateGroupDTO::class, type=ValidateType::BODY)
     * @RequestMapping(route="user/assign-customer/{openid}", method={RequestMethod::PUT, RequestMethod::PATCH})
     */
    public function actionAssignCustomer(Request $request, string $openid): ?Response
    {
        $dto = UserAssembler::attributesToAssignCustomerDTO((array)$request->getParsedBody());
        return $this->wrapper()->setData(
            $this->application->assignCustomerProvider($openid, $dto)
        )->response();
    }

    /**
     * 删除粉丝信息
     *
     * @RequestMapping(route="user/{uuids}", method={ RequestMethod::DELETE},params={"uuids"="[A-Za-z0-9_,-]+"})
     * @param string   $uuids
     * @param Response $response
     *
     * @return Response|null
     */
    public function actionDelete(string $uuids, Response $response): ?Response
    {
        return $this->wrapper()->setData([
            'result' => $this->application->deleteProvider($uuids)
        ])->response($response->withStatus(204));
    }

    /**
     * 查看粉丝详情
     *
     * @RequestMapping(route="user/{uuid}", method={RequestMethod::GET})
     * @param string $uuid
     *
     * @return Response|null
     */
    public function actionView(string $uuid): ?Response
    {
        return $this->wrapper()->setData(
            $this->application->viewProvider($uuid)
        )->response();
    }
}
