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
use App\Customer\Application\CustomerGroupApplication;
use App\Customer\Interfaces\Assembler\CustomerGroupAssembler;
use App\Customer\Interfaces\DTO\Group\CustomerGroupCreateDTO;
use App\Customer\Interfaces\DTO\Group\CustomerGroupIndexDTO;
use App\Customer\Interfaces\DTO\Group\CustomerGroupUpdateDTO;
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
 * @Controller(prefix="/customer/v1")
 * @Middlewares({
 *      @Middleware(OAuthJWTMiddleware::class)
 * })
 */
class CustomerGroupController extends AbstractBaseController
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
     *
     * @var \App\Customer\Application\CustomerGroupApplication
     */
    public CustomerGroupApplication $application;

    /**
     * @\Swoft\Bean\Annotation\Mapping\Inject()
     *
     * @var \App\Support\OfficialAccountQueryParams
     */
    public OfficialAccountQueryParams $officialAccountQueryParams;

    /**
     * 客服分组列表
     *
     * @RequestMapping(route="customer-group", method={ RequestMethod::OPTIONS ,RequestMethod::GET})
     * @Validate(validator=CustomerGroupIndexDTO::class, type=ValidateType::GET)
     * @param Request $request
     *
     * @return Response|null
     */
    public function actionIndex(Request $request): ?Response
    {
        $dto = CustomerGroupAssembler::attributesToIndexDTO($request->getQueryParams());
        return $this->wrapper()->setData(
            $this->application->indexProvider(
                (int) $this->officialAccountQueryParams->getPlatformId(),
                $dto
            )
        )->response();
    }

    /**
     * 创建客服分组
     *
     * @param Request  $request
     * @param Response $response
     *
     * @RequestMapping(route="customer-group", method={ RequestMethod::POST})
     * @Validate(validator=CustomerGroupCreateDTO::class, type=ValidateType::BODY)
     *
     * @return Response|null
     */
    public function actionCreate(Request $request, Response $response): ?Response
    {
        $DTO = CustomerGroupAssembler::attributesToCreateDTO((array)$request->getParsedBody());
        return $this->wrapper()->setData(
            $this->application->createProvider(
                (int) $this->officialAccountQueryParams->getPlatformId(),
                $DTO
            )
        )->response($response->withStatus(201));
    }

    /**
     * 更新客服分组信息
     *
     * @param Request $request
     * @param int  $id
     *
     * @return Response|null
     * @Validate(validator=CustomerGroupUpdateDTO::class, type=ValidateType::BODY)
     * @RequestMapping(route="customer-group/{id}", method={RequestMethod::PUT, RequestMethod::PATCH})
     */
    public function actionUpdate(Request $request, int $id): ?Response
    {
        $DTO = CustomerGroupAssembler::attributesToUpdateDTO((array)$request->getParsedBody());
        return $this->wrapper()->setData(
            $this->application->updateProvider($id, $DTO)
        )->response();
    }

    /**
     * 删除客服分组信息
     *
     * @RequestMapping(route="customer-group/{ids}", method={ RequestMethod::DELETE})
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
     * 查看客服分组详情
     *
     * @RequestMapping(route="customer-group/{id}", method={RequestMethod::GET})
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
}
