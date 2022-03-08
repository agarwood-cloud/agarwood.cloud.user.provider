<?php declare(strict_types=1);
/**
 * This file is part of Agarwood Cloud.
 *
 * @link     https://www.agarwood-cloud.com
 * @document https://www.agarwood-cloud.com/docs
 * @contact  676786620@qq.com
 * @author   agarwood
 */

namespace App\OfficialAccount\Interfaces\Facade;

use App\OfficialAccount\Application\OAuthApplication;
use App\OfficialAccount\Interfaces\Assembler\OAuthAssembler;
use App\OfficialAccount\Interfaces\DTO\Oauth\FrontEndJWTDTO;
use App\OfficialAccount\Interfaces\DTO\Oauth\WeChatDTO;
use Agarwood\Core\Support\Impl\AbstractBaseController;
use Swoft\Http\Message\Request;
use Swoft\Http\Message\Response;
use Swoft\Http\Server\Annotation\Mapping\Controller;
use Swoft\Http\Server\Annotation\Mapping\RequestMapping;
use Swoft\Http\Server\Annotation\Mapping\RequestMethod;
use Swoft\Validator\Annotation\Mapping\Validate;
use Swoft\Validator\Annotation\Mapping\ValidateType;

/**
 * @Controller(prefix="/official-account/oauth")
 */
class OAuthController extends AbstractBaseController
{
    /**
     * @\Swoft\Bean\Annotation\Mapping\Inject()
     *
     * @var \App\OfficialAccount\Application\OAuthApplication
     */
    public OAuthApplication $application;

    /**
     * 微信授权回调接口
     *
     * @RequestMapping(route="official-account", method={RequestMethod::GET,RequestMethod::POST})
     * @Validate(validator=WeChatDTO::class, type=ValidateType::GET)
     *
     * @param Request  $request
     * @param Response $response
     *
     * @return Response|null
     */
    public function actionOfficialAccount(Request $request, Response $response): ?Response
    {
        // 接收回调过来的参数
        $DTO = OAuthAssembler::attributesToOfficialAccountDTO($request->getQueryParams());

        // 授权成功，并获取用户信息
        $userOfficialAccount = $this->application->OfficialAccountOauthProvider($DTO);

        //记录用户信息
        $user = $this->application->userProvider($userOfficialAccount, $DTO);

        // 生成 jwt-token 值
        // 构造jwt的 token 值
        $jwtToken = $this->application->jwtTokenProvider(
            $userOfficialAccount,
            $DTO->getToken(),
            $user['platform_id'] ?? $DTO->getplatformId(),
            $user['customer_id'] ?? $DTO->getCustomerId(),
            $user['customer'] ?? $DTO->getCustomer()
        );

        // 获取跳转的目标域名，这里跳回前端页面
        $target = $this->application->targetUrlProvider($DTO->getState(), $jwtToken);
        return $response->redirect($target);
    }

    /**
     * 获取微信授权的地址
     *
     * @RequestMapping(route="official-account-url", method={ RequestMethod::GET })
     * @Validate(validator=FrontEndJWTDTO::class, type=ValidateType::GET, fields={"token"})
     *
     * @param Request $request
     *
     * @return Response|null
     */
    public function actionOfficialAccountUrl(Request $request): ?Response
    {
        $dto = OAuthAssembler::attributesToFontEndJWTDTO($request->getQueryParams());

        // 生成 跳转的链接
        return $this->wrapper()->setData(
            $this->application->OfficialAccountUrlProvider($dto)
        )->response();
    }
}
