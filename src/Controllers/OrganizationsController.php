<?php

namespace Vanier\Api\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Vanier\Api\Helpers\Validator;
use Vanier\api\Helpers\Input;
use Vanier\Api\Models\OrganizationsModel;

class OrganizationsController extends BaseController
{
    private $organizations_model = null;

    public function __construct()
    {
        $this->organizations_model = new OrganizationsModel();
    }

    public function handleGetAllOrganizations(Request $request, Response $response, array $uri_args)
    {
        $data = $this->isValidItemId($request, $response, $uri_args, 'organization_id', $this->organizations_model, 'organization');

        return $this->prepareOkResponse($response, $data, 200);
    }
}
