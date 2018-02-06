<?php

use App\Controller;
use Model\PostManager;
/**
* ¨PostController
*/
class PostController extends Controller
{
	
	public function getPost()
	{
		$postManager = new PostManager();
		$post = $postManager->getPost($_GET['id']);
	}
	public function getPosts()
	{
		$postManager = new PostManager();
		$posts = $postManager->getPosts();
	}

	public function addPost()
	{
		

	}

	public function updatePost()
	{
		$postManager = new PostManager();
		$postManager->updatePost($_GET['id']);
	}

	public function deletePost()
	{
		
	}
}