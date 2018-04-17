<?php

namespace Controller;

use App\Controller;
use Model\Post;
use Model\Comment;
use Model\Report;

/**
* ¨PostController
*/
class PostController extends Controller
{

	public function showPost($id, $page = 1)
	{
		$postManager = $this->getDatabase()->getManager(Post::class);
		$commentManager = $this->getDatabase()->getManager(Comment::class);
		$post = $postManager->find($id);
		$results = $commentManager->getCommentsByPostId($id, $page);
		return $this->render("post.html.twig", [
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
		$reportManager = $this->getDatabase()->getManager(Report::class);
		$postManager = $this->getDatabase()->getManager(Post::class);
		$results = $reportManager->getReported($page, 'post');
		foreach ($results['results'] as $key => $post) {
			$posts[] = $postManager->find($post->getPostId());
		}
		return $this->render("reportedPosts.html.twig", [
            "page" => $page,
            "posts" => $posts,
            "reports" => $results['results'],
            "nbPages" => $results['nbPages']
        ]);
	}
	
	public function addPost()
	{
		$post = new Post();
		$post->setAddedAt(new \DateTime());
		$post->setLastWriteDate(new \DateTime());
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
			"post" => $post
		]);
	}

	public function updatePost($id)
	{
		$manager = $this->getDatabase()->getManager(Post::class);
		$post = $manager->find($id);
		if ($post && $this->request->getMethod() == "POST" && $post->hydrate($this->request->getPost())->isValid()) {
			$post->setLastWriteDate(new \DateTime());
			var_dump($post);
			$manager->update($post);
			$this->request->addFlashBag('success', 'Le post a bien été mis à jour');
			return $this->redirect("post", [
				"id" => $post->getId(),
				"page" => 1
			]);
		}
		return $this->render("updatePost.html.twig", [
			"post" => $post
		]);
	}

	public function deletePost($id)
	{
		$postManager = $this->getDatabase()->getManager(Post::class);
		$commentManager = $this->getDatabase()->getManager(Comment::class);
		$reportManager = $this->getDatabase()->getManager(Report::class);
		$reports = $reportManager->getFoosByBar('reports', 'post_id', $id);
		$comments = $commentManager->getFoosByBar('comments', 'post_id', $id);
		foreach ($reports as $key => $report) {
			$reportManager->remove($report);
		}
		foreach ($comments as $key => $comment) {
			$commentManager->remove($comment);
		}
		$post = $postManager->find($id);
		$postManager->remove($post);
		$this->request->addFlashBag('success', 'Le post a bien été supprimé !');
		return $this->redirect("posts", [
			"page" => 1
		]);
	}

	public function likePost($id)
	{
		$manager = $this->getDatabase()->getManager(Post::class);
		$post = $manager->find($id);	
		$post->addLike();
		$manager->update($post);
		$this->request->addFlashBag('success', 'Votre like a bien été pris en compte !');
		return $this->redirect("post", [
			"id" => $post->getId(),
			"page" => 1
		]);
	}

	public function reportPost($id, $page = 1)
	{
		$report = new Report();
		$report->setAddedAt(new \DateTime());
		$report->setType('post');
		$report->setPostId($id);
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

	public function unReportPost($id)
	{
		$reportManager = $this->getDatabase()->getManager(Report::class);
		$report = $reportManager->find($id);	
		$reportManager->remove($report);
		$this->request->setSession('reportedPosts', $reportManager->countReported('post'));
		return $this->redirect("reportedPosts", [
            "page" => 1
        ]);		
	}
}