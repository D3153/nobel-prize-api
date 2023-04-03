<?php

namespace Vanier\Api\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Vanier\Api\Helpers\Input;

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
    protected function isValidItemId(Request $request, Response $response,$uri_args, $custom_id, $model, $name)
    {
        $filters = $request->getQueryParams();

        $id = null;
        if(isset($uri_args[$custom_id]) && Input::isInt($uri_args[$custom_id]))
        {
            $id = $uri_args[$custom_id];
            $data = $model->getAll($id, $filters);
        }
        elseif(!isset($uri_args[$custom_id])){
            // CASE 1): GET ALL items
            //echo "OI gettting all the nominations!";exit;
            $data = $model->getAll($id, $filters);
            // var_dump($data);exit;
        }
        elseif(!Input::isInt($uri_args[$custom_id]))
        {
            $data = $this->arrayMessage(404, 'The specified '. $name .' is invalid', 'The id must be a positive integer');
            // $error = $this->getErrorResponse($response, $data, 404);
            // return $data;
        }
        
        // $data = $model->getAll($id, $filters);
        
        return $data;
    }
}
