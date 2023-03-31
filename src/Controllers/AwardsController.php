<?php

namespace Vanier\Api\Controllers;
use Slim\Psr7\Request;
use Slim\Psr7\Response;
use Vanier\Api\Helpers\Input;
use Vanier\Api\Models\AwardsModel;

class AwardsController extends BaseController
{
    private $award_model = null;
    public function __construct()
    {
        $this->award_model = new AwardsModel();
    }

    public function handleGetAllAwards(Request $request, Response $response, array $uri_args)
    {
        $data = $this->isValidItemId($request, $response, $uri_args, 'award_id', $this->award_model, 'award');

        return $this->prepareOkResponse($response, $data, 200);
    }
}
