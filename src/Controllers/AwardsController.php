<?php

namespace Vanier\Api\Controllers;

use Slim\Psr7\Request;
use Slim\Psr7\Response;
use Vanier\Api\Helpers\Input;
use Vanier\Api\Helpers\ValidationHelper;
use Vanier\Api\Models\AwardsModel;

/**
 * AwardsController
 * Handles all Awards requests
 */
class AwardsController extends BaseController
{
    /**
     * award_model
     * @var
     */
    private $award_model = null;
    /**
     * __construct
     */
    public function __construct()
    {
        $this->award_model = new AwardsModel();
    }

    /**
     * handleGetAllAwards
     * Handles GET requests
     * @param Request $request
     * @param Response $response
     * @param array $uri_args
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function handleGetAllAwards(Request $request, Response $response, array $uri_args)
    {
        $data = $this->isValidItemId($request, $response, $uri_args, 'award_id', $this->award_model, 'award');

        if (empty($data) == true) {
            $response_msg =  $this->arrayMessage(404, 'Not Found', 'No Awards Found!');
            $this->logMessage("info", $response_msg);
            return $this->prepareOkResponse($response, $response_msg, 404);
        } else {
            $response_msg =  $this->arrayMessage(200, 'Ok', 'Awards Received!');
            $this->logMessage("info", $response_msg);
            return $this->prepareOkResponse($response, $data, 200);
        }
    }

    /**
     * handleUpdateAwards
     * Handles PUT requests
     * @param Request $request
     * @param Response $response
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function handleUpdateAwards(Request $request, Response $response)
    {
        $data = $request->getParsedBody();
        // for array format message
        $format = array(
            "awardid" => 7,
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
                foreach ($data as $key => $award) {
                    $award_id = $award['awardid'];
                    // check if valid params
                    $is_valid = $validation->isValidAwardUpdate($award);
                    if ($is_valid !== true) {
                        $response_msg = $this->arrayMessage(400, 'Missing Data!', 'Missing Parameter');
                        $this->logMessage("error", $response_msg);
                        return $this->prepareOkResponse($response, $response_msg, 400);
                    } else {
                        unset($award['awardid']);
                        $response_msg =  $this->arrayMessage(200, 'Ok', 'Award Updated!');
                        $this->logMessage("info", $response_msg);


                        $this->award_model->updateAward($award, $award_id);
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
