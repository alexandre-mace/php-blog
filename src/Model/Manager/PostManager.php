<?php

namespace Model;

/**
* Post Manager
*/
class PostManager extends Manager
{
	
	public function getPost($postId)
	{
		$req = $pdo->prepare('SELECT id, title, intro, content, author, lastWriteDate, comments FROM posts WHERE id = ?');
		$req->execute(array($postId));
		$post = $req->fetch();
		return $post;
	}

	public function getPosts()
	{
		$req = $pdo->query('SELECT id, title, intro, lastWriteDate FROM posts ORDER BY creation_date DESC');
		$posts = $req->fetch();
		return $posts;
	}
}