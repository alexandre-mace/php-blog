<?php

use App\Controller;
use Model\PostManager;
/**
* ¨PostController
*/
class PostController extends Controller
{
	
	public function renderPost()
	{
		$postManager = new PostManager();
		$commentManager = new CommentManager();

		$post = $postManager->getPost($_GET['id']);
		$comments = $commentManager->getComments($_GET['id']);
	}
	public function renderPosts()
	{
		$postManager = new PostManager();
		$posts = $postManager->getPosts();
	}

	public function addPost()
	{
		

	}

	public function updatePost()
	{

	}

	public function deletePost()
	{
		$postManager = new PostManager();
		$postManager->delete($postId, "posts");
	}
}