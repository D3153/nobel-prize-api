<?php


use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
use Vanier\Api\Controllers\AboutController;
use Vanier\Api\Controllers\AddressController;
use Vanier\Api\Controllers\AwardsController;
use Vanier\Api\Controllers\FieldsController;
use Vanier\Api\Controllers\NominationsController;
use Vanier\Api\Controllers\OrganizationsController;
use Vanier\Api\Controllers\PeopleController;
use Vanier\Api\Controllers\PublicationsController;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;

// Import the app instance into this file's scope.
global $app;

// NOTE: Add your app routes here.
// The callbacks must be implemented in a controller class.
// The Vanier\Api must be used as namespace prefix. 

// ROUTE: /
$app->get('/', [AboutController::class, 'handleAboutApi']);

$app->get('/about', [AboutController::class, 'handleAboutApi']);

// Address Routes
// POST
$app->post('/address', [AddressController::class, 'handleCreateAddress']);
// PUT
$app->put('/address', [AddressController::class, 'handleUpdateAddress']);

// People Routes
// GET
$app->get('/people[/{laureate_id}]', [PeopleController::class, 'handleGetAllPeople']);
// POST
$app->post('/people', [PeopleController::class, 'handleCreatePeople']);
// PUT
$app->put('/people', [PeopleController::class, 'handleUpdatePeople']);

// Nominations Routes
// GET
$app->get('/nominations[/{nomination_id}]', [NominationsController::class, 'handleGetAllNominations']);
// POST
$app->post('/nominations', [NominationsController::class, 'handleCreateNomination']);
// PUT
$app->put('/nominations', [NominationsController::class, 'handleUpdateNomination']);

// Publications Routes
// GET
$app->get('/publications[/{publication_id}]', [PublicationsController::class, 'handleGetAllPublications']);
// POST
$app->post('/publications', [PublicationsController::class, 'handleCreatePublication']);
// PUT
$app->put('/publications', [PublicationsController::class, 'handleUpdatePublication']);

// Organizations Routes
// GET 
$app->get('/organizations[/{organization_id}]', [OrganizationsController::class, 'handleGetAllOrganizations']);
// POST
$app->post('/organizations', [OrganizationsController::class, 'handleCreateOrganizations']);
// PUT
$app->put('/organizations', [OrganizationsController::class, 'handleUpdateOrganization']);

// Awards Routes
// GET
$app->get('/awards[/{award_id}]', [AwardsController::class, 'handleGetAllAwards']);
// PUT
$app->put('/awards', [AwardsController::class, 'handleUpdateAwards']);

// Fields Routes
// GET 
$app->get('/fields[/{field_id}]',[FieldsController::class,'handleGetAllFields']);

// ROUTE: /hello
$app->get('/hello', function (Request $request, Response $response, $args) {
    $response->getBody()->write("Reporting! Hello there!");
    return $response;
});

// define('APP_LOG_DIR', __DIR__.'\logs\nobel-prize-api.log');
$app->get('/logging', function (Request $request, Response $response, $args) {
    // --1 A new Log channel for general message
    $logger = new Logger("nobel_prize_log");
    $logger->setTimezone(new DateTimeZone('America/Toronto'));
    $log_handler = new StreamHandler(APP_LOG_DIR, Logger::DEBUG);
    $logger->pushHandler($log_handler);
    // --2 A new log channel for database
    // $db_logger = new Logger("database_logs");
    // $db_logger->pushHandler($log_handler);
    // $db_logger->info("This query failed ...");
    // -- General Log message
    $params = $request->getQueryParams();
    $logger->info("Access: ". $request->getMethod(). ' ' . $request->getUri()->getPath(), $params);
    $response->getBody()->write("Reporting! Hello there!");
    return $response;
});
