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

<<<<<<< HEAD
    public function handleGetAllAwards(Request $request, Response $response,  array $uri_args)
=======
    public function handleGetAllAwards(Request $request, Response $response,array $uri_args)
>>>>>>> d45e96367ca1ec1d04b6a05f32dbd6970a7f89db
    {
        $data = $this->isValidItemId($request, $response, $uri_args, 'award_id', $this->award_model, 'award');

<<<<<<< HEAD
        $id = null;
        if(isset($uri_args['award_id']) && Input::isInt($uri_args['award_id']))
        {
            $id = $uri_args['award_id'];
        }
        elseif(!isset($uri_args['award_id'])){
            $data = $this->award_model->getAll();
        }
        elseif(!Input::isInt($uri_args['award_id']))
        {
            $data = $this->arrayMessage(404, 'The specified laureate is invalid', 'The id must be a positive integer');
            return $this->getErrorResponse($response, $data, 404);
        }

        // $data = $this->people_model->getAll($filters);
        $data = $this->award_model->getAll();

        return $this->prepareOkResponse($response, $data, 201);
=======
        return $this->prepareOkResponse($response, $data, 200);
>>>>>>> d45e96367ca1ec1d04b6a05f32dbd6970a7f89db
    }
}
