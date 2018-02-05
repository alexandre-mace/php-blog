<?php

namespace App;

/**
* Main Manager
*/
class Manager
{
	
	private $pdo;


	public function __construct($pdo)
	{
		$this->pdo = $pdo;
	}

	public function add()
	{

	}

	public function update()
	{

	}

	public function delete($id, $table)
	{
		$req = $pdo->prepare('DELETE FROM ' .$table. ' WHERE id = ?');
		$req->execute(array($id));
	}
}