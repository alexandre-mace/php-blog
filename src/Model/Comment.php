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

	private $added_at;

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
                "added_at"            => [
                    "type"      => "datetime",
                    "property"  => "addedAt"
                ]
            ]
        ];
    }

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

	public function getAddedAt()
	{
		return $this->addedAt;
	}
	
	public function setAddedAt($addedAt)
	{
		$this->addedAt = $addedAt;
	}
}
