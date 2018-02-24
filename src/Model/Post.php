<?php

namespace Model;

use App\Model;
use Manager\PostManager;

/**
* Post
*/
class Post extends Model
{

	private $id;

	private $title;

	private $intro;

	private $content;

	private $author;

	private $addedAt;

	private $lastWriteDate;

	private $comments;

    public static function metadata()
    {
        return [
            "table"             => "posts",
            "primaryKey"        => "id",
            "columns"           => [
                "id"            => [
                    "type"      => "integer",
                    "property"  => "id"
                ],
                "title"            => [
                    "type"      => "string",
                    "property"  => "title"
                ],
                "intro"            => [
                    "type"      => "string",
                    "property"  => "intro"
                ]
                "content"            => [
                    "type"      => "string",
                    "property"  => "content"
                ]
                "addedAt"            => [
                    "type"      => "datetime",
                    "property"  => "addedAt"
                ]
                "lastWriteDate"            => [
                    "type"      => "datetime",
                    "property"  => "lastWriteDate"
                ]
                "comments"            => [
                    "type"      => "array",
                    "property"  => "comments"
                ]
            ]
        ];
    }

	public static function getManager()
	{
		return PostManager::class;
	}

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

	public function getAddedAt()
	{
		return $this->addedAt;
	}

	public function setAddedAt($addedAt)
	{
		$this->addedAt = $addedAt;
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
