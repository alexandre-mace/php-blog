<?php

namespace App\Router;

class Router {

	private $routes;

	private $request;

	public function __construct(Request $request){

		$this->request = $request;

	}

	public function addRoute(Route $route){

		$this->routes[$route->getName()] = $route;

	}

	public function getRouteByRequest(){
		
		foreach ($this->routes as $route) {

			if ($route->match($this->request->getUri)) {

				return $route;

			}
		}

	}
}