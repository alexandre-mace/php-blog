<?php

namespace App\Response;

/**
* Return a response with json data type
*/
class JsonResponse
{

	private $data;


	public function __construct($data)
	{
		$this->data = $data;
	}

	public function send()
	{
		echo json_encode($this->data);
	}

}