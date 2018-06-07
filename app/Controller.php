<?php

namespace App;

use App\Response\JsonResponse;
use App\Response\RedirectResponse;
use App\Response\Response;
use App\Router\Router;
use App\Database;

class Controller
{
	
	protected $request;

	protected $router;

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
		$this->twig->addGlobal('session', $this->request->getSession());
		$this->twig->addGlobal('request', $this->request);
		$view = $this->twig->load($filename);
		$content = $view->render($data);
		return new Response($content);
	}

	protected function json($data)
	{
		return JsonResponse($data);
	}

	protected function verify($array)
	{
		foreach ($array as $key => $value) {
			if (!isset($value) OR empty(trim($value))) {
				return false;
			}
		}
		return true;
	}

	protected function isGranted($role)
	{
		if (!empty($this->request->getSession('user')) and !$this->request->getSession()['user']->getIsAdmin() and $role == 'admin') {
			throw new \Exception("Vous n'avez pas les autorisations nécessaires pour accéder à cette page.");		
		}
		if (empty($this->request->getSession('user'))) {
			$this->redirect("auth", [])->send();
		}
	}
	protected function csrf()
	{
		if ($this->request->getMethod() == 'POST') {
			if (!hash_equals($this->request->getSession('csrf')['csrf'], $this->request->getPost('csrf'))) {
				var_dump($this->request->getSession('csrf')['csrf']);
				var_dump($this->request->getPost('csrf'));
				throw new \Exception("CSRF Token failed.");
			}
			return;
		}
		$this->request->setSession('key', bin2hex(random_bytes(32)));
		$csrf = hash_hmac('md5', 'this is some string', $this->request->getSession('key')['key']);
		$this->request->setSession('csrf', $csrf);
	}
}