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
use App\Customer\Application\CustomerApplication;
use App\Customer\Interfaces\Assembler\CustomerAssembler;
use App\Customer\Interfaces\DTO\Customer\ChangeStatusDTO;
use App\Customer\Interfaces\DTO\Customer\ChatRecordDTO;
use App\Customer\Interfaces\DTO\Customer\CreateDTO;
use App\Customer\Interfaces\DTO\Customer\IndexDTO;
use App\Customer\Interfaces\DTO\Customer\UpdateDTO;
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
 *     @Middleware(OAuthJWTMiddleware::class),
 * })
 */
class CustomerController extends AbstractBaseController
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
     * @var \App\Customer\Application\CustomerApplication
     */
    public CustomerApplication $application;

    /**
     * @\Swoft\Bean\Annotation\Mapping\Inject()
     *
     * @var \App\Support\OfficialAccountQueryParams
     */
    public OfficialAccountQueryParams $officialAccountQueryParams;

    /**
     * Customer service list data.
     *
     * @RequestMapping(route="customer", method={RequestMethod::GET})
     * @Validate(validator=IndexDTO::class, type=ValidateType::GET)
     * @param Request $request
     *
     * @return Response|null
     */
    public function actionIndex(Request $request): ?Response
    {
        $dto = CustomerAssembler::attributesToIndexDTO($request->getQueryParams());
        return $this->wrapper()->setData(
            $this->application->indexProvider(
                (int)$this->officialAccountQueryParams->getOfficialAccountId(),
                $dto
            )
        )->response();
    }

    /**
     * Create customer service.
     *
     * @param Request  $request
     * @param Response $response
     *
     * @RequestMapping(route="customer", method={ RequestMethod::POST })
     * @Validate(validator=CreateDTO::class, type=ValidateType::BODY)
     *
     * @return Response|null
     */
    public function actionCreate(Request $request, Response $response): ?Response
    {
        $dto = CustomerAssembler::attributesToCreateDTO((array)$request->getParsedBody());
        return $this->wrapper()->setData(
            $this->application->createProvider(
                (int)$this->officialAccountQueryParams->getOfficialAccountId(),
                $dto
            )
        )->response($response->withStatus(201));
    }

    /**
     * Update customer service.
     *
     * @param Request $request
     * @param int     $id
     *
     * @return Response|null
     * @Validate(validator=UpdateDTO::class, type=ValidateType::BODY)
     * @RequestMapping(route="customer/{id}", method={RequestMethod::PUT, RequestMethod::PATCH})
     */
    public function actionUpdate(Request $request, int $id): ?Response
    {
        $dto = CustomerAssembler::attributesToUpdateDTO((array)$request->getParsedBody());
        return $this->wrapper()->setData(
            $this->application->updateProvider($id, $dto)
        )->response();
    }

    /**
     * Delete customer service.
     *
     * @RequestMapping(route="customer/{ids}", method={ RequestMethod::DELETE })
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
     * View customer service.
     *
     * @RequestMapping(route="customer/{id}", method={ RequestMethod::GET })
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

    /**
     * Generate a QR code corresponding to the customer,
     * which can be directly assigned to the customer service after scanning the code
     *
     * @RequestMapping(route="customer-scan-subscribe", method={ RequestMethod::GET })
     * @param Request $request
     *
     * @return Response|null
     */
    public function actionScanSubscribe(Request $request): ?Response
    {
        return $this->wrapper()->setData(
            $this->application->scanSubscribeProvider(
                (int)$this->officialAccountQueryParams->getOfficialAccountId(),
                (int)$this->parsingToken->getCustomerId(),
            )
        )->response();
    }

    /**
     * Update customer service status.
     *
     * @param Request $request
     * @param int     $id
     *
     * @Validate(validator=ChangeStatusDTO::class, type=ValidateType::BODY)
     * @RequestMapping(route="customer/change-status/{id}", method={ RequestMethod::PUT, RequestMethod::PATCH })
     *
     * @return Response|null
     */
    public function actionChangeStatus(Request $request, int $id): ?Response
    {
        $dto = CustomerAssembler::attributesToChangeStatusDTO((array)$request->getParsedBody());
        return $this->wrapper()->setData(
            $this->application->changeStatusProvider($id, $dto)
        )->response();
    }

    /**
     * Clear fans queue
     *
     * @RequestMapping(route="customer/obtain-offline/{ids}", method={RequestMethod::DELETE })
     *
     * @param string   $ids
     * @param Response $response
     *
     * @return Response|null
     */
    public function actionObtainOffline(string $ids, Response $response): ?Response
    {
        return $this->wrapper()->setData(
            $this->application->obtainOfflineProvider(
                (int)$this->officialAccountQueryParams->getOfficialAccountId(),
                $ids
            )
        )->response($response->withStatus(204));
    }

    /**
     * Get Chat Record
     *
     * @RequestMapping(route="customer/chat-record", method={ RequestMethod::GET })
     * @Validate(validator=ChatRecordDTO::class, type=ValidateType::GET)
     *
     * @param Request $request
     *
     * @return Response|null
     */
    public function actionChatRecord(Request $request): ?Response
    {
        $dto = CustomerAssembler::attributesToChatRecordDTO($request->getQueryParams());
        return $this->wrapper()->setData(
            $this->application->chatRecordProvider(
                (int)$this->parsingToken->getCustomerId(),
                $dto
            )
        )->response();
    }

    /**
     * Clear all queue for customer service
     *
     * @RequestMapping(route="customer/obtain-fans-offline", method={ RequestMethod::POST })
     *
     *
     * @return Response|null
     */
    public function actionObtainFansOffline(): ?Response
    {
        return $this->wrapper()->setData(
            $this->application->obtainFansOfflineProvider(
                (int)$this->officialAccountQueryParams->getOfficialAccountId()
            )
        )->response();
    }
}
