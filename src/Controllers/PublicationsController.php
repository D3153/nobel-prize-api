<?php

namespace Vanier\Api\Controllers;
use Slim\Psr7\Request;
use Slim\Psr7\Response;
use Vanier\Api\Models\PublicationsModel;

class PublicationsController extends BaseController
{
    private $publication_model = null;
    public function __construct()
    {
        $this->publication_model = new PublicationsModel();
    }

    public function handleGetAllPublications(Request $request, Response $response)
    {
        $filters = $request->getQueryParams();

        // $data = $this->people_model->getAll($filters);
        $data = $this->publication_model->getAll();

        return $this->prepareOkResponse($response, $data, 201);
    }
}
