<?php

namespace Model;

use App\Model;
use Manager\ReportManager;

/**
* Report
*/
class Report extends Model
{
	private $id;

	private $type;

	private $postId;

	private $commentId;

	private $reason;

	private $addedAt;


    public static function metadata()
    {
        return [
            "table"             => "reports",
            "primaryKey"        => "id",
            "columns"           => [
                "id"            => [
                    "type"      => "integer",
                    "property"  => "id"
                ],
                "type"            => [
                    "type"      => "string",
                    "property"  => "type"
                ],              
                "post_id"            => [
                    "type"      => "integer",
                    "property"  => "postId"
                ],
                "comment_id"            => [
                    "type"      => "integer",
                    "property"  => "commentId"
                ],
                "reason"            => [
                    "type"      => "string",
                    "property"  => "reason",
                    "constraints"   => [
	                    "required" => [
	                    	"message" => "Veuillez expliquer la raison de votre signalement"
	                    ],
                    	"length" => [
	                    	"min" 		 => 1,
	                    	"minMessage" => "Le commentaire doit contenir au moins 1 caractère",
	                    	"max"        => 255,
	                    	"maxMessage" => "Le commentaire doit contenir 255 caractères maximum"
	                    ]
                    ]
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
		return ReportManager::class;
	}

	public function getId()
	{
		return $this->id;
	}

	public function setId($id)
	{
		$this->id = $id;
	}
	public function getType()
	{
		return $this->type;
	}

	public function setType($type)
	{
		$this->type = $type;
	}

	public function getPostId()
	{
		return $this->postId;
	}

	public function setPostId($postId)
	{
		$this->postId = $postId;
	}

	public function getCommentId()
	{
		return $this->commentId;
	}

	public function setCommentId($commentId)
	{
		$this->commentId = $commentId;
	}
	public function getReason()
	{
		return $this->reason;
	}
	
	public function setReason($reason)
	{
		$this->reason = $reason;
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
