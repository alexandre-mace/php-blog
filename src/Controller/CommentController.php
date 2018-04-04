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
		if ($this->verify($this->request->getPost())) {

			$manager = $this->getDatabase()->getManager(Comment::class);
			$comment = new Comment();
			$comment->setPostId($postId);
			$comment->setAuthor($this->request->getPost()['author']);
			$comment->setContent($this->request->getPost()['content']);
			$comment->setAddedAt(new \DateTime());
			$comment->setLikes(0);
			$comment->setIsChecked(0);
			$comment->setIsReported(0);
			$manager->insert($comment);	
			$this->request->addFlashBag('success', 'Votre commentaire a bien été enregistré, il sera vérifié auprès d\'un administrateur avant publication.');
			return $this->redirect("post", [
				"id" => $comment->getPostId(),
				"page" => 1
			]);
		}
		$this->request->addFlashBag('failure', 'L\'ajout de votre commentaire a échoué, veuillez remplir tous les champs.');
		return $this->redirect("post", [
			"id" => $postId,
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
		return $this->render("comments.html.twig", [
            "page" => $page,
            "comments" => $results['results'],
            "nbPages" => $results['nbPages']
        ]);
	}

	public function showReportedComments($page = 1)
	{ 
		$manager = $this->getDatabase()->getManager(Comment::class);
		$results = $manager->getReportedComments($page);
		return $this->render("reportedComments.html.twig", [
            "page" => $page,
            "comments" => $results['results'],
            "nbPages" => $results['nbPages']
        ]);
	}
	
	public function checkComment($id)
	{
		$manager = $this->getDatabase()->getManager(Comment::class);
		$comment = $manager->find($id);	
		$comment->setIsChecked(1);
		$manager->update($comment);
		$this->request->setSession('uncheckedComments', $manager->countUncheckedComments());
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
		$this->request->setSession('reportedComments', $manager->countReportedComments());
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
		$this->request->setSession('reportedComments', $manager->countReportedComments());
		return $this->redirect("reportedComments", [
            "page" => 1
        ]);		
	}
}