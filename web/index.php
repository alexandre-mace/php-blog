<?php

require_once '../vendor/autoload.php';

use App\Request;
use App\Router\Router;
use App\Router\Route;
use Controller\PostController;
use Controller\BlogController;


$request = Request::createFromGlobals();

$router = New Router($request);

$router->addRoute(new Route("index", "/", [], BlogController::class, "index"));
$router->addRoute(new Route("add", "/add", [], PostController::class, "addPost"));
$router->addRoute(new Route("post", "/post/:id", ["id" => "[\d]+"], PostController::class, "showPost"));
$router->addRoute(new Route("posts", "/posts", [], PostController::class, "showPaginatedPosts"));
$router->addRoute(new Route("update", "/update/:id", ["id" => "[\d]+"], PostController::class, "updatePost"));
$router->addRoute(new Route("delete", "/delete/:id", ["id" => "[\d]+"], PostController::class, "deletePost"));
$router->addRoute(new Route("contact", "/contact", [], BlogController::class, "contact"));


$route = $router->getRouteByRequest();
$response = $route->call($request, $router);
$response->send();