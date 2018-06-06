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
		$this->isGranted('user');
		$postManager = $this->getDatabase()->getManager(Post::class);
		$post = $postManager->find($postId);		
		$comment = new Comment();
		$comment->setPost($post);
		$comment->setAuthor($this->request->getSession()['user']->getId());
		$comment->setAddedAt(new \DateTime("now", new \DateTimeZone('Europe/Paris')));
		if ($this->request->getMethod() == "POST" && $comment->hydrate($this->request->getPost())->isValid()) {
			$commentManager = $this->getDatabase()->getManager(Comment::class);
			$commentManager->insert($comment);
			$this->request->addFlashBag('success', 'Votre commentaire a bien été enregistré, il sera vérifié auprès d\'un administrateur avant publication.');
			$this->request->setSession('uncheckedComments', $commentManager->countUncheckedComments());
			return $this->redirect("post", [
				"id" => $postId,
				"page" => 1
			]);
		}
		$commentManager = $this->getDatabase()->getManager(Comment::class);
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
		$this->isGranted('admin');
		$manager = $this->getDatabase()->getManager(Comment::class);
		$comment = $manager->find($id);
		if ($comment && $this->request->getMethod() == "POST" && $comment->hydrate($this->request->getPost(), 1)->isValid()) {
			$manager->update($comment);
			$this->request->addFlashBag('success', 'Le commentaire a bien été mis à jour');
			return $this->redirect("reportedComments", [
				"page" => 1
			]);
		}
		return $this->render("updateComment.html.twig", [
			"comment" => $comment
		]);
	}

	public function deleteComment($id)
	{
		$this->isGranted('admin');
		$commentManager = $this->getDatabase()->getManager(Comment::class);
		$comment = $commentManager->find($id);
		if ($comment) {
			$commentManager->remove($comment);
			$this->request->addFlashBag('success', 'Le commentaire a bien été supprimé !');
			$this->request->setSession('uncheckedComments', $commentManager->countUncheckedComments());
			$reportManager = $this->getDatabase()->getManager(Report::class);
			$this->request->setSession('reportedComments', $reportManager->countReported('comment'));
			return $this->redirect("uncheckedComments", [
				"page" => 1
			]);
		}
		$this->request->addFlashBag('failure', 'Aucun commentaire correspondant à votre demande n\'a été trouvé.');
		return $this->redirect("uncheckedComments", [
			"page" => 1
		]);
	}

	public function likeComment($id)
	{
		$manager = $this->getDatabase()->getManager(Comment::class);
		$comment = $manager->find($id);	
		if ($comment) {
			$comment->addLike();
			$manager->update($comment);
			$this->request->addFlashBag('success', 'Votre like a bien été pris en compte !');
			return $this->redirect("post", [
				"id" => $comment->getPost()->getId(), 
				"page" => 1
			]);
		}
		$this->request->addFlashBag('failure', 'Aucun commentaire correspondant à votre demande n\'a été trouvé.');
		return $this->redirect("post", [
			"id" => $comment->getPostId(), 
			"page" => 1
		]);
	}

	public function checkComment($id)
	{
		$this->isGranted('admin');
		$manager = $this->getDatabase()->getManager(Comment::class);
		$comment = $manager->find($id);	
		if ($comment) {
			$comment->setIsChecked(1);
			$manager->update($comment);
			$this->request->addFlashBag('success', 'Le commentaire a bien été validé !');
			$this->request->setSession('uncheckedComments', $manager->countUncheckedComments());
			return $this->redirect("uncheckedComments", [
	            "page" => 1
	        ]);
		}
		$this->request->addFlashBag('failure', 'Aucun commentaire correspondant à votre demande n\'a été trouvé.');
		return $this->redirect("uncheckedComments", [
			"page" => 1
		]);
	}

	public function reportComment($id, $page = 1)
	{
		$this->isGranted('admin');
		$report = new Report();
		$report->setAddedAt(new \DateTime());
		$report->setType('comment');
		$commentManager = $this->getDatabase()->getManager(Comment::class);
		$comment = $commentManager->find($id);
		$report->setComment($comment);
		if ($this->request->getMethod() == "POST" && $report->hydrate($this->request->getPost())->isValid()) {
			$reportManager = $this->getDatabase()->getManager(Report::class);
			$reportManager->insert($report);
			$this->request->addFlashBag('success', 'Le commentaire a bien été signalé !');
			$this->request->setSession('reportedComments', $reportManager->countReported('comment'));
			return $this->redirect("post", [
				"id" => $comment->getPost()->getId(),
				"page" => $page
			]);
		}
		$postManager = $this->getDatabase()->getManager(Post::class);
		$post = $postManager->find($comment->getPost()->getId());
		$results = $commentManager->getCommentsByPostId($id, $page);
		return $this->render("post.html.twig", [
            "page" => $page,
            "post" => $post,
            "report" => $report,
            "comments" => $results['results'],
            "nbPages" => $results['nbPages']
        ]);
	}

	public function unReportComment($id)
	{
		$this->isGranted('admin');
		$reportManager = $this->getDatabase()->getManager(Report::class);
		$report = $reportManager->find($id);
		if ($report) {
			$reportManager->remove($report);
			$this->request->addFlashBag('success', 'Le signalement a bien été supprimé !');
			$this->request->setSession('reportedComments', $reportManager->countReported('comment'));
			$commentManager = $this->getDatabase()->getManager(Comment::class);
			$this->request->setSession('uncheckedComments', $commentManager->countUncheckedComments());
			return $this->redirect("reportedComments", [
	            "page" => 1
	        ]);		
		}	
		$this->request->addFlashBag('failure', 'Aucun signalement correspondant à votre demande n\'a été trouvé.');
		return $this->redirect("reportedComments", [
			"page" => 1
		]);
	}

	public function showUncheckedComments($page = 1)
	{ 
		$this->isGranted('admin');
		$manager = $this->getDatabase()->getManager(Comment::class);
		$results = $manager->getUncheckedComments($page);
		return $this->render("uncheckedcomments.html.twig", [
            "page" => $page,
            "comments" => $results['results'],
            "nbPages" => $results['nbPages']
        ]);
	}

	public function showReportedComments($page = 1)
	{ 
		$this->isGranted('admin');
		$reportManager = $this->getDatabase()->getManager(Report::class);
		$results = $reportManager->getReported($page, 'comment');
		return $this->render("reportedComments.html.twig", [
            "page" => $page,
            "reports" => $results['results'],
            "nbPages" => $results['nbPages']
        ]);
	}
}