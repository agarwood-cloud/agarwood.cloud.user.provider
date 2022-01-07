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
use App\OfficialAccount\Application\FansApplication;
use App\OfficialAccount\Interfaces\Assembler\FansAssembler;
use App\OfficialAccount\Interfaces\DTO\Fans\GroupUserDTO;
use App\OfficialAccount\Interfaces\DTO\Fans\IndexDTO;
use App\OfficialAccount\Interfaces\DTO\Fans\MoveGroupDTO;
use App\OfficialAccount\Interfaces\DTO\Fans\UpdateDTO;
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
 * @Controller(prefix="/official-account/v3")
 * @Middlewares({
 *     @Middleware(OAuthJWTMiddleware::class)
 * })
 * @deprecated Archived, please do not use!
 */
class FansController extends AbstractBaseController
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
     * @var \App\OfficialAccount\Application\FansApplication
     */
    protected FansApplication $application;

    /**
     * 粉丝列表
     *
     * @RequestMapping(route="fans", method={RequestMethod::GET})
     * @Validate(validator=IndexDTO::class, type=ValidateType::GET)
     * @param Request $request
     *
     * @return Response|null
     */
    public function actionIndex(Request $request): ?Response
    {
        $dto = FansAssembler::attributesToIndexDTO($request->getQueryParams());
        return $this->wrapper()->setData(
            $this->application->indexProvider(
                (int)$this->parsingToken->getCustomerId(),
                $dto
            )
        )->response();
    }

    /**
     * 更新粉丝信息
     *
     * @param Request $request
     * @param string  $id
     *
     * @return Response|null
     * @Validate(validator=UpdateDTO::class, type=ValidateType::BODY)
     * @RequestMapping(route="fans/{id}", method={RequestMethod::PUT, RequestMethod::PATCH})
     */
    public function actionUpdate(Request $request, string $id): ?Response
    {
        $DTO = FansAssembler::attributesToUpdateDTO((array)$request->getParsedBody());
        return $this->wrapper()->setData(
            $this->application->updateProvider($id, $DTO)
        )->response();
    }

    /**
     * 查看粉丝详情
     *
     * @RequestMapping(route="fans/{openid}", method={ RequestMethod::GET })
     * @param string $openid
     *
     * @return Response|null
     */
    public function actionView(string $openid): ?Response
    {
        return $this->wrapper()->setData(
            $this->application->viewProvider($openid)
        )->response();
    }

    /**
     * 客服所在组的粉丝列表
     *
     * @RequestMapping(route="fans/group-user", method={RequestMethod::GET})
     * @Validate(validator=GroupUserDTO::class, type=ValidateType::GET)
     * @param Request $request
     *
     * @return Response|null
     */
    public function actionGroupUser(Request $request): ?Response
    {
        $dto = FansAssembler::attributesToGroupUserDTO($request->getQueryParams());
        return $this->wrapper()->setData(
            $this->application->groupUserProvider((int)$this->parsingToken->getCustomerId(), $dto)
        )->response();
    }

    /**
     * 移动粉丝到xx分组
     *
     * @param Request $request
     *
     * @return Response|null
     * @Validate(validator=MoveGroupDTO::class, type=ValidateType::BODY)
     * @RequestMapping(route="fans/move-group", method={RequestMethod::PUT, RequestMethod::PATCH})
     */
    public function actionMoveGroup(Request $request): ?Response
    {
        $DTO = FansAssembler::attributesToMoveGroupDTO((array)$request->getParsedBody());
        return $this->wrapper()->setData(
            $this->application->moveGroupProvider($DTO)
        )->response();
    }

    /**
     * 粉丝时间线
     *
     * @param string $openid
     *
     * @return Response|null
     * @RequestMapping(route="fans/timeline/{openid}", method={ RequestMethod::GET })
     */
    public function actionTimeline(string $openid): ?Response
    {
        return $this->wrapper()->setData(
            $this->application->timelineProvider($openid)
        )->response();
    }
}
