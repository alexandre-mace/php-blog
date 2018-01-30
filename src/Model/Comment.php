<?php

/**
* Comment
*/
class Comment
{

	private $id;

	private $content;

	private $author;

	private $date;


	public function getId()
	{
		return $this->id;
	}

	public function setId($id)
	{
		$this->id = $id;
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
