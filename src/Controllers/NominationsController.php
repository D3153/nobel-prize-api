<?php

namespace Vanier\Api\Controllers;

use Slim\Psr7\Request;
use Slim\Psr7\Response;
use Vanier\Api\Models\NominationsModel;

class NominationsController extends BaseController
{
    private $nominations_model = null;
    public function __construct()
    {
        $this->nominations_model = new NominationsModel();
    }

    public function handleGetAllNominations(Request $request, Response $response)
    {
        $filters = $request->getQueryParams();

        // $data = $this->people_model->getAll($filters);
        $data = $this->nominations_model->getAll();

        return $this->prepareOkResponse($response, $data, 201);
    }
}
