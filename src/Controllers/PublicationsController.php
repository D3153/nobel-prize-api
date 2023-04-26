<?php

namespace Vanier\Api\Controllers;

use Slim\Psr7\Request;
use Slim\Psr7\Response;
use Vanier\Api\Helpers\Input;
use Vanier\Api\Helpers\ValidationHelper;
use Vanier\Api\Models\PublicationsModel;
use Fig\Http\Message\StatusCodeInterface as HttpCodes;
use Vanier\Api\Exceptions\InvalidArgumentException;

class PublicationsController extends BaseController
{
    private $publication_model = null;
    public function __construct()
    {
        $this->publication_model = new PublicationsModel();
    }

    public function handleGetAllPublications(Request $request, Response $response, array $uri_args)
    {
        $data = $this->isValidItemId($request, $response, $uri_args, 'publication_id', $this->publication_model, 'publication');

        return $this->prepareOkResponse($response, $data, 200);
    }

    public function handleCreatePublication(Request $request, Response $response)
    {
        $data = $request->getParsedBody();
        $format = array(
            "publicationid" => 5,
            "laureateid" => 1,
            "fieldid" => "5",
            "publication_name" => "Name",
            "publication_desc" => "Description"
        );
        //  --Validation
        //  check if body is empty
        if ($data) {
            // check if its an array 
            if (is_array($data) == true) {
                $validation = new ValidationHelper;
                foreach ($data as $key => $pub) {
                    // check if valid params
                    $is_valid = $validation->isValidPub($pub);
                    if ($is_valid !== true) {
                        $response_msg = $this->arrayMessage(400, 'Missing Data!', 'Missing Parameter');
                        // $error_data = [
                        //     "code" => HttpCodes::STATUS_BAD_REQUEST, 
                        //     "message" => "Missing Data", 
                        //     "description" => "Missing parameter in Body. Required parameters not met."
                        // ];
                        // return $response->withStatus(HttpCodes::STATUS_NOT_ACCEPTABLE);
                    } else {
                        $response_msg =  $this->arrayMessage(200, 'Ok', 'Publication Added!');
                        $this->publication_model->createPublication($pub);
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

    public function handleUpdatePublication(Request $request, Response $response)
    {
        $data = $request->getParsedBody();
        $format = array(
            "publicationid" => 5,
            "laureateid" => 1,
            "fieldid" => "5",
            "publication_name" => "Name",
            "publication_desc" => "Description"
        );
        //  --Validation
        //  check if body is empty
        if ($data) {
            // check if its an array 
            if (is_array($data) == true) {
                $validation = new ValidationHelper;
                foreach ($data as $key => $pub) {
                    $pub_id = $pub['publicationid'];
                    // check if valid params
                    $is_valid = $validation->isValidPubUpdate($pub);
                    if ($is_valid !== true) {
                        $response_msg = $this->arrayMessage(400, 'Missing Data!', 'Missing Parameter');
                    } else {
                        unset($pub['publicationid']);
                        $response_msg =  $this->arrayMessage(200, 'Ok', 'Publication Updated!');
                        // echo $pub_id;
                        // var_dump($pub); exit;

                        $this->publication_model->updatePublication($pub, $pub_id);
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
}
