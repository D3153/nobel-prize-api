<?php

namespace Vanier\Api\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
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


        return $this->prepareOkResponse($response, $data, 200);
    }
}
