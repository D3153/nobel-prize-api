<?php

namespace Vanier\Api\Controllers;

use Slim\Psr7\Request;
use Slim\Psr7\Response;
use Vanier\Api\Helpers\Input;
use Vanier\Api\Helpers\ValidationHelper;
use Vanier\Api\Models\AwardsModel;

class AwardsController extends BaseController
{
    private $award_model = null;
    public function __construct()
    {
        $this->award_model = new AwardsModel();
    }

    public function handleGetAllAwards(Request $request, Response $response, array $uri_args)
    {
        $this->logMessage("hello");
        $data = $this->isValidItemId($request, $response, $uri_args, 'award_id', $this->award_model, 'award');

        return $this->prepareOkResponse($response, $data, 200);
    }

    public function handleUpdateAwards(Request $request, Response $response)
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
                foreach ($data as $key => $award) {
                    $award_id = $award['awardid'];
                    // check if valid params
                    $is_valid = $validation->isValidAwardUpdate($award);
                    if ($is_valid !== true) {
                        $response_msg = $this->arrayMessage(400, 'Missing Data!', 'Missing Parameter');
                    } else {
                        unset($award['awardid']);
                        $response_msg =  $this->arrayMessage(200, 'Ok', 'Publication Updated!');
                        // echo $pub_id;
                        // var_dump($pub); exit;

                        $this->award_model->updateAward($award, $award_id);
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
