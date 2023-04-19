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
            $message = 'Please provide an Array. Example:
            [{
                "addressid": 1, 
                "first_name": "Bob", 
                "last_name": "Bobster", 
                "dob": "6969-01-10", 
                "phonenumber": "123456789" or "", 
                "email": "notfakeemail@realemail.com" or "", 
                "occupation": "Gangster"
            }]';
            $response_msg =  $this->arrayMessage(403, 'Invalid Format', $message);
        }
        return $this->prepareOkResponse($response, $response_msg, 200);
    }
}
