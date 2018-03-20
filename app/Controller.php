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

	protected $twig;

	private $database;


	public function __construct(Request $request, Router $router)
	{
		$this->request = $request;
		$this->router = $router;
		$this->database = Database::getInstance();
		$loader = new \Twig_Loader_Filesystem('../src/View/');
		$this->twig = new \Twig_Environment($loader, array(
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

	protected function render($filename, $data = [])
	{
		$this->twig->addGlobal('session', $_SESSION);
		$view = $this->twig->load($filename);
		$content = $view->render($data);
		return new Response($content);
	}

	protected function json($data)
	{
		return JsonResponse($data);
	}
}