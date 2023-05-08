<?php

namespace Vanier\Api\Middlewares;

use DateTimeZone;
use Fig\Http\Message\StatusCodeInterface as HttpCodes;
use InvalidArgumentException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Vanier\Api\Exceptions\HttpNotAcceptableException;
use Monolog\Level;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Monolog\Handler\FirePHPHandler;
use Vanier\Api\Helpers\AppLogHelper;
use Vanier\Api\Models\WSLoggingModel;

class DBLoginMiddleware implements MiddlewareInterface
{
    /**
     * __construct
     */
    public function __construct()
    {

    }

    /**
     * process
     * gets the login information to write to the database
     * @param Request $request
     * @param RequestHandler $handler
     * @return ResponseInterface
     */
    public function process(Request $request, RequestHandler $handler): ResponseInterface
    {
        //-- 1) Routes to ignore. 
        $uri = $request->getUri();
        // We need to ignore the routes that enables client applications
        // to create an account and request a JWT token.
        if (strpos($uri, 'account') !== false || strpos($uri, 'token') !== false) {
            return $handler->handle($request);
        }
        // Logging database
        $token_payload = $request->getAttribute(APP_JWT_TOKEN_KEY);
        // var_dump($token_payload);exit;
        $logging_model = new WSLoggingModel();
        $request_info = $_SERVER["REMOTE_ADDR"]. ' ' .$request->getUri()->getPath();
        $logging_model->logUserAction($token_payload, $request_info);
        
        // DO NOT TOUCH THIS 
        // echo "Hello from the Middleware";exit;
        $response = $handler->handle($request);

        return $response;
    }
}
