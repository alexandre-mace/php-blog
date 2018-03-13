<?php

namespace App\Router;

use App\Request;

class Router 
{

	private $routes;

	private $request;


	public function __construct(Request $request) 
	{
		$this->request = $request;
	}

	public function addRoute(Route $route)
	{
		if(isset($this->routes[$route->getName()])) {
            throw new RouterException("Cette route existe déjà !");
        }
		$this->routes[$route->getName()] = $route;
	}

	public function getRouteByRequest()
	{	
		foreach ($this->routes as $route) {
			if ($route->match($this->request->getUri())) {
				return $route;
			}
		}
		throw new RouterException("Cette route n'existe pas !");
	}

    public function getRoute($routeName)
    {
        if(isset($this->routes[$routeName])) {
            return $this->routes[$routeName];
        }
        throw new RouterException("Cette route n'existe pas !");
    }

}