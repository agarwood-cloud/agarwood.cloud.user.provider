<?php declare(strict_types=1);
/**
 * This file is part of Agarwood Cloud.
 *
 * @link     https://www.agarwood-cloud.com
 * @document https://www.agarwood-cloud.com/docs
 * @contact  676786620@qq.com
 * @author   agarwood
 */

namespace App\OfficialAccount\Interfaces\Facade\V3;

use Agarwood\Core\Support\Impl\AbstractBaseController;
use App\OfficialAccount\Application\UserApplication;
use App\OfficialAccount\Interfaces\Assembler\UserAssembler;
use App\OfficialAccount\Interfaces\DTO\User\IndexDTO;
use App\Support\Middleware\OAuthJWTMiddleware;
use App\Support\SocketIOClient;
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
 * 用户头像信息
 *
 * @Middlewares({
 *     @Middleware(OAuthJWTMiddleware::class)
 * })
 * @Controller(prefix="/official-account/v3")
 */
class UserController extends AbstractBaseController
{
    /**
     * @\Swoft\Bean\Annotation\Mapping\Inject()
     *
     * @var \App\OfficialAccount\Application\UserApplication
     */
    protected UserApplication $application;

    /**
     * 粉丝列表
     *
     * @RequestMapping(route="user", method={ RequestMethod::GET })
     * @Validate(validator=IndexDTO::class, type=ValidateType::GET)
     * @param Request $request
     *
     * @return Response|null
     */
    public function actionIndex(Request $request): ?Response
    {
        $dto = UserAssembler::attributesToIndexV3DTO($request->getQueryParams());
        return $this->wrapper()->setData(
            $this->application->indexV3Provider($dto)
        )->response();
    }
}
