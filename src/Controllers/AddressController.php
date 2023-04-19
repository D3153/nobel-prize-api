<?php

namespace Vanier\Api\Controllers;

use Slim\Psr7\Request;
use Slim\Psr7\Response;
use Vanier\Api\Controllers\BaseController;
use Vanier\Api\Helpers\Input;
use Vanier\Api\Helpers\ValidationHelper;
use Vanier\Api\Models\AddressModel;

class AddressController extends BaseController
{
    private $address_model = null;

    public function __construct()
    {
        $this->address_model = new AddressModel();
    }

    public function handleCreateAddress(Request $request, Response $response)
    {
        $data = $request->getParsedBody();
        //  --Validation
        //  check if body is empty
        if ($data) {
            // check if its an array 
            if (is_array($data) == true) {
                $validation = new ValidationHelper;
                foreach ($data as $key => $address) {
                    // check if valid params
                    $is_valid = $validation->isValidAddress($address);
                    if ($is_valid !== true) {
                        $response_msg = $this->arrayMessage(400, 'Missing Data!', 'Missing Parameter');
                    } else {
                        $response_msg =  $this->arrayMessage(200, 'Ok', 'Address Added!');
                        $this->address_model->createAddress($address);
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
