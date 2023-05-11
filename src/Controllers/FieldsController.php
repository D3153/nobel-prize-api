<?php

namespace Vanier\Api\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Vanier\Api\Helpers\ValidationHelper;
use Vanier\Api\Helpers\Validator;
use Vanier\Api\Models\FieldsModel;

/**
 * FieldsController
 * Handles all Fields requests
 */
class FieldsController extends BaseController
{
    /**
     * fields_model
     * @var
     */
    private $fields_model = null;

    /**
     * __construct
     */
    public function __construct()
    {
        $this->fields_model = new FieldsModel();
    }

    /**
     * handleGetAllFields
     * Handles GET requests
     * @param Request $request
     * @param Response $response
     * @param array $uri_args
     * @return Response
     */
    public function handleGetAllFields(Request $request, Response $response, array $uri_args)
    {

        $data = $this->isValidItemId($request, $response, $uri_args, 'field_id', $this->fields_model, 'field');

        if (empty($data) == true) {
            $response_msg =  $this->arrayMessage(404, 'Not Found', 'No Fields Found!');
            $this->logMessage("info", $response_msg);
            return $this->prepareOkResponse($response, $response_msg, 404);
        } else {
            $response_msg =  $this->arrayMessage(200, 'Ok', 'Fields Received!');
            $this->logMessage("info", $response_msg);
            return $this->prepareOkResponse($response, $data, 200);
        }
    }

    /**
     * handleUpdateField
     * Handles PUT requests
     * @param Request $request
     * @param Response $response
     * @return Response
     */
    public function handleUpdateField(Request $request, Response $response)
    {
        $data = $request->getParsedBody();
        // for array format message
        $format = array(
            "fieldid" => 5,
            "field_name" => 'Name',
            "field_desc" => 'Desc'
        );
        //  --Validation
        //  check if body is empty
        if ($data) {
            // check if its an array 
            if (is_array($data) == true) {
                $validation = new ValidationHelper;
                foreach ($data as $key => $field) {
                    $field_id = $field['fieldid'];
                    // check if valid params
                    $is_valid = $validation->isValidFieldUpdate($field);
                    if ($is_valid !== true) {
                        $response_msg = $this->arrayMessage(400, 'Missing Data!', 'Missing Parameter');
                        $this->logMessage("error", $response_msg);
                        return $this->prepareOkResponse($response, $response_msg, 400);
                    } else {
                        unset($field['fieldid']);
                        $response_msg =  $this->arrayMessage(200, 'Ok', 'Field Updated!');
                        $this->logMessage("info", $response_msg);

                        $this->fields_model->updateField($field, $field_id);
                    }
                }
            }
        } else {
            $message = 'Please provide an Array.';
            $response_msg =  $this->arrayMessage(403, 'Invalid Format', $message);
            $this->logMessage("error", $response_msg);
            $response_msg["Example"] = $format;
            return $this->prepareOkResponse($response, $response_msg, 403);
        }
        return $this->prepareOkResponse($response, $response_msg, 200);
    }
}
