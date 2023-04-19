<?php

namespace Vanier\Api\Middlewares;

use Fig\Http\Message\StatusCodeInterface as HttpCodes;
use InvalidArgumentException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Vanier\Api\Exceptions\HttpNotAcceptableException;

class ContentNegotiationMiddleware implements MiddlewareInterface
{
    private $supported_types = [APP_MEDIA_TYPE_JSON];

    public function __construct(array $options = [])
    {
        $this->supported_types = array_merge($options, $this->supported_types);
    }

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
            // throw new HttpNotAcceptableException($request);
            $response = new \Slim\Psr7\Response();
            $error_data = [
                "code" => HttpCodes::STATUS_NOT_ACCEPTABLE, 
                "message" => "Not Acceptable", 
                "description" => "The server cannot produce a response matching the list of acceptable values defined in the request`s proactive content negotiation headers, and that the server is unwilling to supply a default representation."
            ];
            $response->getBody()->write(json_encode($error_data));
            // For a single Content-type
            // return $response->withStatus(HttpCodes::STATUS_NOT_ACCEPTABLE)->withAddedHeader("Content-type", APP_MEDIA_TYPE_JSON);
            // For multiple Content-types
            return $response->withStatus(HttpCodes::STATUS_NOT_ACCEPTABLE)->withAddedHeader("Content-type", $accept);
        }
        // echo "Hello from the Middleware";exit;
        $response = $handler->handle($request);

        return $response;
    }
}
