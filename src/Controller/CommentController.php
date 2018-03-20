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

	public function showReportedComments($page = 1)
	{ 
		$manager = $this->getDatabase()->getManager(Comment::class);
		$results = $manager->getReportedComments($page);
		$comments = $results['results'];
		$nbPages = $results['nbPages'];
		return $this->render("reportedComments.html.twig", [
            "comments" => $comments,
            "page" => $page,
            "nbPages" => $nbPages
        ]);
	}
	
	public function checkComment($id)
	{
		$manager = $this->getDatabase()->getManager(Comment::class);
		$comment = $manager->find($id);	
		$comment->setIsChecked(1);
		$manager->update($comment);
		return $this->redirect("comments", [
            "page" => 1
        ]);
	}

	public function reportComment($id)
	{
		$manager = $this->getDatabase()->getManager(Comment::class);
		$comment = $manager->find($id);	
		$comment->setIsReported(1);
		$manager->update($comment);
		return $this->redirect("reportedComments", [
            "page" => 1
        ]);		
	}
	public function unReportComment($id)
	{
		$manager = $this->getDatabase()->getManager(Comment::class);
		$comment = $manager->find($id);	
		$comment->setIsReported(0);
		$manager->update($comment);
		return $this->redirect("reportedComments", [
            "page" => 1
        ]);		
	}
}