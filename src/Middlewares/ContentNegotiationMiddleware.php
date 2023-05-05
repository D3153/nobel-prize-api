<?php

namespace Vanier\Api\Middlewares;

use Fig\Http\Message\StatusCodeInterface as HttpCodes;
use InvalidArgumentException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Vanier\Api\Exceptions\HttpNotAcceptableException;

/**
 * ContentNegotiationMiddleware
 */
class ContentNegotiationMiddleware extends HttpNotAcceptableException implements MiddlewareInterface
{
    /**
     * supported_types
     * @var array
     */
    private $supported_types = [APP_MEDIA_TYPE_JSON];

    /**
     * __construct
     * @param array $options
     */
    public function __construct(array $options = [])
    {
        $this->supported_types = array_merge($options, $this->supported_types);
    }

    /**
     * process
     * checks header for acceptable type
     * @param Request $request
     * @param RequestHandler $handler
     * @return ResponseInterface
     */
    public function process(Request $request, RequestHandler $handler): ResponseInterface
    {
        //--Step 1) Inspect the header section
        //--1.a) Get the accept header
        //$accept = $request->getHeader("Accept"); // Returns an array
        $accept = $request->getHeaderLine("Accept"); // Returns a string
        $str_supported_types = implode("|", $this->supported_types);
        //--Step 2) Compare the requested resource representation format
        if (!str_contains($str_supported_types, $accept)) {
            //-- Refuse processing the request. Notify the client application: Raise an exception
            $response = new \Slim\Psr7\Response();
            $error_data = [
                "code" => $this->code,
                "message" => $this->message,
                "description" => $this->description
            ];
            $response->getBody()->write(json_encode($error_data));
            // For a single Content-type
            // return $response->withStatus(HttpCodes::STATUS_NOT_ACCEPTABLE)->withAddedHeader("Content-type", APP_MEDIA_TYPE_JSON);
            // For multiple Content-types
            return $response->withStatus(HttpCodes::STATUS_NOT_ACCEPTABLE)->withAddedHeader("Content-type", $accept);
        }
        $response = $handler->handle($request);

        return $response;
    }
}
