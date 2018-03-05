<?php

require_once '../vendor/autoload.php';

use App\Request;
use App\Router\Router;
use App\Router\Route;
use Controller\PostController;


$request = Request::createFromGlobals();

$router = New Router($request);


$router->addRoute(new Route("add", "/add", [], PostController::class, "addPost"));

$route = $router->getRouteByRequest();
$response = $route->call($request, $router);
$response->send();