<?php

require_once '../vendor/autoload.php';

use App\Request;

use App\Router\Router;


$loader = new Twig_Loader_Filesystem('../src/View/');

$twig = new Twig_Environment($loader, array(
    'cache' => false
));


$request = Request::createFromGlobals();

$router = New Router($request);

$router->loadRoutes();

$route = $router->getRouteByRequest();

$response = $route->call($request, $router);

$response->send();