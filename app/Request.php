<?php

namespace App;

class Request 
{

	private $post;

	private $get;

	private $session; 

	private $cookie;

	private $server;

	private $request;


	public function __construct(array $post, array $get, array $session, array $cookie, array $server, array $request)
	{
		$this->post = $post;
		$this->get = $get;
		$this->session = $session;
		$this->cookie = $cookie;
		$this->server = $server;
		$this->request = $request;
	}

	public static function createFromGlobals() 
	{
		session_start();
		return new Request($_POST, $_GET, $_SESSION, $_COOKIE, $_SERVER, $_REQUEST);
	}

	public function getPost($key = NULL)
	{
		if ($key != NULL) {
			return $this->post[$key];
		}
		return $this->post;
	}

	public function getGet()
	{
		return $this->get;
	}

	public function getSession()
	{
		return $_SESSION;
	}

	public function setSession($key, $value)
	{
		$_SESSION[$key] = $value;
	}

	public function getFlashBag($type) 
	{ 
		return array_shift($_SESSION['flashBag' ][$type]);
	}

	public function addFlashBag($type, $value)
	{
		$_SESSION['flashBag'][$type][] = $value;	
	}
	
	public function getCookie()
	{
		return $this->cookie;
	}

	public function getServer() 
	{
		return $this->server;
	}

	public function getMethod()
	{
		return $this->server["REQUEST_METHOD"];
	}
	
	public function getRequest()
	{
		return $this->request;
	}

    public function getEnv($key)
    {
        return getenv($key);
    }
    
	public function getUri()
	{
		return $this->server["REQUEST_URI"];
	}

}