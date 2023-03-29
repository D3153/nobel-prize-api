<?php

namespace Vanier\Api\Controllers;

use Slim\Psr7\Request;
use Slim\Psr7\Response;
use Vanier\Api\Controllers\BaseController;
use Vanier\Api\Helpers\Input;
use Vanier\Api\Models\PeopleModel;

class PeopleController extends BaseController
{
    private $people_model = null;

    public function __construct()
    {
        $this->people_model = new PeopleModel();
    }

    public function handleGetAllPeople(Request $request, Response $response, array $uri_args)
    {
        $data = $this->isValidItemId($request, $response, $uri_args, 'people_id', $this->people_model, 'people');

        return $this->prepareOkResponse($response, $data, 200);
    }
    
}
