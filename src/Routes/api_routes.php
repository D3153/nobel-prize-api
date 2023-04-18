<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
use Vanier\Api\Controllers\AboutController;
use Vanier\Api\Controllers\AwardsController;
use Vanier\Api\Controllers\FieldsController;
use Vanier\Api\Controllers\NominationsController;
use Vanier\Api\Controllers\OrganizationsController;
use Vanier\Api\Controllers\PeopleController;
use Vanier\Api\Controllers\PublicationsController;

// Import the app instance into this file's scope.
global $app;

// NOTE: Add your app routes here.
// The callbacks must be implemented in a controller class.
// The Vanier\Api must be used as namespace prefix. 

// ROUTE: /
$app->get('/', [AboutController::class, 'handleAboutApi']);

$app->get('/about', [AboutController::class, 'handleAboutApi']);

// People Routes
// GET
$app->get('/people[/{laureate_id}]', [PeopleController::class, 'handleGetAllPeople']);

// Nominations Routes
// GET
$app->get('/nominations[/{nomination_id}]', [NominationsController::class, 'handleGetAllNominations']);
$app->post('/nominations', [NominationsController::class, 'handleCreateNomination']);

// Publications Routes
// GET
$app->get('/publications[/{publication_id}]', [PublicationsController::class, 'handleGetAllPublications']);
$app->post('/publications', [PublicationsController::class, 'handleCreatePublication']);
$app->put('/publications/{publication_id}', [PublicationsController::class, 'handleUpdatePublication']);

// Organizations Routes
// GET 
$app->get('/organizations[/{organization_id}]', [OrganizationsController::class, 'handleGetAllOrganizations']);

// Awards Routes
// GET
$app->get('/awards[/{award_id}]', [AwardsController::class, 'handleGetAllAwards']);

// Fields Routes
// GET 
$app->get('/fields[/{field_id}]',[FieldsController::class,'handleGetAllFields']);

// ROUTE: /hello
$app->get('/hello', function (Request $request, Response $response, $args) {
    $response->getBody()->write("Reporting! Hello there!");
    return $response;
});
