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
use App\Support\OfficialAccountQueryParams;
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
            $this->application->indexProvider(
                $this->officialAccountQueryParams->getOfficialAccountId(),
                $dto
            )
        )->response();
    }

    /**
     * User activity records based on time
     *
     * @RequestMapping(route="user/timeline/{openid}", method={ RequestMethod::GET })
     * @param string $openid
     *
     * @return Response|null
     */
    public function actionTimeline(string $openid): ?Response
    {
        return $this->wrapper()->setData(
            $this->application->timelineProvider($openid)
        )->response();
    }
}
