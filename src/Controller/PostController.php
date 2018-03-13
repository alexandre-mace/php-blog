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

	public function showPaginatedPosts($page = 1)
	{
		$manager = $this->getDatabase()->getManager(Post::class);
		$posts = $manager->getPaginatedPosts($page)['results'];
		$nbPages = $manager->getPaginatedPosts($page)['nbPages'];
		return $this->render("posts.html.twig", [
            "posts" => $posts,
            "page" => $page,
            "nbPages" => $nbPages
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
		return $this->redirect("post", ["id" => $post->getId()]);
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
		return $this->redirect("index");
	}
}