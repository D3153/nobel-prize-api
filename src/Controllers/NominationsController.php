<?php

namespace Vanier\Api\Controllers;

use Slim\Psr7\Request;
use Slim\Psr7\Response;
use Vanier\Api\Helpers\Input;
use Vanier\Api\Models\NominationsModel;

class NominationsController extends BaseController
{
    private $nominations_model = null;
    public function __construct()
    {
        $this->nominations_model = new NominationsModel();
    }

    public function handleGetAllNominations(Request $request, Response $response, array $uri_args)
    {
        $filters = $request->getQueryParams();

        $id = null;
        if(isset($uri_args['nomination_id']) && Input::isInt($uri_args['nomination_id']))
        {
            $id = $uri_args['nomination_id'];
        }
        elseif(!isset($uri_args['nomination_id'])){
            $data = $this->nominations_model->getAll();
        }
        elseif(!Input::isInt($uri_args['nomination_id']))
        {
            $data = $this->arrayMessage(404, 'The specified nomination is invalid', 'The id must be a positive integer');
            return $this->getErrorResponse($response, $data, 404);
        }

        // $data = $this->people_model->getAll($filters);
        $data = $this->nominations_model->getAll($id, $filters);

        return $this->prepareOkResponse($response, $data, 201);
    }
}
