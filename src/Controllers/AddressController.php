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
        $format = array(
            "streetname"=> "Somewhere", 
            "city"=> "not a city",
            "country"=> "Antarctica",
            "state"=> "Liquid", 
            "zipcode"=> "0L1O8D"
            );
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
            $message = 'Please provide an Array';
            $response_msg =  $this->arrayMessage(403, 'Invalid Format', $message);
            $response_msg["Example"] = $format;
        }
        return $this->prepareOkResponse($response, $response_msg, 200);
    }

    public function handleUpdateAddress(Request $request, Response $response)
    {
        $data = $request->getParsedBody();
        $format = array(
            "addressid"=> 69,
            "streetname"=> "Somewhere", 
            "city"=> "not a city",
            "country"=> "Antarctica",
            "state"=> "Liquid", 
            "zipcode"=> "0L1O8D"
            );
        //  --Validation
        //  check if body is empty
        if ($data) {
            // check if its an array 
            if (is_array($data) == true) {
                $validation = new ValidationHelper;
                foreach ($data as $key => $address) {
                    $address_id = $address['addressid'];
                    // unset($people['laureateid']);
                    // check if valid params
                    $is_valid = $validation->isValidAddressUpdate($address);
                    if ($is_valid !== true) {
                        $response_msg = $this->arrayMessage(400, 'Missing Data!', 'Missing Parameter');
                    } else {
                        unset($address['addressid']);
                        $response_msg =  $this->arrayMessage(200, 'Ok', 'Address Updated!');
                        // echo $pub_id;
                        // var_dump($pub); exit;

                        $this->address_model->updateAddress($address, $address_id);
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
