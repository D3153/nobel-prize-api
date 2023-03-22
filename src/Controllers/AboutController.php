<?php

namespace Vanier\Api\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Vanier\Api\Helpers\Validator;

class AboutController extends BaseController
{
    public function handleAboutApi(Request $request, Response $response, array $uri_args)
    {
        $uri = $request->getUri();
        $hostname = $uri->getScheme() . '://' . $uri->getHost() . $uri->getPath();
        $resources = array(
            'Description' => 'API with information about the nobel prize.',
            'Authors' => array(
                'name' => 'Craig Justin Vinoya Balibalos, Dinal Patel, Johnathan Dimitriu'
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
        return $this->prepareOkResponse($response, $resources);
    }
}
