<?php

namespace Controller;

use App\Controller;
use Model\Comment;

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