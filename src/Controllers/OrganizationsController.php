<?php

namespace Vanier\Api\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Vanier\Api\Helpers\Validator;
use Vanier\Api\Helpers\ValidationHelper;
use Vanier\api\Helpers\Input;
use Vanier\Api\Models\OrganizationsModel;


/**
 * OrganizationsController
 * Handles all organizations requests
 */
class OrganizationsController extends BaseController
{
    /**
     * organizations_model
     * @var
     */
    private $organizations_model = null;

    /**
     * __construct
     */
    public function __construct()
    {
        $this->organizations_model = new OrganizationsModel();
    }

    /**
     * handleGetAllOrganizations
     * Handles GET requests
     * @param Request $request
     * @param Response $response
     * @param array $uri_args
     * @return Response
     */
    public function handleGetAllOrganizations(Request $request, Response $response, array $uri_args)
    {
        $data = $this->isValidItemId($request, $response, $uri_args, 'organization_id', $this->organizations_model, 'organization');

        $response_msg =  $this->arrayMessage(200, 'Ok', 'Organizations Fetched!');
        $this->logMessage("info", $response_msg);
        return $this->prepareOkResponse($response, $data, 200);
    }

    /**
     * handleCreateOrganizations
     * Handles POST requests
     * @param Request $request
     * @param Response $response
     * @return Response
     */
    public function handleCreateOrganizations(Request $request, Response $response)
    {
        $data = $request->getParsedBody();
        // for array format message
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
                    // -- Validation
                    // check if valid params
                    $is_valid = $validation->isValidOrg($org);
                    if ($is_valid !== true) {
                        $response_msg = $this->arrayMessage(400, 'Missing Data!', 'Missing Parameter');
                        $this->logMessage("error", $response_msg);
                    } else {
                        $response_msg =  $this->arrayMessage(200, 'Ok', 'Organization Added!');
                        $this->logMessage("info", $response_msg);
                        $this->organizations_model->createOrg($org);
                    }
                }
            }
        } else {
            $message = 'Please provide an Array.';
            $response_msg =  $this->arrayMessage(403, 'Invalid Format', $message);
            $this->logMessage("error", $response_msg);
            $response_msg["Example"] = $format;
        }
        return $this->prepareOkResponse($response, $response_msg, 200);
    }
    /**
     * handleUpdateOrganization
     * Handles PUT requests
     * @param Request $request
     * @param Response $response
     * @return Response
     */
    public function handleUpdateOrganization(Request $request, Response $response)
    {
        $data = $request->getParsedBody();
        // for array format message
        $format = array(
            "orgid" => 1,
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
                    // check if valid params
                    $is_valid = $validation->isValidOrgUpdate($org);
                    if ($is_valid !== true) {
                        $response_msg = $this->arrayMessage(400, 'Missing Data!', 'Missing Parameter');
                        $this->logMessage("error", $response_msg);
                    } else {
                        unset($org['orgid']);
                        $response_msg =  $this->arrayMessage(200, 'Ok', 'Organization Updated!');
                        $this->logMessage("info", $response_msg);
                        $this->organizations_model->updateOrg($org, $org_id);
                    }
                }
            }
        }
        else
        {
            $message = 'Please provide an Array.';
            $response_msg =  $this->arrayMessage(403, 'Invalid Format', $message);
            $this->logMessage("error", $response_msg);
            $response_msg["Example"] = $format;
        }
        return $this->prepareOkResponse($response, $response_msg, 200);
    }

    /**
     * handleDeleteOrganization
     * Handles DELETE requests
     * @param Request $request
     * @param Response $response
     * @return Response
     */
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
