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
use App\OfficialAccount\Application\BroadcastingApplication;
use App\OfficialAccount\Interfaces\Assembler\BroadcastingAssembler;
use App\OfficialAccount\Interfaces\DTO\Broadcasting\IndexDTO;
use App\OfficialAccount\Interfaces\DTO\Broadcasting\SendTextDTO;
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
class BroadcastingController extends AbstractBaseController
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
     * @var BroadcastingApplication
     */
    protected BroadcastingApplication $application;

    /**
     * 已发送的消息列表
     *
     * @RequestMapping(route="broadcasting", method={ RequestMethod::GET })
     * @Validate(validator=IndexDTO::class, type=ValidateType::GET)
     * @param Request $request
     *
     * @return Response|null
     */
    public function actionIndex(Request $request): ?Response
    {
        $dto = BroadcastingAssembler::attributesToIndexDTO($request->getQueryParams());
        return $this->wrapper()->setData(
            $this->application->indexProvider(
                (int)$this->parsingToken->getOfficialAccountId(),
                $dto
            )
        )->response();
    }

    /**
     * 群发文本消息
     *
     * @RequestMapping(route="broadcasting/send-text", method={ RequestMethod::POST })
     * @Validate(validator=SendTextDTO::class, type=ValidateType::BODY)
     * @param Request $request
     *
     * @return Response|null
     */
    public function actionSendText(Request $request): ?Response
    {
        $dto = BroadcastingAssembler::attributesToSendTextDTO((array)$request->getParsedBody());
        return $this->wrapper()->setData(
            $this->application->sendTextProvider(
                (int)$this->parsingToken->getOfficialAccountId(),
                $dto
            )
        )->response();
    }

    /**
     * 已发送的消息列表
     *
     * @RequestMapping(route="broadcasting/fans-group", method={ RequestMethod::GET })
     * @param Request $request
     *
     * @return Response|null
     */
    public function actionFansGroup(Request $request): ?Response
    {
        $dto = BroadcastingAssembler::attributesToFansGroupDTO($request->getQueryParams());
        return $this->wrapper()->setData(
            $this->application->fansGroupProvider(
                (int)$this->parsingToken->getOfficialAccountId(),
                $dto
            )
        )->response();
    }
}
