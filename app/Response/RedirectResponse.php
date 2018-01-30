<?php

namespace App\Response;

/**
* Return a redirection
*/
class RedirectResponse
{

	private $url;


	public function __construct($url)
	{
		$this->url = $url;
	}

	public function send()
	{
		header(sprintf("location: %s", $this->url));
	}

}