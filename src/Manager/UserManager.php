<?php

namespace Manager;

use App\Manager;
use Model\User;

/**
* User Manager
*/
class UserManager extends Manager
{
	public function getUncheckedUsers($page)
	{
		$sqlQuery = "SELECT * FROM users WHERE is_checked != 1";
		$statement = $this->pdo->query($sqlQuery);
		$nbComments = $statement->rowCount();
		$nbPages = ceil($nbComments / 10);
        $start = ($page-1)*10;
		$sqlQuery = "SELECT * FROM users WHERE is_checked != 1 ORDER BY added_at DESC LIMIT $start, 10";
		$statement = $this->pdo->prepare($sqlQuery);
		$statement->execute();
		$results = $statement->fetchAll(\PDO::FETCH_ASSOC);
		array_walk($results, function(&$user) {
			$user = (new User())->hydrate($user);
		});
		$arrayReturned = array('nbPages' => $nbPages, 'results' => $results);
		return $arrayReturned;
	}
	public function countUncheckedUsers()
	{
		$sqlQuery = "SELECT * FROM users WHERE is_checked = 0";
		$statement = $this->pdo->query($sqlQuery);
		$nbUsers = $statement->rowCount();
		return $nbUsers;
	}
}