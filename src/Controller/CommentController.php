<?php

use App\Controller;
use Model\CommentManager;
/**
* ¨CommentController
*/
class CommentController extends Controller
{
	
	public function addComment()
	{

	}

	public function updateComment()
	{

	}

	public function deleteComment()
	{
		$commentManager = new CommentManager();
		$commentManager->delete($commentId, "comments");
	}
}