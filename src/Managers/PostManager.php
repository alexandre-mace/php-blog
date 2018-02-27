<?php

namespace Model;

use App\Manager;

/**
* Post Manager
*/
class PostManager extends Manager
{
	public function getPost($postId)
	{
		$sqlQuery = "SELECT id, title, intro, content, author, lastWriteDate, comments FROM posts WHERE id = ?";
		$statement = $this->pdo->prepare($sqlQuery);
		$statement->execute($postId);
		$post = $statement->fetch();
		return $post;
	}
	public function getLastPosts()
	{
		$sqlQuery = "SELECT title, intro, lastWriteDate FROM posts ORDER BY added_at DESC LIMIT 5";
		$statement = $this->pdo->prepare($sqlQuery);
		$statement->execute();
		$lastPosts = $statement->fetchAll();
		return $lastPosts;
	}

	public function getPaginatedPosts($page)
	{
		$sqlQuery = "SELECT * FROM posts ORDER BY added_at LIMIT $start, 10";
		$statement = $this->pdo->prepare($sqlQuery);
		$statement->execute();
		$results = $statement->fetchAll(\PDO::FETCH_ASSOC);
		array_walk($results, function(&$post)) {
			$post = (new Foo())->hydrate($post);
		}
		return $results;
	}
}