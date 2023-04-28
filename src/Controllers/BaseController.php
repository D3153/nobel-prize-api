<?php

namespace Vanier\Api\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Vanier\Api\Helpers\Input;
use Monolog\Level;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Monolog\Handler\FirePHPHandler;
use Vanier\Api\Helpers\AppLogHelper;

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
    protected function isValidItemId(Request $request, Response $response, $uri_args, $custom_id, $model, $name)
    {
        $filters = $request->getQueryParams();

        $id = null;
        if (isset($uri_args[$custom_id]) && Input::isInt($uri_args[$custom_id])) {
            $id = $uri_args[$custom_id];
            $data = $model->getAll($id, $filters);
        } elseif (!isset($uri_args[$custom_id])) {
            // CASE 1): GET ALL items
            $data = $model->getAll($id, $filters);
        } elseif (!Input::isInt($uri_args[$custom_id])) {
            $data = $this->arrayMessage(404, 'The specified ' . $name . ' is invalid', 'The id must be a positive integer');
            // $error = $this->getErrorResponse($response, $data, 404);
            // return $data;
        }

        // $data = $model->getAll($id, $filters);

        return $data;
    }

    protected function checkNotNull(array $values)
    {
        foreach ($values as $key => $value) {
            if ($value !== "") {
                echo "ollo";
                // $response_msg = $this->arrayMessage(400, 'Missing Data!', 'Missing Parameter');
                // $response_msg =  $this->arrayMessage(200, 'Ok', 'Publication Added!');
                return true;
            } else {
                echo "ollo fck u";
                // $response_msg = $this->arrayMessage(400, 'Missing Data!', 'Missing Parameter');
                return false;
            }
        }
    }

    // Logging
    const info = 100;
    public function logMessage(string $status, $message = [])
    {
        $app_logger = new AppLogHelper();
        switch ($status) {
            case 'info':
                $app_logger->getAppLogger()->info("Info successful attempt: " , $message);
                break;
            case 'error':
                $app_logger->getAppLogger()->error("An Error has occurred: " , $message);
                break;
            case 'alert':
                $app_logger->getAppLogger()->alert("Alert log");
                break;
            case 'critical':
                $app_logger->getAppLogger()->critical("Critical log");
                break;
            case 'debug':
                $app_logger->getAppLogger()->debug("Debug log");
                break;
            case 'emergency':
                $app_logger->getAppLogger()->emergency("Emergency log");
                break;
            // case 'close':
            //     $app_logger->getAppLogger()->close("Close log");
            //     break;
            default:
                $app_logger->getAppLogger()->info("HELLO MESSAGE FROM BASE CONTROLLER");
                break;
        }
    }
}
