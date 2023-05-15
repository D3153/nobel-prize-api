<?php

namespace Vanier\Api\Controllers;

use Slim\Psr7\Request;
use Slim\Psr7\Response;
use Vanier\Api\Controllers\BaseController;
use Vanier\Api\Helpers\Input;
use Vanier\Api\Helpers\ValidationHelper;
use Vanier\Api\Models\AddressModel;

/**
 * AddressController
 * Handles all Address requests 
 */
class AddressController extends BaseController
{
    /**
     * address_model
     * @var
     */
    private $address_model = null;

    /**
     * __construct
     */
    public function __construct()
    {
        $this->address_model = new AddressModel();
    }

    /**
     * handleCreateAddress
     * handles POST request
     * URI: /nobel-prize-api/address 
     * @param Request $request
     * @param Response $response
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function handleCreateAddress(Request $request, Response $response)
    {
        $data = $request->getParsedBody();
        // for array format message
        $format = array(
            "streetname" => "Somewhere",
            "city" => "not a city",
            "country" => "Antarctica",
            "state" => "Liquid",
            "zipcode" => "0L1O8D"
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
                        $this->logMessage("error", $response_msg);
                        return $this->prepareOkResponse($response, $response_msg, 400);
                    } else {
                        $response_msg =  $this->arrayMessage(200, 'Ok', 'Address Added!');
                        $this->logMessage("info", $response_msg);
                        $this->address_model->createAddress($address);
                    }
                }
            }
        } else {
            $message = 'Please provide an Array';
            $response_msg =  $this->arrayMessage(403, 'Invalid Format', $message);
            $response_msg["Example"] = $format;
            $this->logMessage("error", $response_msg);
            return $this->prepareOkResponse($response, $response_msg, 403);
        }
        return $this->prepareOkResponse($response, $response_msg, 200);
    }

    /**
     * handleUpdateAddress
     * handles PUT request 
     * URI: /nobel-prize-api/address
     * @param Request $request
     * @param Response $response
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function handleUpdateAddress(Request $request, Response $response)
    {
        $data = $request->getParsedBody();
        // for array format message
        $format = array(
            "addressid" => 69,
            "streetname" => "Somewhere",
            "city" => "not a city",
            "country" => "Antarctica",
            "state" => "Liquid",
            "zipcode" => "0L1O8D"
        );
        //  --Validation
        //  check if body is empty
        if ($data) {
            // check if its an array 
            if (is_array($data) == true) {
                $validation = new ValidationHelper;
                foreach ($data as $key => $address) {
                    $address_id = $address['addressid'];
                    // check if valid params
                    $is_valid = $validation->isValidAddressUpdate($address);
                    if ($is_valid !== true) {
                        $response_msg = $this->arrayMessage(400, 'Missing Data!', 'Missing Parameter');
                        $this->logMessage("error", $response_msg);
                        return $this->prepareOkResponse($response, $response_msg, 400);
                    } else {
                        unset($address['addressid']);
                        $response_msg =  $this->arrayMessage(200, 'Ok', 'Address Updated!');
                        $this->logMessage("info", $response_msg);

                        $this->address_model->updateAddress($address, $address_id);
                    }
                }
            }
        } else {
            $message = 'Please provide an Array.';
            $response_msg =  $this->arrayMessage(403, 'Invalid Format', $message);
            $this->logMessage("error", $response_msg);
            $response_msg["Example"] = $format;
            return $this->prepareOkResponse($response, $response_msg, 403);
        }
        return $this->prepareOkResponse($response, $response_msg, 200);
    }
}
