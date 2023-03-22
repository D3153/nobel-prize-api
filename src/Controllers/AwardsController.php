<?php

namespace Vanier\Api\Controllers;
use Slim\Psr7\Request;
use Slim\Psr7\Response;
use Vanier\Api\Models\AwardsModel;

class AwardsController extends BaseController
{
    private $award_model = null;
    public function __construct()
    {
        $this->award_model = new AwardsModel();
    }

    public function handleGetAllAwards(Request $request, Response $response)
    {
        $filters = $request->getQueryParams();

        // $data = $this->people_model->getAll($filters);
        $data = $this->award_model->getAll();

        return $this->prepareOkResponse($response, $data, 201);
    }
}
