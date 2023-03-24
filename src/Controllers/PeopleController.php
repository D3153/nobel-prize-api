<?php

namespace Vanier\Api\Controllers;

use Slim\Psr7\Request;
use Slim\Psr7\Response;
use Vanier\Api\Controllers\BaseController;
use Vanier\Api\Models\PeopleModel;

class PeopleController extends BaseController
{
    private $people_model = null;

    public function __construct()
    {
        $this->people_model = new PeopleModel();
    }

    public function handleGetAllPeople(Request $request, Response $response)
    {
        $filters = $request->getQueryParams();

        // $data = $this->people_model->getAll($filters);
        $data = $this->people_model->getAll();

        return $this->prepareOkResponse($response, $data, 201);
    }
    
}
