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
use App\OfficialAccount\Application\AutoReplyApplication;
use App\OfficialAccount\Interfaces\Assembler\AutoReplyAssembler;
use App\OfficialAccount\Interfaces\DTO\AutoReply\CreateDTO;
use App\OfficialAccount\Interfaces\DTO\AutoReply\IndexDTO;
use App\OfficialAccount\Interfaces\DTO\AutoReply\SaveDTO;
use App\OfficialAccount\Interfaces\DTO\AutoReply\UpdateDTO;
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
 * 自动回复
 *
 * @Controller(prefix="/official-account/v3")
 * @Middlewares({
 *     @Middleware(OAuthJWTMiddleware::class)
 * })
 */
class AutoReplyController extends AbstractBaseController
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
     * @var \App\OfficialAccount\Application\AutoReplyApplication
     */
    public AutoReplyApplication $application;

    /**
     * 列表
     *
     * @RequestMapping(route="auto-reply", method={ RequestMethod::GET })
     * @Validate(validator=IndexDTO::class, type=ValidateType::GET)
     * @param Request $request
     *
     * @return Response|null
     */
    public function actionIndex(Request $request): ?Response
    {
        $dto = AutoReplyAssembler::attributesToIndexDTO($request->getQueryParams());
        return $this->wrapper()->setData(
            $this->application->indexProvider(
                (int)$this->parsingToken->getOfficialAccountId(),
                (int)$this->parsingToken->getCustomerId(),
                $dto
            )
        )->response();
    }

    /**
     * 创建
     *
     * @param Request  $request
     * @param Response $response
     *
     * @RequestMapping(route="auto-reply", method={ RequestMethod::POST })
     * @Validate(validator=CreateDTO::class, type=ValidateType::BODY)
     *
     * @return Response|null
     */
    public function actionCreate(Request $request, Response $response): ?Response
    {
        $DTO = AutoReplyAssembler::attributesToCreateDTO((array)$request->getParsedBody());
        return $this->wrapper()->setData(
            $this->application->createProvider(
                (int)$this->parsingToken->getOfficialAccountId(),
                (int)$this->parsingToken->getCustomerId(),
                $DTO
            )
        )->response($response->withStatus(201));
    }

    /**
     * 新建或者更新 自动回复
     *
     * @param Request  $request
     * @param Response $response
     *
     * @RequestMapping(route="auto-reply/save", method={ RequestMethod::POST })
     * @Validate(validator=SaveDTO::class, type=ValidateType::BODY)
     *
     * @return Response|null
     */
    public function actionSave(Request $request, Response $response): ?Response
    {
        $DTO = AutoReplyAssembler::attributesToSaveDTO((array)$request->getParsedBody());
        return $this->wrapper()->setData(
            $this->application->saveProvider(
                (int)$this->parsingToken->getOfficialAccountId(),
                (int)$this->parsingToken->getCustomerId(),
                $DTO
            )
        )->response($response->withStatus(201));
    }

    /**
     * 更新
     *
     * @param Request $request
     * @param string  $id
     *
     * @Validate(validator=UpdateDTO::class, type=ValidateType::BODY)
     * @RequestMapping(route="auto-reply/{id}", method={ RequestMethod::PUT, RequestMethod::PATCH })
     *
     * @return Response|null
     */
    public function actionUpdate(Request $request, string $id): ?Response
    {
        $DTO = AutoReplyAssembler::attributesToUpdateDTO((array)$request->getParsedBody());
        return $this->wrapper()->setData(
            $this->application->updateProvider($id, $DTO)
        )->response();
    }

    /**
     * 删除
     *
     * @RequestMapping(route="auto-reply/{ids}", method={ RequestMethod::DELETE })
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
