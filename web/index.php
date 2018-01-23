<?php

require_once '../vendor/autoload.php';

use App\Request;
use App\Router\Router;


$request = Request::createFromGlobals();
$router = New Router($request);
$router->loadRoutes();
$route = $router->getRouteByRequest();
$response = $route->call($request, $router);
$response->send();