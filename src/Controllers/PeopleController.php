<?php

namespace Vanier\Api\Controllers;

use Slim\Psr7\Request;
use Slim\Psr7\Response;
use Vanier\Api\Controllers\BaseController;
use Vanier\Api\Helpers\Input;
use Vanier\Api\Helpers\ValidationHelper;
use Vanier\Api\Models\PeopleModel;

/**
 * PeopleController
 * Handles all people requests
 */
class PeopleController extends BaseController
{
    /**
     * people_model
     * @var
     */
    private $people_model = null;

    /**
     * __construct
     */
    public function __construct()
    {
        $this->people_model = new PeopleModel();
    }

    /**
     * handleGetAllPeople
     * Handles GET requests
     * @param Request $request
     * @param Response $response
     * @param array $uri_args
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function handleGetAllPeople(Request $request, Response $response, array $uri_args)
    {
        $data = $this->isValidItemId($request, $response, $uri_args, 'people_id', $this->people_model, 'people');

        $response_msg =  $this->arrayMessage(200, 'Ok', 'Laureates Fetched!');
        $this->logMessage("info", $response_msg);
        return $this->prepareOkResponse($response, $data, 200);
    }
    
    /**
     * handleCreatePeople
     * Handles POST requests
     * @param Request $request
     * @param Response $response
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function handleCreatePeople(Request $request, Response $response)
    {
        $data = $request->getParsedBody();
        // for array format message
        $format = array(
        "addressid"=> 69,
        "first_name"=> "Bob", 
        "last_name"=> "Bobster",
        "dob"=> "6969-01-10",
        "phonenumber"=> "123456789", 
        "email"=> "notfakeemail@realemail.com", 
        "occupation"=> "Gangster"
        );
        //  --Validation
        //  check if body is empty
        if ($data) {
            // check if its an array 
            if (is_array($data) == true) {
                $validation = new ValidationHelper;
                foreach ($data as $key => $people) {
                    // check if valid params
                    $is_valid = $validation->isValidPeople($people);
                    if ($is_valid !== true) {
                        $response_msg = $this->arrayMessage(400, 'Missing Data!', 'Missing Parameter');
                        $this->logMessage("error", $response_msg);
                    } else {
                        $response_msg =  $this->arrayMessage(200, 'Ok', 'Laureate Added!');
                        $this->logMessage("info", $response_msg);
                        $this->people_model->createPeople($people);
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
     * handleUpdatePeople
     * Handles PUT requests
     * @param Request $request
     * @param Response $response
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function handleUpdatePeople(Request $request, Response $response)
    {
        $data = $request->getParsedBody();
        // for array format message
        $format = array(
            "laureateid"=> 420,
            "addressid"=> 69,
            "first_name"=> "Bob", 
            "last_name"=> "Bobster",
            "dob"=> "6969-01-10",
            "phonenumber"=> "123456789", 
            "email"=> "notfakeemail@realemail.com", 
            "occupation"=> "Gangster"
            );
        //  --Validation
        //  check if body is empty
        if ($data) {
            // check if its an array 
            if (is_array($data) == true) {
                $validation = new ValidationHelper;
                foreach ($data as $key => $people) {
                    $laureate_id = $people['laureateid'];
                    // check if valid params
                    $is_valid = $validation->isValidPeopleUpdate($people);
                    if ($is_valid !== true) {
                        $response_msg = $this->arrayMessage(400, 'Missing Data!', 'Missing Parameter');
                        $this->logMessage("error", $response_msg);
                    } else {
                        unset($people['laureateid']);
                        $response_msg =  $this->arrayMessage(200, 'Ok', 'Laureate Updated!');
                        $this->logMessage("info", $response_msg);

                        $this->people_model->updatePeople($people, $laureate_id);
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
     * handleDeletePeople
     * Handles DELETE requests
     * @param Request $request
     * @param Response $response
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function handleDeletePeople(Request $request, Response $response)
    {
        $data = $request->getParsedBody();

        if ($data) {
            if (is_array($data) == true) {
                $count = count($data);
                //-- Validate the array 
                for ($i = 0; $i < $count; $i++) {
                    $laureate_id = $data[$i];
                    if (is_int($laureate_id)) {
                        $is_valid = $this->people_model->getByPeopleId($laureate_id);
                        if ($is_valid != null) {
                            //-- Ask the model to delete a film specified by its id
                            $this->people_model->deletePeopleById($laureate_id);
                            $response_msg =  $this->arrayMessage(200, 'Ok', 'Laureate Deleted!');
                            $this->logMessage("info", $response_msg);
                        } else {
                            $response_msg =  $this->arrayMessage(410, 'Gone', 'Laureate does not exist');
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
