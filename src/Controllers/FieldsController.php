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

    public function handleGetAllFields(Request $request, Response $response)
    {
        $filters = $request->getQueryParams();


        $data = $this->fields_model->getAll($filters);

        return $this->prepareOkResponse($response, $data, 201);
    }
}
