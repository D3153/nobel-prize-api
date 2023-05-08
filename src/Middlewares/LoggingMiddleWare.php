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

/**
 * LoggingMiddleWare
 * Handles logging for all requests
 */
class LoggingMiddleWare implements MiddlewareInterface
{
    /**
     * __construct
     */
    public function __construct()
    {

    }

    /**
     * process
     * gets the logging message from URI and writes in the file
     * @param Request $request
     * @param RequestHandler $handler
     * @return ResponseInterface
     */
    public function process(Request $request, RequestHandler $handler): ResponseInterface
    {
        // echo 'CRAAAAAIG';exit;

        $token_payload = $request->getAttribute(APP_JWT_TOKEN_KEY);
        // echo 'CRAAAAAIG';exit;
        // var_dump($token_payload);exit;
        $app_logger = new AppLogHelper();
        $params = $request->getQueryParams();

        $ip_address = $_SERVER["REMOTE_ADDR"];
        $app_logger->getAppLogger()->info("Debug Access: IP: ".$ip_address.' '.$request->getMethod().
                      ' '.$request->getUri()->getPath(), $params);
        
        // Logging database
        // $token_payload = $request->getAttribute(APP_JWT_TOKEN_KEY);
        // $logging_model = new WSLoggingModel();
        // $request_info = $_SERVER["REMOTE_ADDR"]. ' ' .$request->getUri()->getPath();
        // $logging_model->logUserAction($token_payload, $request_info);
        
        // DO NOT TOUCH THIS 
        // echo "Hello from the Middleware";exit;
        $response = $handler->handle($request);

        return $response;
    }
}
