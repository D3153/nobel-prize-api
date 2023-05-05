<?php

namespace Vanier\Api\Controllers;

use Slim\Psr7\Request;
use Slim\Psr7\Response;
use Vanier\Api\Helpers\Input;
use Vanier\Api\Helpers\ValidationHelper;
use Vanier\Api\Models\NominationsModel;

/**
 * NominationsController
 * Handles all Nominations requests
 */
class NominationsController extends BaseController
{
    /**
     * nominations_model
     * @var
     */
    private $nominations_model = null;
    /**
     * search_words
     * @var
     */
    private $search_words = null;

    /**
     * __construct
     */
    public function __construct()
    {
        $this->nominations_model = new NominationsModel();
        // $this->$search_words = ['physiology', 'argon', 'science'];
    }

    /**
     * handleGetAllNominations
     * Handles GET requests
     * @param Request $request
     * @param Response $response
     * @param array $uri_args
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function handleGetAllNominations(Request $request, Response $response, array $uri_args)
    {
        //put words the moment I pull the remote api resoucre
        $data = $this->isValidItemId($request, $response, $uri_args, 'nomination_id', $this->nominations_model, 'nomination');

        $search_words = ['physiology', 'argon', 'president', 'densities'];
        $words = [];

        $response_msg =  $this->arrayMessage(200, 'Ok', 'Nominations Received!');
        $this->logMessage("info", $response_msg);

        foreach ($search_words as $key => $word) {
            $dictionary_controller = new DictionaryController();
            $search_word = $dictionary_controller->getDefinitionWord($word);
            array_push($words, $search_word);
        }
        $data["words"] = $words;

        $dictionary_msg =  $this->arrayMessage(200, 'Ok', 'Words Searched!');
        $this->logMessage("info", $dictionary_msg);

        return $this->prepareOkResponse($response, $data, 200);
    }

    /**
     * handleCreateNomination
     * Handles POST requests
     * @param Request $request
     * @param Response $response
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function handleCreateNomination(Request $request, Response $response)
    {
        $data = $request->getParsedBody();
        // for array format message
        $format = array(
            "awardid" => 5,
            "laureateid" => 1,
            "fieldid" => "5",
            "nomination_reason" => "Reason",
            "yearofnomination" => 1969,
            "nominators" => "me, you, Jo, Craig"
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

    /**
     * handleUpdateNomination
     * Handles PUT requests
     * @param Request $request
     * @param Response $response
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function handleUpdateNomination(Request $request, Response $response)
    {
        $data = $request->getParsedBody();
        // for array format message
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
                    $is_valid = $validation->isValidNominationUpdate($nomination);
                    if ($is_valid !== true) {
                        $response_msg = $this->arrayMessage(400, 'Missing Data!', 'Missing Parameter');
                        $this->logMessage("error", $response_msg);
                    } else {
                        unset($nomination['nominationid']);
                        $response_msg =  $this->arrayMessage(200, 'Ok', 'Nomination Updated!');
                        $this->logMessage("info", $response_msg);

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

    /**
     * handleDeleteNomination
     * Handles DELETE requests
     * @param Request $request
     * @param Response $response
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function handleDeleteNomination(Request $request, Response $response)
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
