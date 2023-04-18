<?php

namespace Vanier\Api\Controllers;
use Slim\Psr7\Request;
use Slim\Psr7\Response;
use Vanier\Api\Helpers\Input;
use Vanier\Api\Helpers\ValidationHelper;
use Vanier\Api\Models\PublicationsModel;

class PublicationsController extends BaseController
{
    private $publication_model = null;
    private $rules = null;
    public function __construct()
    {
        $this->publication_model = new PublicationsModel();
        $this->rules = ["laureateid", "fieldid", "publication_name", "publication_desc"];
    }

    public function handleGetAllPublications(Request $request, Response $response, array $uri_args)
    {
        $data = $this->isValidItemId($request, $response, $uri_args, 'publication_id', $this->publication_model, 'publication');

        return $this->prepareOkResponse($response, $data, 200);
    }

    public function handleCreatePublication(Request $request, Response $response)
    {
        $data = $request->getParsedBody();
        //  --Validation
        //  check if body is empty
        if($data){
            // check if its an array 
            if(is_array($data)==true){
                $validation = new ValidationHelper;
                foreach ($data as $key => $pub){
                    // check if valid params
                    $is_valid = $validation->isValidPub($pub);
                    // $null = $this->checkNotNull($pub);
                    if($is_valid!==true){
                        // echo "false";exit;
                        $response_msg = $this->arrayMessage(400, 'Missing Data!', 'Missing Parameter'); 
                        // return $this->prepareOkResponse($response, $response_msg, 200);
                        // echo"checked--bad";exit;
                    }else {
                        // echo "true";exit;
                        $response_msg =  $this->arrayMessage(200, 'Ok', 'Publication Added!');
                        $this->publication_model->createPublication($pub);
                        // return $this->prepareOkResponse($response, $response_msg, 200);
                        // $message = "Valid data!";
                        // echo"checked--good";exit;
                    }
                    // $this->publication_model->createPublication($pub);
               }
            }
            // else{
            //     $message = 'Please provide an Array. Example:"[{"laureateid": 1, "field_id": "5", "publication_id": "4", "publication_desc": "Description}]';
            //     $response_msg =  $this->arrayMessage(403, 'Invalid Format', $message); 
            //     // return $this->prepareOkResponse($response, $response_msg, 200);
    
            // }
        }else{
            $message = 'Please provide an Array. Example:"[{"laureateid": 1, "field_id": "5", "publication_name": "Name", "publication_desc": "Description}]';
                $response_msg =  $this->arrayMessage(403, 'Invalid Format', $message); 
                // return $this->prepareOkResponse($response, $response_msg, 200);
        }
        // $response_msg =  $this->arrayMessage(200, 'Ok', 'Publication Added!');
        return $this->prepareOkResponse($response, $response_msg, 200);
    }
}
