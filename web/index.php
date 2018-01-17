<?php
require_once '../vendor/autoload.php';

$loader = new Twig_Loader_Filesystem('../src/View/');
$twig = new Twig_Environment($loader, array(
    'cache' => false
));

$router = New Router;

Router::addRoute;

Router::getCurrentRoute;
	//try every route by parsing
	//route match to test it and return route parameters

Route::call