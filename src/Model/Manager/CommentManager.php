<?php

namespace Model;

/**
* Comment Manager
*/
class CommentManager extends Manager
{
	
	public function getComments($postId)
	{
		$req = $pdo->prepare('SELECT id, author, date, content FROM comments WHERE post_id = ? ORDER BY date DESC');
		$req->execute($postId);
		$comments = $req->fetch();
		return $comments;		
	}
}