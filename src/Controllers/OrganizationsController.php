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

        $response_msg =  $this->arrayMessage(200, 'Ok', 'Organizations Fetched!');
        $this->logMessage("info", $response_msg);
        return $this->prepareOkResponse($response, $data, 200);
    }

    public function handleCreateOrganizations(Request $request, Response $response)
    {
        $data = $request->getParsedBody();
        $format = array(
            "laureateid" => 1,
            "addressid" => 1,
            "orgname" => "notfakeorg",
            "phonenumber" => "123456789",
            "email" => "notfakeemail@realemail.com"
        );
        if ($data) {
            // check if its an array 
            if (is_array($data) == true) {
                $validation = new ValidationHelper;
                foreach ($data as $key => $org) {
                    // check if valid params
                    $is_valid = $validation->isValidOrg($org);
                    if ($is_valid !== true) {
                        $response_msg = $this->arrayMessage(400, 'Missing Data!', 'Missing Parameter');
                        $this->logMessage("error", $response_msg);
                    } else {
                        $response_msg =  $this->arrayMessage(200, 'Ok', 'Organization Added!');
                        $this->logMessage("info", $response_msg);
                        $this->organizations_model->addOrg($org);
                    }
                }
            }
        } else {
            // $message = 'Please provide an Array. Example:"[{"laureateid": 1, "addressid": 1,"orgname": "notfakeorg" ,"phonenumber": "123456789", "email": "notfakeemail@realemail.com"}]';
            // $response_msg =  $this->arrayMessage(403, 'Invalid Format', $message);
            $message = 'Please provide an Array.';
            $response_msg =  $this->arrayMessage(403, 'Invalid Format', $message);
            $this->logMessage("error", $response_msg);
            $response_msg["Example"] = $format;
        }
        return $this->prepareOkResponse($response, $response_msg, 200);
    }
    public function handleUpdateOrganization(Request $request, Response $response)
    {
        $data = $request->getParsedBody();
        $format = array(
            "organizationid" => 1,
            "laureateid" => 1,
            "addressid" => 1,
            "orgname" => "notfakeorg",
            "phonenumber" => "123456789",
            "email" => "notfakeemail@realemail.com"
        );
        //  --Validation
        //  check if body is empty
        if ($data) {
            // check if its an array 
            if (is_array($data) == true) {
                $validation = new ValidationHelper;
                foreach ($data as $key => $org) {
                    $org_id = $org['orgid'];
                    unset($org['orgid']);
                    // check if valid params
                    $is_valid = $validation->isValidPubUpdate($org);
                    if ($is_valid !== true) {
                        $response_msg = $this->arrayMessage(400, 'Missing Data!', 'Missing Parameter');
                        $this->logMessage("error", $response_msg);
                    } else {
                        $response_msg =  $this->arrayMessage(200, 'Ok', 'Organization Updated!');
                        $this->logMessage("info", $response_msg);
                        $this->organizations_model->putOrg($org, $org_id);
                    }
                }
            }
        }
    }

    public function handleDeleteOrganization(Request $request, Response $response)
    {
        $data = $request->getParsedBody();

        if ($data) {
            if (is_array($data) == true) {
                $count = count($data);
                //-- Validate the array 
                for ($i = 0; $i < $count; $i++) {
                    $org_id = $data[$i];
                    if (is_int($org_id)) {
                        $is_valid = $this->organizations_model->getByOrgId($org_id);
                        if ($is_valid != null) {
                            //-- Ask the model to delete a film specified by its id
                            $this->organizations_model->deleteOrgById($org_id);
                            $response_msg =  $this->arrayMessage(200, 'Ok', 'Publication Deleted!');
                            $this->logMessage("info", $response_msg);
                        } else {
                            $response_msg =  $this->arrayMessage(410, 'Gone', 'Publication does not exist');
                            $this->logMessage("error", $response_msg);
                        }
                    } else {
                        $response_msg =  $this->arrayMessage(403, 'Invalid Format', 'Int is required');
                        $this->logMessage("error", $response_msg);
                    }
                }
            } else {
                $response_msg =  $this->arrayMessage(403, 'Invalid Format', 'Array is required');
                $this->logMessage("error", $response_msg);
            }
        } else {
            $response_msg =  $this->arrayMessage(403, 'Invalid Format', 'Array is required');
            $this->logMessage("error", $response_msg);
        }
        return $this->prepareOkResponse($response, $response_msg, 200);
    }

}
