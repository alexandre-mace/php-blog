<?php

namespace App;

class Database 
{

	private $pdo;


	public function __construct()
	{
		$this->pdo = new PDO("mysql:dbname=$db;host=$host", $username, $password); // A modifier
	}

	public function getPdo()
	{
		return $this->pdo;
	}

}