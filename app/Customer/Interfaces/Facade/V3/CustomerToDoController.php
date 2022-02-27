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
use App\Customer\Application\CustomerToDoApplication;
use App\Customer\Interfaces\Assembler\CustomerToDoAssembler;
use App\Customer\Interfaces\DTO\CustomerToDo\CreateDTO;
use App\Customer\Interfaces\DTO\CustomerToDo\IndexDTO;
use App\Customer\Interfaces\DTO\CustomerToDo\UpdateDTO;
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
 * @Controller(prefix="/customer/v3")
 * @Middlewares({
 *     @Middleware(OAuthJWTMiddleware::class)
 * })
 */
class CustomerToDoController extends AbstractBaseController
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
     * @var CustomerToDoApplication
     */
    protected CustomerToDoApplication $application;

    /**
     * 列表
     *
     * @RequestMapping(route="customer-to-do", method={ RequestMethod::GET })
     * @Validate(validator=IndexDTO::class, type=ValidateType::GET)
     * @param Request $request
     *
     * @return Response|null
     */
    public function actionIndex(Request $request): ?Response
    {
        $dto = CustomerToDoAssembler::attributesToIndexDTO($request->getQueryParams());
        return $this->wrapper()->setData(
            $this->application->indexProvider((int)$this->parsingToken->getPlatformId(), (int)$this->parsingToken->getCustomerId(), $dto)
        )->response();
    }

    /**
     * 创建
     *
     * @param Request  $request
     * @param Response $response
     *
     * @RequestMapping(route="customer-to-do", method={ RequestMethod::POST })
     * @Validate(validator=CreateDTO::class, type=ValidateType::BODY)
     *
     * @return Response|null
     */
    public function actionCreate(Request $request, Response $response): ?Response
    {
        $DTO = CustomerToDoAssembler::attributesToCreateDTO((array)$request->getParsedBody());
        return $this->wrapper()->setData(
            $this->application->createProvider((int)$this->parsingToken->getPlatformId(), (int)$this->parsingToken->getCustomerId(), $DTO)
        )->response($response->withStatus(201));
    }

    /**
     * 更新
     *
     * @param Request $request
     * @param int     $id
     *
     * @return Response|null
     * @Validate(validator=UpdateDTO::class, type=ValidateType::BODY)
     * @RequestMapping(route="customer-to-do/{uuid}", method={ RequestMethod::PUT, RequestMethod::PATCH })
     */
    public function actionUpdate(Request $request, int $id): ?Response
    {
        $DTO = CustomerToDoAssembler::attributesToUpdateDTO((array)$request->getParsedBody());
        return $this->wrapper()->setData(
            $this->application->updateProvider($id, $DTO)
        )->response();
    }

    /**
     * 删除
     *
     * @RequestMapping(route="customer-to-do/{ids}", method={ RequestMethod::DELETE})
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
}
