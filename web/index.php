<?php

require_once '../vendor/autoload.php';

use App\Request;
use App\Router\Router;
use App\Router\Route;
use Controller\PostController;
use Controller\CommentController;
use Controller\BlogController;
use Controller\AuthController;
use Controller\UserController;

$request = Request::createFromGlobals();

$router = New Router($request);

$router->addRoute(new Route("index", "/", [], BlogController::class, "index"));
$router->addRoute(new Route("post", "/post/:id/:page", ["id" => "[\d]+", "page" => "[\d]*"], PostController::class, "showPost"));
$router->addRoute(new Route("posts", "/posts/:page", ["page" => "[\d]*"], PostController::class, "showPaginatedPosts"));
$router->addRoute(new Route("reportedPosts", "/reportedposts/:page", ["page" => "[\d]*"], PostController::class, "showReportedPosts"));
$router->addRoute(new Route("uncheckedComments", "/uncheckedcomments/:page", ["page" => "[\d]*"], CommentController::class, "showUncheckedComments"));
$router->addRoute(new Route("reportedComments", "/reportedcomments/:page", ["page" => "[\d]*"], CommentController::class, "showReportedComments"));
$router->addRoute(new Route("contact", "/contact", [], BlogController::class, "showContact"));
$router->addRoute(new Route("addPostPage", "/addpostpage", [], BlogController::class, "showAddPost"));



$router->addRoute(new Route("addPost", "/addpost", [], PostController::class, "addPost"));
$router->addRoute(new Route("addComment", "/addcomment/:id/:page", ["id" => "[\d]+", "page" => "[\d]*"], CommentController::class, "addComment"));
$router->addRoute(new Route("addAdmin", "/addadmin", [], UserController::class, "addAdmin"));
$router->addRoute(new Route("updatePost", "/updatepost/:id", ["id" => "[\d]+"], PostController::class, "updatePost"));
$router->addRoute(new Route("updateComment", "/updatecomment/:id", ["id" => "[\d]+"], CommentController::class, "updateComment"));
$router->addRoute(new Route("deletePost", "/deletepost/:id", ["id" => "[\d]+"], PostController::class, "deletePost"));
$router->addRoute(new Route("deleteComment", "/deletecomment/:id", ["id" => "[\d]+"], CommentController::class, "deleteComment"));

$router->addRoute(new Route("likePost", "/likepost/:id", ["id" => "[\d]+"], PostController::class, "likePost"));
$router->addRoute(new Route("likeComment", "/likecomment/:id", ["id" => "[\d]+"], CommentController::class, "likeComment"));
$router->addRoute(new Route("reportPost", "/reportpost/:id", ["id" => "[\d]+"], PostController::class, "reportPost"));
$router->addRoute(new Route("unReportPost", "/unreportpost/:id", ["id" => "[\d]+"], PostController::class, "unreportPost"));
$router->addRoute(new Route("reportComment", "/reportcomment/:id", ["id" => "[\d]+"], CommentController::class, "reportComment"));
$router->addRoute(new Route("unReportComment", "/unreportcomment/:id", ["id" => "[\d]+"], CommentController::class, "unreportComment"));
$router->addRoute(new Route("checkComment", "/checkcomment/:id", ["id" => "[\d]+"], CommentController::class, "checkComment"));
$router->addRoute(new Route("auth", "/auth", [], AuthController::class, "auth"));


$route = $router->getRouteByRequest();
$response = $route->call($request, $router);
$response->send();