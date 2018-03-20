<?php

namespace Controller;

use App\Controller;
use Model\Comment;

/**
* ¨CommentController
*/
class CommentController extends Controller
{
	
	public function addComment($postId)
	{
		$manager = $this->getDatabase()->getManager(Comment::class);
		$comment = new Comment();
		$comment->setPostId($postId);
		$comment->setAuthor($_POST['author']);
		$comment->setContent($_POST['content']);
		$comment->setAddedAt(new \DateTime());
		$manager->insert($comment);		
		return $this->redirect("post", [
			"id" => $comment->getPostId(),
			"page" => 1
		]);
	}

	public function updateComment($id)
	{
		$manager = $this->getDatabase()->getManager(Comment::class);
		$comment = $manager->find($id);
		$manager->update($comment);
		return $this->redirect("post", [
			"id" => $comment->getPostId(),
			"page" => 1
		]);
	}

	public function deleteComment($id)
	{
		$manager = $this->getDatabase()->getManager(Comment::class);
		$comment = $manager->find($id);
		$manager->remove($comment);
		return $this->redirect("comments", [
			"page" => 1
		]);
	}

	public function showUncheckedComments($page = 1)
	{ 
		$manager = $this->getDatabase()->getManager(Comment::class);
		$results = $manager->getUncheckedComments($page);
		$comments = $results['results'];
		$nbPages = $results['nbPages'];
		return $this->render("comments.html.twig", [
            "comments" => $comments,
            "page" => $page,
            "nbPages" => $nbPages
        ]);
	}

	public function checkComment($commentId)
	{
		$manager = $this->getDatabase()->getManager(Comment::class);
		$comment = $manager->find($commentId);	
		$comment->setIsChecked(1);
		$manager->update($comment);
		var_dump($comment);
		return $this->redirect("comments", [
            "page" => 1
        ]);
	}
}