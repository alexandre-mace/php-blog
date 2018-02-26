<?php

namespace App;

use App\Response\JsonResponse;
use App\Response\RedirectResponse;
use App\Response\Response;
use App\Router\Router;
use App\Database;

class Controller
{
	private $request;

	private $router;

	private $twig;

	private $database;


	public function __construct(Request $request, Router $router)
	{
		$this->request = $request;
		$this->router = $router;
		$this->database = Database::getInstance();
		$loader = new Twig_Loader_Filesystem('../src/View/');
		$this->twig = new Twig_Environment($loader, array(
		    'cache' => false
		));
	}

	protected function getDatabase()
	{
		return $this->database;
	}

	protected function redirect($routeName, $args = [])
	{
		$route = $this->router->getRoute($routeName);
		$url = $route->generateUrl($args);
		return new RedirectResponse($url);
	}

	protected function render($view, $data)
	{
		$view = $this->twig->load($filename);
		$content = $this->twig->render($view, $data);
		return new Response($content);
	}

	protected function json($data)
	{
		return JsonResponse($data);
	}
}