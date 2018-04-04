<?php

namespace Controller;

use App\Controller;
use Model\Post;
use Model\Comment;

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
		$manager = $this->getDatabase()->getManager(Post::class);
		$results = $manager->getReportedPosts($page);
		return $this->render("reportedPosts.html.twig", [
            "page" => $page,
            "posts" => $results['results'],
            "nbPages" => $results['nbPages']
        ]);
	}
	
	public function addPost()
	{
		if ($this->verify($this->request->getPost())) {

			$manager = $this->getDatabase()->getManager(Post::class);
			$post = new Post();
			$post->setAddedAt(new \DateTime());
			$post->setTitle($this->request->getPost()['title']);
			$post->setIntro($this->request->getPost()['introduction']);
			$post->setContent($this->request->getPost()['content']);
			$post->setAuthor($this->request->getSession()['user']->getId());
			$manager->insert($post);
			$this->request->addFlashBag('success', 'Votre post a bien été ajouté !');
			return $this->redirect("post", [
				"id" => $post->getId(),
				"page" => 1
			]);
		}
		$this->request->addFlashBag('failure', 'L\'ajout de votre post a échoué, veuillez remplir tous les champs.');
		return $this->redirect("addPostPage", [
		]);
	}

	public function updatePost($id)
	{
		$manager = $this->getDatabase()->getManager(Post::class);
		$post = $manager->find($id);
		$post->setTitle("test update");
		$post->setLastWriteDate(new \DateTime());
		$manager->update($post);
		return $this->redirect("post", ["id" => $post->getId()]);
	}

	public function deletePost($id)
	{
		$manager = $this->getDatabase()->getManager(Post::class);
		$post = $manager->find($id);
		$manager->remove($post);
		return $this->redirect("posts", ["page" => 1]);
	}

	public function likePost($id)
	{
		$manager = $this->getDatabase()->getManager(Post::class);
		$post = $manager->find($id);	
		$post->addLike();
		$post->setLastWriteDate(NULL);
		$manager->update($post);
		return $this->redirect("post", [
			"id" => $post->getId(),
			"page" => 1
		]);
	}

	public function reportPost($id)
	{
		$manager = $this->getDatabase()->getManager(Post::class);
		$post = $manager->find($id);	
		$post->setIsReported(1);
		$post->setLastWriteDate(NULL);
		$manager->update($post);
		$this->request->setSession('reportedPosts', $manager->countReportedPosts());
		return $this->redirect("reportedPosts", [
            "page" => 1
        ]);		
	}

	public function unReportPost($id)
	{
		$manager = $this->getDatabase()->getManager(Post::class);
		$post = $manager->find($id);	
		$post->setIsReported(0);
		$post->setLastWriteDate(NULL);
		$manager->update($post);
		$this->request->setSession('reportedPosts', $manager->countReportedPosts());
		return $this->redirect("reportedPosts", [
            "page" => 1
        ]);		
	}
}