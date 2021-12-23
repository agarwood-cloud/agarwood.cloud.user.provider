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

use App\OfficialAccount\Application\CallbackApplication;
use App\OfficialAccount\Interfaces\DTO\User\CreateDTO;
use Swoft\Http\Message\ContentType;
use Swoft\Http\Message\Response;
use Swoft\Http\Server\Annotation\Mapping\Controller;
use Swoft\Http\Server\Annotation\Mapping\RequestMapping;
use Swoft\Http\Server\Annotation\Mapping\RequestMethod;
use Swoft\Validator\Annotation\Mapping\Validate;
use Swoft\Validator\Annotation\Mapping\ValidateType;

/**
 * 微信回调控制器
 *
 *
 * @Controller(prefix="/official-account/callback")
 */
class CallbackController
{
    /**
     * @\Swoft\Bean\Annotation\Mapping\Inject()
     *
     * @var \App\OfficialAccount\Application\CallbackApplication
     */
    public CallbackApplication $application;

    /**
     * 微信的回调地址:
     *      i.e:  http://www.xxx.com/user-center/official-account/token/eb6c374c1e91e.html
     *
     * @RequestMapping(
     *     route="official-account/token/{officialAccountsId}.html",
     *     method={ RequestMethod::POST }
     * )
     *
     * @Validate(validator=CreateDTO::class, type=ValidateType::BODY)
     * @param int|string $officialAccountsId
     * @param Response   $response
     *
     * @return Response|null
     */
    public function actionOfficialAccount(int|string $officialAccountsId, Response $response): ?Response
    {
        /*
        |-----------------------------------------------------------------
        | 1. default 和 event事件可以向下传播，其它事件处理完成则返回
        | 2. default 把用户的信息缓存到redis，避免每次都读取数据库的值
        | 3. event 确保把用户的信息都写到mysql
        |-----------------------------------------------------------------
        */
        //返回类型，根据请求的类型返回
        $response->withContentType(ContentType::XML);
        return $response->withContent(
            $this->application->officialAccountProvider($officialAccountsId)->getContent()
        );
    }
}
