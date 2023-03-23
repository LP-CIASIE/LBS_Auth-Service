<?php

declare(strict_types=1);

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory as Appfactory;
use lbs\auth\middleware\TokenJwtMiddleware as TokenJwtMiddleware;


require_once "../vendor/autoload.php";

$app = AppFactory::create();

$app->addRoutingMiddleware();
$app->addBodyParsingMiddleware();

// Default route
$app->get('/', function (Request $request, Response $response, $args) {
    $response->getBody()->write("bonjour :)");
  
    return $response;
  });


$app->post('/signin[/]', lbs\auth\actions\SignInAction::class);
$app->get('/validate[/]', lbs\auth\actions\ValidateAction::class);
$app->get('/login[/]', lbs\auth\actions\LoginAction::class);

$app->run();