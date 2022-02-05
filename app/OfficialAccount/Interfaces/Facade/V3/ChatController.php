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
use App\Customer\Interfaces\DTO\Customer\ChatDTO;
use App\Customer\Interfaces\DTO\Customer\ChatRecordDTO;
use App\OfficialAccount\Application\ChatApplication;
use App\OfficialAccount\Interfaces\Assembler\ChatAssembler;
use App\OfficialAccount\Interfaces\DTO\Chat\ImageDTO;
use App\OfficialAccount\Interfaces\DTO\Chat\NewsItemDTO;
use App\OfficialAccount\Interfaces\DTO\Chat\TextDTO;
use App\OfficialAccount\Interfaces\DTO\Chat\VideoDTO;
use App\OfficialAccount\Interfaces\DTO\Chat\VoiceDTO;
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
 * 回复消息到腾讯服务器
 *
 * @Controller(prefix="/official-account/v3")
 * @Middlewares({
 *     @Middleware(OAuthJWTMiddleware::class)
 * })
 */
class ChatController extends AbstractBaseController
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
     * @var \App\OfficialAccount\Application\ChatApplication
     */
    public ChatApplication $application;

    /**
     * 文本消息
     *
     * @RequestMapping(route="chat/text-message", method={RequestMethod::POST})
     * @Validate(validator=TextDTO::class, type=ValidateType::BODY)
     * @param Request $request
     *
     * @return Response|null
     */
    public function actionTextMessage(Request $request): ?Response
    {
        $dto = ChatAssembler::attributesToTextMessageDTO((array)$request->getParsedBody());
        return $this->wrapper()->setData([
            'result' => $this->application->textMessageProvider(
                (int)$this->parsingToken->getOfficialAccountId(),
                $dto
            )
        ])->response();
    }

    /**
     * 图片消息
     *
     * @param Request $request
     *
     * @Validate(validator=ImageDTO::class, type=ValidateType::BODY)
     * @RequestMapping(route="chat/image-message", method={ RequestMethod::POST })
     *
     * @return Response|null
     */
    public function actionImageMessage(Request $request): ?Response
    {
        $DTO = ChatAssembler::attributesToImageMessageDTO((array)$request->getParsedBody());
        return $this->wrapper()->setData([
            'result' => $this->application->ImageMessageProvider(
                (int)$this->parsingToken->getOfficialAccountId(),
                $DTO
            )
        ])->response();
    }

    /**
     * 视频信息
     *
     * @RequestMapping(route="chat/video-message", method={ RequestMethod::POST })
     * @Validate(validator=VideoDTO::class, type=ValidateType::BODY)
     * @param Request $request
     *
     * @return Response|null
     */
    public function actionVideoMessage(Request $request): ?Response
    {
        $DTO = ChatAssembler::attributesToVideoMessageDTO((array)$request->getParsedBody());
        return $this->wrapper()->setData([
            'result' => $this->application->videoMessageProvider(
                (int)$this->parsingToken->getOfficialAccountId(),
                $DTO
            )
        ])->response();
    }

    /**
     * 音频信息
     *
     * @RequestMapping(route="chat/voice-message", method={ RequestMethod::POST })
     * @Validate(validator=VoiceDTO::class, type=ValidateType::BODY)
     * @param Request $request
     *
     * @return Response|null
     */
    public function actionVoiceMessage(Request $request): ?Response
    {
        $DTO = ChatAssembler::attributesToVoiceMessageDTO((array)$request->getParsedBody());
        return $this->wrapper()->setData([
            'result' => $this->application->voiceMessageProvider(
                (int)$this->parsingToken->getOfficialAccountId(),
                $DTO
            )
        ])->response();
    }

    /**
     * 音频信息
     *
     * @RequestMapping(route="chat/news-item-message", method={ RequestMethod::POST })
     * @Validate(validator=NewsItemDTO::class, type=ValidateType::BODY)
     * @param Request $request
     *
     * @return Response|null
     */
    public function actionNewsItemMessage(Request $request): ?Response
    {
        $DTO = ChatAssembler::attributesToNewsItemMessageDTO((array)$request->getParsedBody());
        return $this->wrapper()->setData([
            'result' => $this->application->newsItemMessageProvider(
                (int)$this->parsingToken->getOfficialAccountId(),
                $DTO
            )
        ])->response();
    }

    /**
     * 上传图片
     *
     * @RequestMapping(route="chat/upload-image", method={ RequestMethod::POST })
     * @param Request $request
     *
     * @return Response|null
     */
    public function actionUploadImage(Request $request): ?Response
    {
        return $this->wrapper()->setData(
            $this->application->uploadImageProvider(
                (int)$this->parsingToken->getOfficialAccountId(),
                $request->getUploadedFiles()
            )
        )->response();
    }

    /**
     * 上传视频
     *
     * @RequestMapping(route="chat/upload-video", method={ RequestMethod::POST })
     * @param Request $request
     *
     * @return Response|null
     */
    public function actionUploadVideo(Request $request): ?Response
    {
        return $this->wrapper()->setData(
            $this->application->uploadVideoProvider(
                (int)$this->parsingToken->getOfficialAccountId(),
                $request->getUploadedFiles()
            )
        )->response();
    }

    /**
     * 获取聊天列表
     *
     * @RequestMapping(route="chat/chat-list", method={ RequestMethod::GET })
     * @Validate(validator=ChatDTO::class, type=ValidateType::GET)
     * @Middleware(OAuthJWTMiddleware::class)
     *
     * @param Request $request
     *
     * @return Response|null
     */
    public function actionChatList(Request $request): ?Response
    {
        $dto = ChatAssembler::attributesToChatDTO($request->getQueryParams());
        return $this->wrapper()->setData(
            $this->application->chatListProvider(
                (int)$this->parsingToken->getOfficialAccountId(),
                (int)$this->parsingToken->getCustomerId(),
                $dto
            )
        )->response();
    }

    /**
     * 获取聊天记录
     *
     * @RequestMapping(route="chat/chat-record/{openid}", method={ RequestMethod::GET })
     * @Validate(validator=ChatRecordDTO::class, type=ValidateType::GET)
     * @Middleware(OAuthJWTMiddleware::class)
     *
     * @param string  $openid
     * @param Request $request
     *
     * @return Response|null
     */
    public function actionChatRecord(string $openid, Request $request): ?Response
    {
        $dto = ChatAssembler::attributesToChatRecordDTO($request->getQueryParams());
        return $this->wrapper()->setData(
            $this->application->chatRecordProvider($openid, (int)$this->parsingToken->getCustomerId(), $dto)
        )->response();
    }
}
