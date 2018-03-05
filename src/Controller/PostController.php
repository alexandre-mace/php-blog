<?php

namespace Controller;

use App\Controller;
use Model\Post;

/**
* ¨PostController
*/
class PostController extends Controller
{
	
	public function showPost($id)
	{
		$manager = $this->getDatabase()->getManager(Post::class);
		$post = $manager->find($id);
		return $this->render("post.html.twig", [
            "post" => $post
        ]);
	}

	public function showLastPosts()
	{
		$manager = $this->getDatabase()->getManager(Post::class);
		$lastPosts = $manager->getLastPosts();
		return $this->render("home.html.twig", [
            "lastPosts" => $lastPosts
        ]);
	}

	public function showPaginatedPosts($page = 1)
	{
		$manager = $this->getDatabase()->getManager(Post::class);
		$posts = $manager->getPaginatedPosts();
		return $this->render("posts.html.twig", [
            "posts" => $posts
        ]);
	}
	public function addPost()
	{
		$manager = $this->getDatabase()->getManager(Post::class);
		$post = new Post();
		$post->setAddedAt(new \DateTime());
		$manager->insert($post);	
		return $this->redirect("show", ["id" => $post->getId()]);	
	}

	public function updatePost($id)
	{
		$manager = $this->getDatabase()->getManager(Post::class);
		$post = $manager->find($id);
		$manager->update($post);
		return $this->redirect("show", ["id" => $post->getId()]);
	}

	public function deletePost($id)
	{
		$manager = $this->getDatabase()->getManager(Post::class);
		$post = $manager->find($id);
		$manager->remove($post);
		return $this->redirect("index");
	}
}