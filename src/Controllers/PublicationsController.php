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
        $data = $this->isValidItemId($request, $response, $uri_args, 'publication_id', $this->publication_model, 'publication');

        return $this->prepareOkResponse($response, $data, 200);
    }
}
