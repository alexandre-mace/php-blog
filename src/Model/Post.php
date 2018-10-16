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

	private $likes = 0;

	private $addedAt;

	private $lastWriteDate;

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
                    "property"  => "title",
                    "constraints"   => [
	                    "required" => [
	                    	"message" => "Veuillez écrire un titre"
	                    ],
                    	"length" => [
	                    	"min" 		 => 5,
	                    	"minMessage" => "Le titre doit contenir au moins 5 caractères",
	                    	"max"        => 100,
	                    	"maxMessage" => "Le titre doit contenir 100 caractères maximum"
	                    ]
                    ]
                ],
                "intro"            => [
                    "type"      => "string",
                    "property"  => "intro",
                    "constraints"   => [
	                    "required" => [
	                    	"message" => "Veuillez écrire une introduction"
	                    ],
                    	"length" => [
	                    	"min" 		 => 35,
	                    	"minMessage" => "L'introduction doit contenir au moins 35 caractères",
	                    	"max"        => 350,
	                    	"maxMessage" => "L'introduction doit contenir 350 caractères maximum"
	                    ]
                    ]
                ],
                "content"            => [
                    "type"      => "string",
                    "property"  => "content",
                    "constraints"   => [
	                    "required" => [
	                    	"message" => "Veuillez écrire un contenu"
	                    ],
                    	"length" => [
	                    	"min" 		 => 500,
	                    	"minMessage" => "Le contenu doit contenir au moins 500 caractères",
	                    	"max"        => 10000,
	                    	"maxMessage" => "Le contenu doit contenir 10000 caractères maximum"
	                    ]
                    ]
                ],
                "author"            => [
                    "type"      => "string",
                    "property"  => "author"
                ],  
                "likes"            => [
                    "type"      => "integer",
                    "property"  => "likes"
                ],               
                "added_at"            => [
                    "type"      => "datetime",
                    "property"  => "addedAt"
                ],
                "last_write_date"            => [
                    "type"      => "datetime",
                    "property"  => "lastWriteDate"
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

	public function getLikes()
	{
		return $this->likes;
	}
	
	public function setLikes($likes)
	{
		$this->likes = $likes;
	}

	public function addLike()
	{
		$this->likes++;
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
