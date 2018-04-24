<?php

namespace Model;

use App\Model;
use Manager\CommentManager;

/**
* Comment
*/
class Comment extends Model
{
	private $id;

	private $post;

	private $content;

	private $author;

	private $likes = 0;

	private $addedAt;

	private $isChecked = 0;


    public static function metadata()
    {
        return [
            "table"             => "comments",
            "primaryKey"        => "id",
            "columns"           => [
                "id"            => [
                    "type"      => "integer",
                    "property"  => "id"
                ],
                "post_id"            => [
                    "type"      => "model",
                    "property"  => "post",
                    "class" 	=> "Post"
                ],
                "content"            => [
                    "type"      => "string",
                    "property"  => "content",
                    "constraints"   => [
	                    "required" => [
	                    	"message" => "Veuillez écrire un commentaire"
	                    ],
                    	"length" => [
	                    	"min" 		 => 1,
	                    	"minMessage" => "Le commentaire doit contenir au moins 1 caractère",
	                    	"max"        => 800,
	                    	"maxMessage" => "Le commentaire doit contenir 800 caractères maximum"
	                    ]
                    ]
                ],
                "author"            => [
                    "type"      => "string",
                    "property"  => "author",
                    "constraints"   => [
	                    "required" => [
	                    	"message" => "Veuillez écrire votre pseudo"
	                    ],
                    	"length" => [
	                    	"min" 		 => 1,
	                    	"minMessage" => "Le pseudo doit contenir au moins 1 caractère",
	                    	"max"        => 80,
	                    	"maxMessage" => "Le pseudo doit contenir 80 caractères maximum"
	                    ]
                    ]
                ],
                "likes"            => [
                    "type"      => "integer",
                    "property"  => "likes"
                ],                   
                "added_at"            => [
                    "type"      => "datetime",
                    "property"  => "addedAt"
                ],
                "is_checked"            => [
                    "type"      => "integer",
                    "property"  => "isChecked"
                ]             
            ]
        ];
    }

	public static function getManager()
	{
		return CommentManager::class;
	}

	public function getId()
	{
		return $this->id;
	}

	public function setId($id)
	{
		$this->id = $id;
	}

	public function getPost()
	{
		return $this->post;
	}

	public function setPost($post)
	{
		$this->post = $post;
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

	public function getIsChecked()
	{
		return $this->isChecked;
	}
	
	public function setIsChecked($isChecked)
	{
		$this->isChecked = $isChecked;
	}
}
