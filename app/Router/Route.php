<?php

namespace App\Router;

use App\Request;

Class Route 
{

	private $name;

	private $path;

	private $parameters;

	private $controller;

	private $action;


	public function __construct($name, $path, array $parameters, $controller, $action)
	{
		$this->name = $name;
		$this->path = $path;
		$this->parameters = $parameters;
		$this->controller = $controller;
		$this->action = $action;
	}

	public function getName()
	{
		return $this->name;
	}

	public function getPath()
	{
		return $this->path;
	}

	public function getParameters()
	{
		return $this->parameters;
	}

	public function getController()
	{
		return $this->controller;
	}

	public function getAction()
	{
		return $this->action;
	}
 
	public function call(Request $request, Router $router)
	{
		$controller = $this->controller;
        $controller = new $controller($request, $router);
        return call_user_func_array([$controller, $this->action], $this->parameters);
	}

}