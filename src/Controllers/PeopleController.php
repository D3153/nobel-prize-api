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
        $filters = $request->getQueryParams();

        $id = null;
        if(isset($uri_args['laureate_id']) && Input::isInt($uri_args['laureate_id']))
        {
            $id = $uri_args['laureate_id'];
        }
        elseif(!isset($uri_args['laureate_id'])){
            $data = $this->people_model->getAll();
        }
        elseif(!Input::isInt($uri_args['laureate_id']))
        {
            $data = $this->arrayMessage(404, 'The specified laureate is invalid', 'The id must be a positive integer');
            return $this->getErrorResponse($response, $data, 404);
        }

        // $data = $this->people_model->getAll($filters);
        $data = $this->people_model->getAll($id, $filters);

        return $this->prepareOkResponse($response, $data, 201);
    }
    
}
