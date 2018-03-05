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
		$this->routes[$route->getName()] = $route;
	}

	public function getRouteByRequest()
	{	
		foreach ($this->routes as $route) {
			if ($route->match($this->request->getUri())) {
				return $route;
			}
		}
	}

    public function getRoute($routeName)
    {
        if(isset($this->routes[$routeName])) {
            return $this->routes[$routeName];
        }
    }

}