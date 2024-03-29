<?php

namespace Vanier\Api\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Vanier\Api\Helpers\Validator;

/**
 * AboutController
 * Handles the base URI 
 */
class AboutController extends BaseController
{
    /**
     * handleAboutApi
     * This is response for the base URI request
     * URI: /nobel-prize-api/
     * @param Request $request
     * @param Response $response
     * @return Response
     */
    public function handleAboutApi(Request $request, Response $response)
    {
        $uri = $request->getUri();
        $hostname = $uri->getScheme() . '://' . $uri->getHost() . $uri->getPath();
        $resources = array(
            'Description' => 'API with information about the nobel prize.',
            'Authors' => array(
                'name' => 'Craig Justin Vinoya Balibalos, Dinal Patel, Jonathan Dimitriu'
            ),
            'Organizations' => array(
                'uri' => $hostname . 'organizations',
                'methods' => 'GET|POST|PUT|DELETE',
                'description' => 'List of organizations associated with nobel prize',
                'filters' => 'name, phone_num, email, country'
            ),
            'People' => array(
                'uri' => $hostname . 'people',
                'methods' => 'GET|POST|PUT|DELETE',
                'description' => 'List of people associated with nobel prize',
                'filters' => ' first_name, last_name, bornBefore, bornAfter, phone_num, email, country, occupation, award_name'
            ),
            'Date' => array(
                'uri' => $hostname . 'people/date',
                'methods' => 'POST',
                'description' => 'Age of Laureate when they received the award',
                'inputs' => ' first_name, last_name'
            ),
            'Awards' => array(
                'uri' => $hostname . 'awards',
                'methods' => 'GET|PUT',
                'description' => 'List of awards you can get at nobel prize',
                'filters' => 'name, minPrizeAmount, maxPrizeAmount'
            ),
            'Publications' => array(
                'uri' => $hostname . 'publications',
                'methods' => 'GET|POST|PUT|DELETE',
                'description' => 'List of publications associated with nobel prize',
                'filters' => 'name, desc, last_name'
            ),
            'Nominations' => array(
                'uri' => $hostname . 'nominations',
                'methods' => 'GET|POST|PUT|DELETE',
                'description' => 'List of nominees',
                'filters' => ' reason, yearBefore, yearAfter, nominators, award'
            ),
            'Fields' => array(
                'uri' => $hostname . 'fields',
                'methods' => 'GET|PUT',
                'description' => 'List of fields within the nobel prize',
                'filters' => 'name'
            )
        );
        // $response->getBody()->write(json_encode($resources));
        // return $response;
        $response_msg =  $this->arrayMessage(200, 'Ok', 'About Info Received!');
        $this->logMessage("info", $response_msg);
        return $this->prepareOkResponse($response, $resources);
    }
}
