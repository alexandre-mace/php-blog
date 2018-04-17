<?php

namespace Manager;

use App\Manager;
use Model\Comment;

/**
* Comment Manager
*/
class CommentManager extends Manager
{
	
	public function getCommentsByPostId($postId, $page)
	{
		$sqlQuery = "SELECT * FROM comments WHERE post_id = " .$postId. " AND is_checked = 1";
		$statement = $this->pdo->query($sqlQuery);
		$nbComments = $statement->rowCount();
		$nbPages = ceil($nbComments / 10);
        $start = ($page-1)*10;
		$sqlQuery = "SELECT * FROM comments WHERE post_id = ? AND is_checked = 1 ORDER BY added_at DESC LIMIT $start, 10";
		$statement = $this->pdo->prepare($sqlQuery);
		$statement->execute(array($postId));
		$results = $statement->fetchAll(\PDO::FETCH_ASSOC);
		array_walk($results, function(&$comment) {
			$comment = (new Comment())->hydrate($comment);
		});
		$arrayReturned = array('nbPages' => $nbPages, 'results' => $results);
		return $arrayReturned;
	}

	public function getUncheckedComments($page)
	{
		$sqlQuery = "SELECT * FROM comments WHERE is_checked != 1";
		$statement = $this->pdo->query($sqlQuery);
		$nbComments = $statement->rowCount();
		$nbPages = ceil($nbComments / 10);
        $start = ($page-1)*10;
		$sqlQuery = "SELECT * FROM comments WHERE is_checked != 1 ORDER BY added_at DESC LIMIT $start, 10";
		$statement = $this->pdo->prepare($sqlQuery);
		$statement->execute();
		$results = $statement->fetchAll(\PDO::FETCH_ASSOC);
		array_walk($results, function(&$comment) {
			$comment = (new Comment())->hydrate($comment);
		});
		$arrayReturned = array('nbPages' => $nbPages, 'results' => $results);
		return $arrayReturned;
	}
	
	public function countUncheckedComments()
	{
		$sqlQuery = "SELECT * FROM comments WHERE is_checked = 0";
		$statement = $this->pdo->query($sqlQuery);
		$nbComments = $statement->rowCount();
		return $nbComments;
	}
}