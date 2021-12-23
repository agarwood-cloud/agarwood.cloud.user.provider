<?php declare(strict_types=1);
/**
 * This file is part of Agarwood Cloud.
 *
 * @link     https://www.agarwood-cloud.com
 * @document https://www.agarwood-cloud.com/docs
 * @contact  676786620@qq.com
 * @author   agarwood
 */

namespace App\Support\Middleware;

use Agarwood\Core\Exception\ForbiddenException;
use App\Support\ParsingToken;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Swoft\Http\Server\Contract\MiddlewareInterface;
use function str_replace;

/**
 * Authorization middleware
 *
 * @\Swoft\Bean\Annotation\Mapping\Bean()
 */
class OAuthJWTMiddleware implements MiddlewareInterface
{
    /**
     * @\Swoft\Bean\Annotation\Mapping\Inject()
     *
     * @var ParsingToken
     */
    public ParsingToken $parsingToken;

    /**
     * Check JWT
     *
     * @param ServerRequestInterface  $request
     * @param RequestHandlerInterface $handler
     *
     * @return ResponseInterface
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        // The request header must contain Authorization: Bearer  + token
        $token = str_replace('Bearer ', '', $request->getHeaderLine('Authorization'));

        if (!$token) {
            throw new ForbiddenException('Authorization: bearer + token is missing from the request header. The request was rejected. Please try again later!');
        }

        $result = $this->parsingToken->validator($token);

        if (!$result) {
            throw new ForbiddenException('Authorization verification failed!');
        }

        return $handler->handle($request);
    }
}
