<?php

namespace Model;

use App\Model;
use Manager\CommentManager;

/**
* Comment
*/
class Comment extends Model
{

	private $postId;

	private $content;

	private $author;

	private $date;


	public static function getManager()
	{
		return CommentManager::class;
	}

	public function getPostId()
	{
		return $this->postId;
	}

	public function setPostId($postId)
	{
		$this->postId = $postId;
	}

	public function getContent()
	{
		return $this->content;
	}
	
	public function setContent($content)
	{
		$this->content = $content;
	}

	public function getAuthor()
	{
		return $this->author;
	}
	
	public function setAuthor($author)
	{
		$this->author = $author;
	}

	public function getDate()
	{
		return $this->date;
	}
	
	public function setDate($date)
	{
		$this->date = $date;
	}
}
