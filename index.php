<?php

use Slim\Factory\AppFactory;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Vanier\Api\Middlewares\ContentNegotiationMiddleware;
use Vanier\Api\Middlewares\LoggingMiddleWare;

// use Monolog\Handler\StreamHandler;
// use Monolog\Logger;

define('APP_BASE_DIR', __DIR__. '/');

require __DIR__ . '/vendor/autoload.php';
 // Include the file that contains the application's global configuration settings,
 // database credentials, etc.
require_once __DIR__ . '/src/Config/app_config.php';

//--Step 1) Instantiate a Slim app.
$app = AppFactory::create();
//-- Add the routing and body parsing middleware
$app->add(new ContentNegotiationMiddleware([APP_MEDIA_TYPE_XML, APP_MEDIA_TYPE_YAML]));
$app->add(new LoggingMiddleWare());
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
// $app->get('/logme',function (Request $request, Response $response,$args)
// {
// $logger = new Logger("craig_logs");
// $logger->pushHandler(new StreamHandler(__DIR__.'/my_app.log', Level::Debug))
// $logger->info("Hello/Oi Crag...");

// $response->getBody()->write("Reporting! log in progress!");
// return $response;
// })
// Here we include the file that contains the application routes. 
// NOTE: your routes must be managed in the api_routes.php file.
require_once __DIR__ . '/src/Routes/api_routes.php';

// ROUTE: /logging
// define('APP_LOG_DIR', __DIR__.'\logs\nobel-prize-api.log');
// $app->get('/logging', function (Request $request, Response $response, $args) {
//     // --1 A new Log channel for general message
//     $logger = new Logger("nobel_prize_log");
//     $log_handler = new StreamHandler(APP_LOG_DIR, Logger::DEBUG);
//     $logger->pushHandler($log_handler);
//     // --2 A new log channel for database
//     $db_logger = new Logger("database_logs");
//     $db_logger->pushHandler($log_handler);
//     $db_logger->info("This query failed ...");
//     // -- General Log message
//     $params = $request->getQueryParams();
//     $logger->info("Access: ". $request->getMethod(). ' ' . $request->getUri()->getPath(), $params);
//     $response->getBody()->write("Reporting! Hello there!");
//     return $response;
// });

// This is a middleware that should be disabled/enabled later. 
//$app->add($beforeMiddleware);
// Run the app.
$app->run();
