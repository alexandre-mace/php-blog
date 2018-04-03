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
		$manager = $this->getDatabase()->getManager(Post::class);
		$post = new Post();
		$post->setAddedAt(new \DateTime());
		$post->setTitle("test");
		$post->setIntro("Lorem Ipsum");
		$post->setContent("Lorem Ipsum");
		$post->setAuthor("Lorem");
		$manager->insert($post);
		return $this->redirect("post", [
			"id" => $post->getId(),
			"page" => 1
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
		return $this->redirect("reportedPosts", [
            "page" => 1
        ]);		
	}
}