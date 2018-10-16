<?php

namespace Manager;

use App\Manager;
use Model\Post;

/**
* Post Manager
*/
class PostManager extends Manager
{
	public function getPost($postId)
	{
		$sqlQuery = "SELECT * FROM posts WHERE id = ?";
		$statement = $this->pdo->prepare($sqlQuery);
		$statement->execute($postId);
		$post = $statement->fetch();
		return $post;
	}
	public function getLastPosts()
	{
		$sqlQuery = "SELECT * FROM posts ORDER BY added_at DESC LIMIT 5";
		$statement = $this->pdo->prepare($sqlQuery);
		$statement->execute();
		$lastPosts = $statement->fetchAll();
		return $lastPosts;
	}

	public function getPaginatedPosts($page)
	{
		$sqlQuery = "SELECT * FROM posts";
		$statement = $this->pdo->query($sqlQuery);
		$nbPosts = $statement->rowCount();
		$nbPages = ceil($nbPosts / 10);
        $start = ($page-1)*10;
		$sqlQuery = "SELECT * FROM posts ORDER BY added_at DESC LIMIT $start, 10";
		$statement = $this->pdo->prepare($sqlQuery);
		$statement->execute();
		$results = $statement->fetchAll(\PDO::FETCH_ASSOC);
		array_walk($results, function(&$post) {
			$post = (new Post())->hydrate($post);
		});
		$arrayReturned = array('nbPages' => $nbPages, 'results' => $results);
		return $arrayReturned;
	}
}