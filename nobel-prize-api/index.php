<?php

use Slim\Factory\AppFactory;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

require __DIR__ . '/vendor/autoload.php';
 // Include the file that contains the application's global configuration settings,
 // database credentials, etc.
require_once __DIR__ . '/src/Config/app_config.php';

//--Step 1) Instantiate a Slim app.
$app = AppFactory::create();
//-- Add the routing and body parsing middleware.
$app->addRoutingMiddleware();
$app->addBodyParsingMiddleware();

//-- Add error handling middleware.
// NOTE: the error middleware MUST be added last.
$errorMiddleware = $app->addErrorMiddleware(true, true, true);
$errorMiddleware = $errorMiddleware->getDefaultErrorHandler();
$errorMiddleware->forceContentType(APP_MEDIA_TYPE_JSON);
// $errorMiddleware->getDefaultErrorHandler()->forceContentType(APP_MEDIA_TYPE_JSON);

// TODO: change the name of the subdirectory here.
// You also need to change it in .htaccess
// $app->setBasePath("/slim-template");
$app->setBasePath("/nobel-prize-api");

// Here we include the file that contains the application routes. 
// NOTE: your routes must be managed in the api_routes.php file.
// require_once __DIR__ . '/src/Routes/api_routes.php';

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

// This is a middleware that should be disabled/enabled later. 
//$app->add($beforeMiddleware);
// Run the app.
$app->run();
