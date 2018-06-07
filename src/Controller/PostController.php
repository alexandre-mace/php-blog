<?php

namespace Controller;

use App\Controller;
use Model\Post;
use Model\Comment;
use Model\Report;

/**
*  ¨PostController
*/
class PostController extends Controller
{
	
	public function addPost()
	{
		$this->csrf();
		$this->isGranted('admin');
		$post = new Post();
		$post->setAddedAt(new \DateTime());
		$post->setLastWriteDate(new \DateTime("now", new \DateTimeZone('Europe/Paris')));
		$post->setAuthor($this->request->getSession()['user']->getId());
		if ($this->request->getMethod() == "POST" && $post->hydrate($this->request->getPost())->isValid()) {
			$manager = $this->getDatabase()->getManager(Post::class);
			$manager->insert($post);
			$this->request->addFlashBag('success', 'Votre post a bien été ajouté !');
			return $this->redirect("post", [
				"id" => $post->getId(),
				"page" => 1
			]);
		}
		return $this->render("addPost.html.twig", [
			"csrf" => $this->request->getSession('csrf')['csrf'],
			"post" => $post
		]);
	}

	public function updatePost($id)
	{
		$this->csrf();
		$this->isGranted('admin');
		$manager = $this->getDatabase()->getManager(Post::class);
		$post = $manager->find($id);
		if ($post && $this->request->getMethod() == "POST" && $post->hydrate($this->request->getPost(), 1)->isValid()) {
			$post->setLastWriteDate(new \DateTime("now", new \DateTimeZone('Europe/Paris')));
			$manager->update($post);
			$this->request->addFlashBag('success', 'Le post a bien été mis à jour');
			return $this->redirect("post", [
				"id" => $post->getId(),
				"page" => 1
			]);
		}
		return $this->render("updatePost.html.twig", [
			"csrf" => $this->request->getSession('csrf')['csrf'],
			"post" => $post
		]);
	}

	public function deletePost($id)
	{
		$this->isGranted('admin');
		$postManager = $this->getDatabase()->getManager(Post::class);
		$post = $postManager->find($id);
		if ($post) {
			$postManager->remove($post);
			$this->request->addFlashBag('success', 'Le post a bien été supprimé !');
			$reportManager = $this->getDatabase()->getManager(Report::class);
			$this->request->setSession('reportedPosts', $reportManager->countReported('post'));
			return $this->redirect("posts", [
				"page" => 1
			]);
		}
		$this->request->addFlashBag('failure', 'Aucun post correspondant à votre demande n\'a été trouvé.');
		return $this->redirect("posts", [
			"page" => 1
		]);
	}

	public function likePost($id)
	{
		$manager = $this->getDatabase()->getManager(Post::class);
		$post = $manager->find($id);	
		if ($post) {
			$post->addLike();
			$manager->update($post);
			$this->request->addFlashBag('success', 'Votre like a bien été pris en compte !');
			return $this->redirect("post", [
				"id" => $post->getId(), 
				"page" => 1
			]);
		}
		$this->request->addFlashBag('failure', 'Aucun post correspondant à votre demande n\'a été trouvé.');
		return $this->redirect("post", [
			"id" => $post->getId(), 
			"page" => 1
		]);
	}

	public function reportPost($id, $page = 1)
	{
		$this->csrf();
		$report = new Report();
		$report->setAddedAt(new \DateTime());
		$report->setType('post');
		$postManager = $this->getDatabase()->getManager(Post::class);
		$post = $postManager->find($id);
		$report->setPost($post);
		if ($this->request->getMethod() == "POST" && $report->hydrate($this->request->getPost())->isValid()) {
			$reportManager = $this->getDatabase()->getManager(Report::class);
			$reportManager->insert($report);
			$this->request->addFlashBag('success', 'Le post a bien été signalé !');
			$this->request->setSession('reportedPosts', $reportManager->countReported('post'));
			return $this->redirect("post", [
				"id" => $id,
				"page" => 1
			]);
		}
		$commentManager = $this->getDatabase()->getManager(Comment::class);
		$results = $commentManager->getCommentsByPostId($id, $page);
		return $this->render("post.html.twig", [
			"csrf" => $this->request->getSession('csrf')['csrf'],
            "page" => $page,
            "post" => $post,
            "report" => $report,
            "comments" => $results['results'],
            "nbPages" => $results['nbPages']
        ]);
	}

	public function unReportPost($id)
	{	
		$this->isGranted('admin');
		$reportManager = $this->getDatabase()->getManager(Report::class);
		$report = $reportManager->find($id);
		if ($report) {
			$reportManager->remove($report);
			$this->request->addFlashBag('success', 'Le signalement a bien été supprimé !');
			$this->request->setSession('reportedPosts', $reportManager->countReported('post'));
			return $this->redirect("reportedPosts", [
	            "page" => 1
	        ]);		
		}	
		$this->request->addFlashBag('failure', 'Aucun signalement correspondant à votre demande n\'a été trouvé.');
		return $this->redirect("reportedPosts", [
			"page" => 1
		]);
	}

	public function showLastPosts()
	{
		$manager = $this->getDatabase()->getManager(Post::class);
		$lastPosts = $manager->getLastPosts();
		return $this->render("index.html.twig", [
            "lastPosts" => $lastPosts,
        ]);
	}

	public function showPost($id, $page = 1)
	{
		$this->csrf();
		$postManager = $this->getDatabase()->getManager(Post::class);
		$commentManager = $this->getDatabase()->getManager(Comment::class);
		$post = $postManager->find($id);
		$results = $commentManager->getCommentsByPostId($id, $page);
		return $this->render("post.html.twig", [
			"csrf" => $this->request->getSession('csrf')['csrf'],
            "page" => $page,
            "post" => $post,
            "comments" => $results['results'],
            "nbPages" => $results['nbPages']
        ]);
	}

	public function showPaginatedPosts($page = 1)
	{ 
		$manager = $this->getDatabase()->getManager(Post::class);
		$results = $manager->getPaginatedPosts($page);
		return $this->render("posts.html.twig", [
            "page" => $page,
            "posts" => $results['results'],
            "nbPages" => $results['nbPages']
        ]);
	}

	public function showReportedPosts($page = 1)
	{ 
		$this->isGranted('admin');
		$reportManager = $this->getDatabase()->getManager(Report::class);
		$results = $reportManager->getReported($page, 'post');
		return $this->render("reportedPosts.html.twig", [
            "page" => $page,
            "reports" => $results['results'],
            "nbPages" => $results['nbPages']
        ]);
	}
}