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
        //put words the moment I pull the remote api resoucre
        $data = $this->isValidItemId($request, $response, $uri_args, 'nomination_id', $this->nominations_model, 'nomination');

        $response_msg =  $this->arrayMessage(200, 'Ok', 'Nominations Received!');
        $this->logMessage("info", $response_msg);

        $dictionary_controller = new DictionaryController();
        $words = $dictionary_controller->getDefinitionWord();
        $data["word"] = $words;
        $dictionary_msg =  $this->arrayMessage(200, 'Ok', 'Words Searched!');
        $this->logMessage("info", $dictionary_msg);

        return $this->prepareOkResponse($response, $data, 200);
    }

    public function handleCreateNomination(Request $request, Response $response)
    {
        $data = $request->getParsedBody();
        $format = array(
            "awardid" => 5,
            "laureateid" => 1,
            "fieldid" => "5",
            "nomination_reason" => "Reason",
            "yearofnomination" => 1969
        );
        //  --Validation
        //  check if body is empty
        if ($data) {
            // check if its an array 
            if (is_array($data) == true) {
                $validation = new ValidationHelper;
                foreach ($data as $key => $nomination) {
                    // check if valid params
                    $is_valid = $validation->isValidNomination($nomination);
                    if ($is_valid !== true) {
                        $response_msg = $this->arrayMessage(400, 'Missing Data!', 'Missing Parameter');
                        $this->logMessage("error", $response_msg);
                    } else {
                        $response_msg =  $this->arrayMessage(200, 'Ok', 'Nomination Added!');
                        $this->logMessage("info", $response_msg);
                        $this->nominations_model->createNomination($nomination);
                    }
                }
            }
        } else {
            $message = 'Please provide an Array.';
            $response_msg =  $this->arrayMessage(403, 'Invalid Format', $message);
            $this->logMessage("error", $response_msg);
            $response_msg["Example"] = $format;
            // $this->logMessage("error", $response_msg);
        }
        return $this->prepareOkResponse($response, $response_msg, 200);
    }

    public function handleUpdateNomination(Request $request, Response $response)
    {
        $data = $request->getParsedBody();
        $format = array(
            "awardid" => 5,
            "laureateid" => 1,
            "fieldid" => "5",
            "nomination_reason" => "Reason",
            "yearofnomination" => 1969
        );
        //  --Validation
        //  check if body is empty
        if ($data) {
            // check if its an array 
            if (is_array($data) == true) {
                $validation = new ValidationHelper;
                foreach ($data as $key => $nomination) {
                    $nomination_id = $nomination['nominationid'];
                    // check if valid params
                    $is_valid = $validation->isValidNominationupdate($nomination);
                    if ($is_valid !== true) {
                        $response_msg = $this->arrayMessage(400, 'Missing Data!', 'Missing Parameter');
                        $this->logMessage("error", $response_msg);
                    } else {
                        unset($nomination['nominationid']);
                        $response_msg =  $this->arrayMessage(200, 'Ok', 'Publication Updated!');
                        $this->logMessage("info", $response_msg);
                        // echo $pub_id;
                        // var_dump($pub); exit;

                        $this->nominations_model->updateNomination($nomination, $nomination_id);
                    }
                }
            }
        } else {
            $message = 'Please provide an Array.';
            $response_msg =  $this->arrayMessage(403, 'Invalid Format', $message);
            $this->logMessage("error", $response_msg);
            $response_msg["Example"] = $format;
        }
        return $this->prepareOkResponse($response, $response_msg, 200);
    }

    public function handleNominationPublication(Request $request, Response $response)
    {
        $data = $request->getParsedBody();

        if ($data) {
            if (is_array($data) == true) {
                $count = count($data);
                //-- Validate the array 
                for ($i = 0; $i < $count; $i++) {
                    $nomination_id = $data[$i];
                    if (is_int($nomination_id)) {
                        $is_valid = $this->nominations_model->getByNominationId($nomination_id);
                        if ($is_valid != null) {
                            //-- Ask the model to delete a film specified by its id
                            $this->nominations_model->deleteNominationById($nomination_id);
                            $response_msg =  $this->arrayMessage(200, 'Ok', 'Nomination Deleted!');
                            $this->logMessage("info", $response_msg);
                        } else {
                            $response_msg =  $this->arrayMessage(410, 'Gone', 'Nomination does not exist');
                            $this->logMessage("error", $response_msg);
                        }
                    } else {
                        $response_msg =  $this->arrayMessage(403, 'Invalid Format', 'Int is required');
                        $this->logMessage("error", $response_msg);
                    }
                }
            } else {
                $response_msg =  $this->arrayMessage(403, 'Invalid Format', 'Array is required');
                $this->logMessage("error", $response_msg);
            }
        } else {
            $response_msg =  $this->arrayMessage(403, 'Invalid Format', 'Array is required');
            $this->logMessage("error", $response_msg);
        }
        return $this->prepareOkResponse($response, $response_msg, 200);
    }

}
