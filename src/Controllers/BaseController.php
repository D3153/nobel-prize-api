<?php

namespace Vanier\Api\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class BaseController
{
    protected function prepareOkResponse(Response $response, array $data, int $status_code = 200)
    {
        // var_dump($data);
        $json_data = json_encode($data);
        //-- Write data into the response's body.        
        $response->getBody()->write($json_data);
        return $response->withStatus($status_code)->withAddedHeader(HEADERS_CONTENT_TYPE, APP_MEDIA_TYPE_JSON);
    }

    protected function getErrorResponse(Response $response, array $data, int $status_code = 404)
    {
        // var_dump($data);
        $json_data = json_encode($data);
        //-- Write data into the response's body.        
        $response->getBody()->write($json_data);
        return $response->withStatus($status_code)->withAddedHeader(HEADERS_CONTENT_TYPE, APP_MEDIA_TYPE_JSON);
    }

    protected function arrayMessage(int $code, string $message, string $description)
    {
        $data = array(
            'code' => $code,
            'message' => $message,
            'description' => $description
        );
        return $data;
    }
}
