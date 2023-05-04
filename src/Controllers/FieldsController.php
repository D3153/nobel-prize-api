<?php

namespace Vanier\Api\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Vanier\Api\Helpers\ValidationHelper;
use Vanier\Api\Helpers\Validator;
use Vanier\Api\Models\FieldsModel;

class FieldsController extends BaseController
{
    private $fields_model = null;

    public function __construct()
    {
        $this->fields_model = new FieldsModel();
    }

    public function handleGetAllFields(Request $request, Response $response, array $uri_args)
    {

        $data = $this->isValidItemId($request, $response, $uri_args, 'field_id', $this->fields_model, 'field');

        $response_msg =  $this->arrayMessage(200, 'Ok', 'Fields Received!');
        $this->logMessage("info", $response_msg);
        return $this->prepareOkResponse($response, $data, 200);
    }

    public function handleUpdateField(Request $request, Response $response)
    {
        $data = $request->getParsedBody();
        $format = array(
            "fieldid"=> 5,
            "field_name"=> 'Name',
            "field_desc"=> 'Desc'
            );
        //  --Validation
        //  check if body is empty
        if ($data) {
            // check if its an array 
            if (is_array($data) == true) {
                $validation = new ValidationHelper;
                foreach ($data as $key => $field) {
                    $field_id = $field['fieldid'];
                    // unset($people['laureateid']);
                    // check if valid params
                    $is_valid = $validation->isValidFieldUpdate($field);
                    if ($is_valid !== true) {
                        $response_msg = $this->arrayMessage(400, 'Missing Data!', 'Missing Parameter');
                        $this->logMessage("error", $response_msg);
                    } else {
                        unset($field['fieldid']);
                        $response_msg =  $this->arrayMessage(200, 'Ok', 'Field Updated!');
                        $this->logMessage("info", $response_msg);
                        // echo $pub_id;
                        // var_dump($pub); exit;

                        $this->fields_model->updateField($field, $field_id);
                    }
                    // unset($people['laureateid']);
                }
            }
        } else {
            $message = 'Please provide an Array.';
            $response_msg =  $this->arrayMessage(403, 'Invalid Format', $message);
            $this->logMessage("error", $response_msg);
            $response_msg["Example"] = $format;
        }
        return $this->prepareOkResponse($response, $response_msg, 200);
    }
}
