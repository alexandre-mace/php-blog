<?php

namespace App;

Class Request {

	private $post;

	private $get;

	private $session; 

	private $cookie;

	private $server;


	public function __construct(array $post, array $get, array $session, array $cookie, array $server) {

		$this->post = $post;
		$this->get = $get;
		$this->session = $session;
		$this->cookie = $cookie;
		$this->server = $server;

	}

	public static function createFromGlobals {

		session_start();
		return new Request($_POST, $_GET, $_SESSION, $_COOKIE, $_SERVER);

	}

	public function getPost() {

		return $this->post;

	}

	public function getGet() {

		return $this->get;

	}

	public function getSession() {

		return $this->session;

	}

	public function getCookie() {

		return $this->cookie;

	}

	public function getServer() {

		return $this->server;

	}

	public function getUri {

		return $this->server["REQUEST_URI"];
	}

}