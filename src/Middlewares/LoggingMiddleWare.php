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

class LoggingMiddleWare implements MiddlewareInterface
{
    // private $supported_types = [APP_MEDIA_TYPE_JSON];

    public function __construct()
    {
        // $this->supported_types = array_merge($options, $this->supported_types);
    }

    public function process(Request $request, RequestHandler $handler): ResponseInterface
    {
        $app_logger = new AppLogHelper();
        $params = $request->getQueryParams(); 
        // var_dump($params);exit;       
        $app_logger->getAppLogger()->debug("Debug Access: " . $request->getMethod() . ' ' . $request->getUri()->getPath(), $params);
        
        //echo "oi"; exit;
        // DO NOT TOUCH THIS 
        // echo "Hello from the Middleware";exit;
        $response = $handler->handle($request);

        return $response;
    }
}
