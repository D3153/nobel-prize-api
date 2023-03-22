<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
use Vanier\Api\Controllers\AboutController;
use Vanier\Api\Controllers\AwardsController;
use Vanier\Api\Controllers\NominationsController;
use Vanier\Api\Controllers\PeopleController;
use Vanier\Api\Controllers\PublicationsController;

// Import the app instance into this file's scope.
global $app;

// NOTE: Add your app routes here.
// The callbacks must be implemented in a controller class.
// The Vanier\Api must be used as namespace prefix. 

// ROUTE: /
$app->get('/', function (Request $request, Response $response, $args){
    $uri = $request->getUri();
    $hostname = $uri->getScheme() . '://' . $uri->getHost() . $uri->getPath();
    $resources = array(
        'Description'=>'API with information about the nobel prize.',
        'Authors'=> array(
            'name'=> 'Craig Justin Vinoya Balibalos, Dinal Patel, Johnathan Dimitriu'
        ),
        'Organizations' => array(
            'uri' => $hostname . 'organizations',
            'methods' => 'GET|POST|PUT|DELETE',
            'description' => 'List of organizations associated with nobel prize',
            'filters'=> 'name, phone_num, email, country'
        ),
        'People' => array(
            'uri' => $hostname . 'people',
            'methods' => 'GET|POST|PUT|DELETE',
            'description' => 'List of people associated with nobel prize',
            'filters'=> ' first_name, last_name, bornBefore, bornAfter, phone_num, email, country, occupation, award_name'
        ),
        'Awards' => array(
            'uri' => $hostname . 'awards',
            'methods' => 'GET|PUT',
            'description' => 'List of awards you can get at nobel prize',
            'filters'=> 'name, minPrizeAmount, maxPrizeAmount'
        ),
        'Publications' => array(
            'uri' => $hostname . 'publications',
            'methods' => 'GET|POST|PUT|DELETE',
            'description' => 'List of publications associated with nobel prize',
            'filters'=> 'name, desc, last_name'
        ),
        'Nominations' => array(
            'uri' => $hostname . 'nominations',
            'methods' => 'GET|POST|PUT|DELETE',
            'description' => 'List of nominees',
            'filters'=> ' reason, yearBefore, yearAfter, nominators, award'
        ),
        'Fields' => array(
            'uri' => $hostname . 'fields',
            'methods' => 'GET|PUT',
            'description' => 'List of fields within the nobel prize',
            'filters'=> 'name'
        )
    );
    $response->getBody()->write(json_encode($resources));
    return $response;
});

$app->get('/about', [AboutController::class, 'handleAboutApi']); 

// People Routes
// GET
$app->get('/people', [PeopleController::class, 'handleGetAllPeople']);

// Nominations Routes
// GET
$app->get('/nominations', [NominationsController::class, 'handleGetAllNominations']);

// Publications Routes
// GET
$app->get('/publications', [PublicationsController::class, 'handleGetAllPublications']);

// Awards Routes
// GET
$app->get('/awards', [AwardsController::class, 'handleGetAllAwards']);

// ROUTE: /hello
$app->get('/hello', function (Request $request, Response $response, $args) {
    $response->getBody()->write("Reporting! Hello there!");    
    return $response;
});