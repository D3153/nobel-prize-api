<?php

namespace Vanier\Api\Controllers;

use Slim\Psr7\Request;
use Slim\Psr7\Response;
use Vanier\Api\Helpers\Input;
use Vanier\Api\Helpers\ValidationHelper;
use Vanier\Api\Models\PublicationsModel;

/**
 * PublicationsController
 * Handles all publications requests
 */
class PublicationsController extends BaseController
{
    /**
     * publication_model
     * @var
     */
    private $publication_model = null;
    /**
     * __construct
     */
    public function __construct()
    {
        $this->publication_model = new PublicationsModel();
    }

    /**
     * handleGetAllPublications
     * Handles GET requests
     * URI: /nobel-prize-api/publications
     * @param Request $request
     * @param Response $response
     * @param array $uri_args
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function handleGetAllPublications(Request $request, Response $response, array $uri_args)
    {
        $data = $this->isValidItemId($request, $response, $uri_args, 'publication_id', $this->publication_model, 'publication');

        if (empty($data['results']) == true) {
            $response_msg =  $this->arrayMessage(404, 'Not Found', 'No Publications Found!');
            $this->logMessage("info", $response_msg);
            return $this->prepareOkResponse($response, $response_msg, 404);
        } else {
            $response_msg =  $this->arrayMessage(200, 'Ok', 'Publications Received!');
            $this->logMessage("info", $response_msg);
            return $this->prepareOkResponse($response, $data, 200);
        }
    }

    /**
     * handleCreatePublication
     * Handles POST requests
     * URI: /nobel-prize-api/publications
     * @param Request $request
     * @param Response $response
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function handleCreatePublication(Request $request, Response $response)
    {
        $data = $request->getParsedBody();
        $format = array(
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
                        $error_msg = $validation->getErrorMsg();
                        $response_msg = $this->arrayMessage(400, 'Missing Data!', $error_msg);
                        $this->logMessage("error", $response_msg);
                        return $this->prepareOkResponse($response, $response_msg, 400);
                    } else {
                        $response_msg =  $this->arrayMessage(200, 'Ok', 'Publication Added!');
                        $this->logMessage("info", $response_msg);
                        $this->publication_model->createPublication($pub);
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

    /**
     * handleUpdatePublication
     * Handles PUT requests
     * URI: /nobel-prize-api/publications
     * @param Request $request
     * @param Response $response
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function handleUpdatePublication(Request $request, Response $response)
    {
        $data = $request->getParsedBody();
        // for array format message
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
                        $this->logMessage("error", $response_msg);
                        return $this->prepareOkResponse($response, $response_msg, 400);
                    } else {
                        unset($pub['publicationid']);
                        $response_msg =  $this->arrayMessage(200, 'Ok', 'Publication Updated!');
                        $this->logMessage("info", $response_msg);

                        $this->publication_model->updatePublication($pub, $pub_id);
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

    /**
     * handleDeletePublication
     * Handles DELETE requests
     * URI: /nobel-prize-api/publications
     * @param Request $request
     * @param Response $response
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function handleDeletePublication(Request $request, Response $response)
    {
        $data = $request->getParsedBody();

        if ($data) {
            if (is_array($data) == true) {
                $count = count($data);
                //-- Validate the array 
                for ($i = 0; $i < $count; $i++) {
                    $pub_id = $data[$i];
                    if (is_int($pub_id)) {
                        $is_valid = $this->publication_model->getByPubId($pub_id);
                        if ($is_valid != null) {
                            //-- Ask the model to delete a film specified by its id
                            $this->publication_model->deletePubById($pub_id);
                            $response_msg =  $this->arrayMessage(200, 'Ok', 'Publication Deleted!');
                            $this->logMessage("info", $response_msg);
                        } else {
                            $response_msg =  $this->arrayMessage(410, 'Gone', 'Publication does not exist');
                            $this->logMessage("error", $response_msg);
                            return $this->prepareOkResponse($response, $response_msg, 410);
                        }
                    } else {
                        $response_msg =  $this->arrayMessage(403, 'Invalid Format', 'Int is required');
                        $this->logMessage("error", $response_msg);
                        return $this->prepareOkResponse($response, $response_msg, 403);
                    }
                }
            } else {
                $response_msg =  $this->arrayMessage(403, 'Invalid Format', 'Array is required');
                $this->logMessage("error", $response_msg);
                return $this->prepareOkResponse($response, $response_msg, 403);
            }
        } else {
            $response_msg =  $this->arrayMessage(403, 'Invalid Format', 'Array is required');
            $this->logMessage("error", $response_msg);
            return $this->prepareOkResponse($response, $response_msg, 403);
        }
        return $this->prepareOkResponse($response, $response_msg, 200);
    }
}
