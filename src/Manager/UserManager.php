<?php

namespace Manager;

use App\Manager;
use Model\User;

/**
* User Manager
*/
class UserManager extends Manager
{
	public function getUser($userId)
	{
		$sqlQuery = "SELECT * FROM users WHERE id = ?";
		$statement = $this->pdo->prepare($sqlQuery);
		$statement->execute(array($userId));
		$user = $statement->fetch();
		return $user;
	}
	public function isValid($id, $password)
	{
		$array = [
			'id' => $id,
			'password' => $password
		];
		$sqlQuery = "SELECT * FROM users WHERE id = :id AND password = :password";
		$statement = $this->pdo->prepare($sqlQuery);
		$statement->execute($array);
		$user = $statement->fetch();
		return $user;
	}
}