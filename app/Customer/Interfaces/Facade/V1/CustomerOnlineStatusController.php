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
use App\Customer\Application\CustomerInspectApplication;
use App\Customer\Interfaces\Assembler\CustomerServiceAssembler;
use App\Customer\Interfaces\DTO\Customer\CustomerServiceIndexDTO;
use App\Support\Middleware\OAuthJWTMiddleware;
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
 * 客服聊天记录稽查
 *
 * @Controller(prefix="/customer/v1")
 * @Middlewares({
 *      @Middleware(OAuthJWTMiddleware::class),
 * })
 */
class CustomerOnlineStatusController extends AbstractBaseController
{
    /**
     * @\Swoft\Bean\Annotation\Mapping\Inject()
     *
     * @var CustomerInspectApplication
     */
    protected CustomerInspectApplication $application;

    /**
     * 粉丝列表
     *
     * @RequestMapping(route="customer-online-status", method={RequestMethod::GET})
     * @Validate(validator=CustomerServiceIndexDTO::class, type=ValidateType::GET)
     * @param Request $request
     *
     * @return Response|null
     */
    public function actionIndex(Request $request): ?Response
    {
        $dto = CustomerServiceAssembler::attributesToIndexDTO($request->getQueryParams());
        return $this->wrapper()->setData(
            $this->application->indexProvider($dto)
        )->response();
    }

    /**
     * 查看粉丝详情
     *
     * @RequestMapping(route="customer-online-status/{uuid}", method={RequestMethod::GET},params={"uuid"="[A-Za-z0-9_-]+"})
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
