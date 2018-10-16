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

	private $post;

	private $comment;

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
                    "type"      => "model",
                    "property"  => "post",
                    "class" 	=> "Post"
                ],
                "comment_id"            => [
                    "type"      => "model",
                    "property"  => "comment",
                    "class" => "Comment"
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
	                    	"minMessage" => "Le commentaire doit contenir au moins 1 caractère"
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

	public function getPost()
	{
		return $this->post;
	}

	public function setPost($post)
	{
		$this->post = $post;
	}

	public function getComment()
	{
		return $this->comment;
	}

	public function setComment($comment)
	{
		$this->comment = $comment;
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
