<?php

namespace App;

class Controller
{

	private $request;

	private $router;

	private $twig;


	public function __construct(Request $request, Router $router)
	{
		$this->request = $request;
		$this->router = $router;

		$loader = new Twig_Loader_Filesystem('../src/View/');
		$this->twig = new Twig_Environment($loader, array(
		    'cache' => false
		));
	}

	protected function render($view, $data)
	{
		$content = $this->twig->render($view, $data);
		return new Response($content);
	}

}