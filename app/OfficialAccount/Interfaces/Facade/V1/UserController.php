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
use App\OfficialAccount\Interfaces\DTO\User\IndexDTO;
use App\OfficialAccount\Interfaces\DTO\User\UpdateDTO;
use App\OfficialAccount\Interfaces\DTO\User\UpdateGroupDTO;
use App\Support\Middleware\OAuthJWTMiddleware;
use App\Support\OfficialAccountQueryParams;
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
     * @\Swoft\Bean\Annotation\Mapping\Inject()
     *
     * @var \App\OfficialAccount\Application\UserApplication
     */
    public UserApplication $application;

    /**
     * @\Swoft\Bean\Annotation\Mapping\Inject()
     *
     * @var \App\Support\OfficialAccountQueryParams
     */
    public OfficialAccountQueryParams $officialAccountQueryParams;

    /**
     * 粉丝列表
     *
     * @RequestMapping(route="user", method={RequestMethod::GET})
     * @Validate(validator=IndexDTO::class, type=ValidateType::GET)
     * @param Request $request
     *
     * @return Response|null
     */
    public function actionIndex(Request $request): ?Response
    {
        $dto = UserAssembler::attributesToIndexDTO($request->getQueryParams());
        return $this->wrapper()->setData(
            $this->application->indexProvider(
                $this->officialAccountQueryParams->getOfficialAccountId(),
                $dto
            )
        )->response();
    }

    /**
     * Update User Info
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
     * Delete User
     *
     * @RequestMapping(route="user/{openid}", method={ RequestMethod::DELETE })
     * @param string   $openid
     * @param Response $response
     *
     * @return Response|null
     */
    public function actionDelete(string $openid, Response $response): ?Response
    {
        return $this->wrapper()->setData([
            'result' => $this->application->deleteProvider($openid)
        ])->response($response->withStatus(204));
    }

    /**
     * View User Info
     *
     * @RequestMapping(route="user/{openid}", method={RequestMethod::GET})
     * @param string $openid
     *
     * @return \Swoft\Http\Message\Response|null
     */
    public function actionView(string $openid): ?Response
    {
        return $this->wrapper()->setData(
            $this->application->viewProvider($openid)
        )->response();
    }
}
