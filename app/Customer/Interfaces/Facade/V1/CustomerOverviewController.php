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
use App\Customer\Application\CustomerOverviewApplication;
use App\Customer\Interfaces\Assembler\CustomerOverviewAssembler;
use App\Customer\Interfaces\DTO\CustomerOverview\IndexDTO;
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
 *      @Middleware(OAuthJWTMiddleware::class),
 * })
 */
class CustomerOverviewController extends AbstractBaseController
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
     * @var CustomerOverviewApplication
     */
    public CustomerOverviewApplication $application;

    /**
     * 客服预览
     *
     * @RequestMapping(route="customer-overview", method={RequestMethod::GET})
     * @Validate(validator=IndexDTO::class, type=ValidateType::GET)
     * @param Request $request
     *
     * @return Response|null
     */
    public function actionIndex(Request $request): ?Response
    {
        $dto = CustomerOverviewAssembler::attributesToIndexDTO($request->getQueryParams());
        return $this->wrapper()->setData(
            $this->application->indexProvider((int)$this->parsingToken->getOfficialAccountId(), $dto)
        )->response();
    }
}
