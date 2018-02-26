<?php

namespace Model;

/**
* Post Manager
*/
class PostManager extends Manager
{
	public function getPost($postId)
	{
		$sqlQuery = "SELECT id, title, intro, content, author, lastWriteDate, comments FROM posts WHERE id = ?"
		$statement = $pdo->prepare($sqlQuery);
		$statement->execute($postId);
		$post = $statement->fetch();
		// A finir	
	}
	public function getLastPosts()
	{
		$sqlQuery = "SELECT title, intro, lastWriteDate FROM posts ORDER BY added_at DESC LIMIT 5"
		$statement = $pdo->prepare($sqlQuery);
		$statement->execute();
		$lastPosts = $statement->fetch();
		// A finir
	}

	public function getPaginatedPosts()
	{
	}
}