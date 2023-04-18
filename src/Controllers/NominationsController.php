<?php

namespace Vanier\Api\Controllers;

use Slim\Psr7\Request;
use Slim\Psr7\Response;
use Vanier\Api\Helpers\Input;
use Vanier\Api\Helpers\ValidationHelper;
use Vanier\Api\Models\NominationsModel;

class NominationsController extends BaseController
{
    private $nominations_model = null;
    public function __construct()
    {
        $this->nominations_model = new NominationsModel();
    }

    public function handleGetAllNominations(Request $request, Response $response, array $uri_args)
    {
        $data = $this->isValidItemId($request, $response, $uri_args, 'nomination_id', $this->nominations_model, 'nomination');

        return $this->prepareOkResponse($response, $data, 200);
    }

    public function handleCreateNomination(Request $request, Response $response)
    {
        $data = $request->getParsedBody();
        //  --Validation
        //  check if body is empty
        if($data){
            // check if its an array 
            if(is_array($data)==true){
                $validation = new ValidationHelper;
                foreach ($data as $key => $nomination){
                    // check if valid params
                    $is_valid = $validation->isValidNomination($nomination);
                    if($is_valid!==true){
                        $response_msg = $this->arrayMessage(400, 'Missing Data!', 'Missing Parameter');
                    }else {
                        $response_msg =  $this->arrayMessage(200, 'Ok', 'Nomination Added!');
                        $this->nominations_model->createNomination($nomination);
                    }
               }
            }
        }else{
            $message = 'Please provide an Array. Example:"[{"laureateid": 1, "field_id": "5", "nomination_reason": "Name", "yearofnomination": "Description}]';
                $response_msg =  $this->arrayMessage(403, 'Invalid Format', $message);
        }
        return $this->prepareOkResponse($response, $response_msg, 200);
    }
}
