<?php

namespace Vanier\Api\Controllers;

use Slim\Psr7\Request;
use Slim\Psr7\Response;
use Vanier\Api\Controllers\BaseController;
use Vanier\Api\Helpers\Input;
use Vanier\Api\Helpers\ValidationHelper;
use Vanier\Api\Models\PeopleModel;

class PeopleController extends BaseController
{
    private $people_model = null;

    public function __construct()
    {
        $this->people_model = new PeopleModel();
    }

    public function handleGetAllPeople(Request $request, Response $response, array $uri_args)
    {
        $data = $this->isValidItemId($request, $response, $uri_args, 'people_id', $this->people_model, 'people');

        return $this->prepareOkResponse($response, $data, 200);
    }
    
    public function handleCreatePeople(Request $request, Response $response)
    {
        $data = $request->getParsedBody();
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
                    } else {
                        $response_msg =  $this->arrayMessage(200, 'Ok', 'Laureate Added!');
                        $this->people_model->createPeople($people);
                    }
                }
            }
        } else {
            $message = 'Please provide an Array.';
            $response_msg =  $this->arrayMessage(403, 'Invalid Format', $message);
            $response_msg["Example"] = $format;
        }
        return $this->prepareOkResponse($response, $response_msg, 200);
    }

    public function handleUpdatePeople(Request $request, Response $response)
    {
        $data = $request->getParsedBody();
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
                    // unset($people['laureateid']);
                    // check if valid params
                    $is_valid = $validation->isValidPeopleUpdate($people);
                    if ($is_valid !== true) {
                        $response_msg = $this->arrayMessage(400, 'Missing Data!', 'Missing Parameter');
                    } else {
                        unset($people['laureateid']);
                        $response_msg =  $this->arrayMessage(200, 'Ok', 'Laureate Updated!');
                        // echo $pub_id;
                        // var_dump($pub); exit;

                        $this->people_model->updatePeople($people, $laureate_id);
                    }
                    // unset($people['laureateid']);
                }
            }
        } else {
            $message = 'Please provide an Array.';
            $response_msg =  $this->arrayMessage(403, 'Invalid Format', $message);
            $response_msg["Example"] = $format;
        }
        return $this->prepareOkResponse($response, $response_msg, 200);
    }
}
