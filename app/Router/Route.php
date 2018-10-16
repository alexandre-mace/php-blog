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

	private $args;


	public function __construct($name, $path, array $parameters, $controller, $action)
	{
		$this->name = $name;
		$this->path = $path;
		$this->parameters = $parameters;
		$this->controller = $controller;
		$this->action = $action;
	}

	public function call(Request $request, Router $router)
	{
		$controller = $this->controller;
        $controller = new $controller($request, $router);
        return call_user_func_array([$controller, $this->action], $this->args);
	}

	public function match($requestUri)
	{
		$path = preg_replace_callback("/:(\w+)/", [$this, "parameterMatch"], $this->path);
		$path = str_replace("/", "\/", $path);

		if (preg_match("/^$path$/i", $requestUri, $matches)) {
			$this->args = array_slice($matches, 1);
			return true;
		}
		return false;
	}

	private function parameterMatch($match)
    {
        if (isset($this->parameters[$match[1]])) {
            return sprintf("(%s)", $this->parameters[$match[1]]);
        }
        return '([^/]+)';
    }

	public function generateUrl($args)
	{
		$url = str_replace(array_keys($args), $args, $this->path);
		$url = str_replace(":", "", $url);
		return $url;
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
 
}