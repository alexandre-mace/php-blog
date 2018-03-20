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

	private $postId;

	private $content;

	private $author;

	private $likes;

	private $addedAt;

	private $isChecked;

	private $isReported;


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
                    "type"      => "integer",
                    "property"  => "postId"
                ],
                "content"            => [
                    "type"      => "string",
                    "property"  => "content"
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
                "is_checked"            => [
                    "type"      => "boolean",
                    "property"  => "isChecked"
                ],                
                "is_reported"            => [
                    "type"      => "boolean",
                    "property"  => "isReported"
                ],                
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

	public function getLikes()
	{
		return $this->likes;
	}
	
	public function setLikes($likes)
	{
		$this->likes = $likes;
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

	public function getIsReported()
	{
		return $this->isReported;
	}
	
	public function setIsReported($isReported)
	{
		$this->isReported = $isReported;
	}
}
