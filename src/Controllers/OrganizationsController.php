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
        $filters = $request->getQueryParams();

        $id = null;
        if(isset($uri_args['organization_id']) && Input::isInt($uri_args['organization_id'])){
            $id = $uri_args['organization_id'];
        }else{
            $data = $this->arrayMessage(404,'The specified organization is invalid', 'The id must be a positive integer');
            return $this->getErrorResponse($response,$data,404);
        }
        $data = $this->organizations_model->getAll($id);

        return $this->prepareOkResponse($response, $data, 201);
    }
}
