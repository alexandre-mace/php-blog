<?php

namespace App;

class Response
{

	private $content;


	public function __construct($content)
	{

		$this->content = $content;		

	}

	public function send()
	{

		echo $this->content;

	}

}