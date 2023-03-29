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
        $data = $this->isValidItemId($request, $response, $uri_args, 'nomination_id', $this->nominations_model, 'nomination');

        return $this->prepareOkResponse($response, $data, 200);
    }
}
