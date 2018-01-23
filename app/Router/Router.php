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

	public function loadRoutes()
	{
		// Chargement automatique de toutes les routes du projet
	}

	public function addRoute(Route $route)
	{
		$this->routes[$route->getName()] = $route;
	}

	public function getRouteByRequest() // A modifier
	{	
		foreach ($this->routes as $route)
		{
			if ($route->path == $this->request->getUri)) 
			{
				return $route;
			}
		}
	}

}