<?php

namespace Controller;

use App\Controller;
use Model\Comment;
use Model\Post;
use Model\Report;

/**
* ¨CommentController
*/
class CommentController extends Controller
{
	public function addComment($postId, $page = 1)
	{
		$comment = new Comment();
		$comment->setPostId($postId);
		$comment->setAddedAt(new \DateTime());
		if ($this->request->getMethod() == "POST" && $comment->hydrate($this->request->getPost())->isValid()) {
			$manager = $this->getDatabase()->getManager(Comment::class);
			$manager->insert($comment);
			$this->request->addFlashBag('success', 'Votre commentaire a bien été enregistré, il sera vérifié auprès d\'un administrateur avant publication.');
			return $this->redirect("post", [
				"id" => $comment->getPostId(),
				"page" => 1
			]);
		}
		$postManager = $this->getDatabase()->getManager(Post::class);
		$commentManager = $this->getDatabase()->getManager(Comment::class);
		$post = $postManager->find($postId);
		$results = $commentManager->getCommentsByPostId($postId, $page);
		return $this->render("post.html.twig", [
			"post" => $post,
			"comment" => $comment,
            "comments" => $results['results'],
            "nbPages" => $results['nbPages'],
            "page" => 1,
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
		$commentManager = $this->getDatabase()->getManager(Comment::class);
		$reportManager = $this->getDatabase()->getManager(Report::class);
		$reports = $reportManager->getFoosByBar('reports', 'comment_id', $id);
		foreach ($reports as $key => $report) {
			$reportManager->remove($report);
		}
		$comment = $commentManager->find($id);
		$commentManager->remove($comment);
		$this->request->addFlashBag('success', 'Le commentaire a bien été supprimé !');
		$this->request->setSession('uncheckedComments', $commentManager->countUncheckedComments());
		$this->request->setSession('reportedComments', $reportManager->countReported('comment'));
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
		$reportManager = $this->getDatabase()->getManager(Report::class);
		$commentManager = $this->getDatabase()->getManager(Comment::class);
		$results = $reportManager->getReported($page, 'comment');
		var_dump($results['results']);
		foreach ($results['results'] as $key => $comment) {
			$comments[] = $commentManager->find($comment->getCommentId());
		}
		return $this->render("reportedPosts.html.twig", [
            "page" => $page,
            "comments" => $comments,
            "reports" => $results['results'],
            "nbPages" => $results['nbPages']
        ]);
	}

	public function likeComment($id)
	{
		$manager = $this->getDatabase()->getManager(Comment::class);
		$comment = $manager->find($id);	
		$comment->addLike();
		$manager->update($comment);
		$this->request->addFlashBag('success', 'Votre like a bien été pris en compte !');
		return $this->redirect("post", [
			"id" => $comment->getPostId(),
			"page" => 1
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
	public function reportCommment($id, $page = 1)
	{
		$report = new Report();
		$report->setAddedAt(new \DateTime());
		$report->setType('comment');
		$report->setCommentId($id);
		if ($this->request->getMethod() == "POST" && $report->hydrate($this->request->getPost())->isValid()) {
			$reportManager = $this->getDatabase()->getManager(Report::class);
			$reportManager->insert($report);
			$this->request->addFlashBag('success', 'Le commentaire a bien été signalé !');
			$this->request->setSession('reportedPosts', $reportManager->countReported('comment'));
			return $this->redirect("post", [
				"id" => $id,
				"page" => $page
			]);
		}
		$postManager = $this->getDatabase()->getManager(Post::class);
		$commentManager = $this->getDatabase()->getManager(Comment::class);
		$post = $postManager->find($id);
		$results = $commentManager->getCommentsByPostId($id, $page);
		return $this->render("post.html.twig", [
            "page" => $page,
            "post" => $post,
            "report" =>$report,
            "comments" => $results['results'],
            "nbPages" => $results['nbPages']
        ]);
	}

	public function unReportComment($id)
	{
		$reportManager = $this->getDatabase()->getManager(Report::class);
		$report = $reportManager->find($id);	
		$reportManager->remove($report);
		$this->request->setSession('reportedPosts', $reportManager->countReported('post'));
		return $this->redirect("reportedComments", [
            "page" => 1
        ]);		
	}
}