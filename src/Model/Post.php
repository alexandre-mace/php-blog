<?php

/**
* Post
*/
class Post
{

	private $id;

	private $title;

	private $intro;

	private $content;

	private $author;

	private $lastWriteDate;

	private $comments;


	public function getId()
	{
		return $this->id;
	}

	public function setId($id)
	{
		$this->id = $id;
	}

	public function getTitle()
	{
		return $this->title;
	}
	
	public function setTitle($title)
	{
		$this->title = $title;
	}

	public function getIntro()
	{
		return $this->intro;
	}
	
	public function setIntro($intro)
	{
		$this->intro = $intro;
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

	public function getLastWriteDate()
	{
		return $this->lastWriteDate;
	}
	
	public function setLastWriteDate($lastWriteDate)
	{
		$this->lastWriteDate = $lastWriteDate;
	}
}
