<?php

namespace Vanier\Api\Controllers;
use Slim\Psr7\Request;
use Slim\Psr7\Response;
use Vanier\Api\Helpers\Input;
use Vanier\Api\Models\PublicationsModel;

class PublicationsController extends BaseController
{
    private $publication_model = null;
    public function __construct()
    {
        $this->publication_model = new PublicationsModel();
    }

    public function handleGetAllPublications(Request $request, Response $response, array $uri_args)
    {
        $filters = $request->getQueryParams();

        $id = null;
        if(isset($uri_args['publication_id']) && Input::isInt($uri_args['publication_id']))
        {
            $id = $uri_args['publication_id'];
        }
        elseif(!isset($uri_args['publication_id'])){
            $data = $this->publication_model->getAll();
        }
        elseif(!Input::isInt($uri_args['publication_id']))
        {
            $data = $this->arrayMessage(404, 'The specified publication is was invalid', 'The id must be a positive integer');
            return $this->getErrorResponse($response, $data, 404);
        }

        // $data = $this->people_model->getAll($filters);
        $data = $this->publication_model->getAll($id, $filters);

        return $this->prepareOkResponse($response, $data, 201);
    }
}
