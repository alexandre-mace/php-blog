<?php

namespace Controller;

use App\Controller;
use Model\Post;

/**
* ¨PostController
*/
class PostController extends Controller
{
	
	public function showPost()
	{
		$manager = $this->getDatabase()->getManager(Post::class);
		$post = $manager->find($id);
	}

	public function showLastPosts()
	{
		$manager = $this->getDatabase()->getManager(Post::class);
		$lastPosts = $manager->getLastPosts();
	}

	public function addPost()
	{
		$manager = $this->getDatabase()->getManager(Post::class);
		$post = new Post();
		$post->setAddedAt(new \DateTime());
		$manager->insert($post);		
	}

	public function updatePost($id)
	{
		$manager = $this->getDatabase()->getManager(Post::class);
		$post = $manager->find($id);
	}

	public function deletePost($id)
	{
		$manager = $this->getDatabase()->getManager(Post::class);
		$post = $manager->find($id);
		$manager->remove($post);
	}
}