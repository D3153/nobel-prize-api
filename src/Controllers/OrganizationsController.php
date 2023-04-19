<?php

namespace Vanier\Api\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Vanier\Api\Helpers\Validator;
use Vanier\Api\Helpers\ValidationHelper;
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

    public function handleCreateOrganizations(Request $request, Response $response)
    {
        $data = $request->getParsedBody();

        if ($data) {
            // check if its an array 
            if (is_array($data) == true) {
                $validation = new ValidationHelper;
                foreach ($data as $key => $org) {
                    // check if valid params
                    $is_valid = $validation->isValidOrg($org);
                    if ($is_valid !== true) {
                        $response_msg = $this->arrayMessage(400, 'Missing Data!', 'Missing Parameter');
                    } else {
                        $response_msg =  $this->arrayMessage(200, 'Ok', 'Organization Added!');
                        $this->organizations_model->addOrg($org);
                    }
                }
            }
        } else {
            $message = 'Please provide an Array. Example:"[{"laureateid": 1, "addressid": 1,"orgname": "notfakeorg" ,"phonenumber": "123456789", "email": "notfakeemail@realemail.com"}]';
            $response_msg =  $this->arrayMessage(403, 'Invalid Format', $message);
        }
        return $this->prepareOkResponse($response, $response_msg, 200);

    }
    public function handleUpdateOrganization(Request $request, Response $response)
    {
        
    }

}
