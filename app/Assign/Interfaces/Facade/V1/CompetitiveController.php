<?php declare(strict_types=1);
/**
 * This file is part of Agarwood Cloud.
 *
 * @link     https://www.agarwood-cloud.com
 * @document https://www.agarwood-cloud.com/docs
 * @contact  676786620@qq.com
 * @author   agarwood
 */

namespace App\Assign\Interfaces\Facade\V1;

use Agarwood\Core\Support\Impl\AbstractBaseController;
use App\Assign\Application\CompetitiveApplication;
use App\Assign\Interfaces\Assembler\CompetitiveAssembler;
use App\Assign\Interfaces\DTO\Competitive\ChangeStatusDTO;
use App\Assign\Interfaces\DTO\Competitive\CreateDTO;
use App\Assign\Interfaces\DTO\Competitive\IndexDTO;
use App\Assign\Interfaces\DTO\Competitive\UpdateDTO;
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
 * 综合竞争力
 *
 * @Controller(prefix="/assign/v1")
 * @Middlewares({
 *     @Middleware(OAuthJWTMiddleware::class),
 * })
 */
class CompetitiveController extends AbstractBaseController
{
    /**
     * @\Swoft\Bean\Annotation\Mapping\Inject()
     *
     * @var CompetitiveApplication
     */
    protected CompetitiveApplication $application;

    /**
     * @\Swoft\Bean\Annotation\Mapping\Inject()
     *
     * @var \App\Support\ParsingToken $parsingToken
     */
    public ParsingToken $parsingToken;

    /**
     * 客服列表
     *
     * @RequestMapping(route="competitive", method={RequestMethod::GET})
     * @Validate(validator=IndexDTO::class, type=ValidateType::GET)
     * @Middleware(OAuthJWTMiddleware::class)
     * @param Request $request
     *
     * @return Response|null
     */
    public function actionIndex(Request $request): ?Response
    {
        $dto = CompetitiveAssembler::attributesToIndexDTO($request->getQueryParams());
        return $this->wrapper()->setData(
            $this->application->indexProvider(
                (int)$this->parsingToken->getPlatformId(),
                $dto
            )
        )->response();
    }

    /**
     * 创建竞争力参数
     *
     * @param Request  $request
     * @param Response $response
     *
     * @RequestMapping(route="competitive", method={ RequestMethod::POST})
     * @Validate(validator=CreateDTO::class, type=ValidateType::BODY)
     * @Middleware(OAuthJWTMiddleware::class)
     *
     * @return Response|null
     */
    public function actionCreate(Request $request, Response $response): ?Response
    {
        $dto = CompetitiveAssembler::attributesToCreateDTO((array)$request->getParsedBody());
        return $this->wrapper()->setData(
            $this->application->createProvider(
                (int)$this->parsingToken->getPlatformId(),
                $dto
            )
        )->response($response->withStatus(201));
    }

    /**
     * 更新竞争力参数
     *
     * @param Request $request
     * @param string  $id
     *
     * @return Response|null
     * @RequestMapping(route="competitive/{id}", method={ RequestMethod::PUT, RequestMethod::PATCH })
     * @Validate(validator=UpdateDTO::class, type=ValidateType::BODY)
     * @Middleware(OAuthJWTMiddleware::class)
     */
    public function actionUpdate(Request $request, string $id): ?Response
    {
        $dto = CompetitiveAssembler::attributesToUpdateDTO((array)$request->getParsedBody());
        return $this->wrapper()->setData(
            $this->application->updateProvider($id, $dto)
        )->response();
    }

    /**
     * 客服列表
     *
     * @RequestMapping(route="competitive/change-status/{id}", method={RequestMethod::PUT})
     * @Validate(validator=ChangeStatusDTO::class, type=ValidateType::BODY)
     * @Middleware(OAuthJWTMiddleware::class)
     * @param string  $id
     * @param Request $request
     *
     * @return Response|null
     */
    public function actionChangeStatus(string $id, Request $request): ?Response
    {
        $dto = CompetitiveAssembler::attributesToChangeDTO((array)$request->getParsedBody());
        return $this->wrapper()->setData(
            $this->application->changeStatusProvider($id, $dto)
        )->response();
    }
}
