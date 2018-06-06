<?php

namespace Model;

use App\Model;
use Manager\UserManager;

/**
* User
*/
class User extends Model
{

	private $id;

	private $password;

	private $addedAt;

	private $isAdmin = 0;

	private $isChecked = 0;


    public static function metadata()
    {
        return [
            "table"             => "users",
            "primaryKey"        => "id",
            "columns"           => [
                "id"            => [
                    "type"      => "string",
                    "property"  => "id",
                    "constraints"   => [
	                    "required" => [
	                    	"message" => "Veuillez écrire votre identifiant"
	                    ],
	                    "unique" => [
	                    	"message" => "Un autre utilisateur possède déjà le meme identifiant, veuillez en choisir un nouveau."
	                    ],
                    	"length" => [
	                    	"min" 		 => 1,
	                    	"minMessage" => "Le pseudo doit contenir au moins 1 caractère",
	                    	"max"        => 80,
	                    	"maxMessage" => "Le pseudo doit contenir 80 caractères maximum"
	                    ]
                    ]
                ],
                "password"            => [
                    "type"      => "password",
                    "property"  => "password",
                    "constraints"   => [
	                    "required" => [
	                    	"message" => "Veuillez écrire votre identifiant"
	                    ],
                    	"length" => [
	                    	"min" 		 => 6,
	                    	"minMessage" => "Le mot de passe doit contenir au moins 6 caractères",
	                    	"max"        => 80,
	                    	"maxMessage" => "Le mot de passe  doit contenir 80 caractères maximum"
	                    ]
                    ]
                ],
                "added_at"            => [
                    "type"      => "datetime",
                    "property"  => "addedAt"
                ],
                "is_admin"            => [
                    "type"      => "integer",
                    "property"  => "isAdmin"
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
		return UserManager::class;
	}

	public function getId()
	{
		return $this->id;
	}

	public function setId($id)
	{
		$this->id = $id;
	}

	public function getPassword()
	{
		return $this->password;
	}
	
	public function setPassword($password)
	{
		$this->password = $password;
	}

	public function getIsAdmin()
	{
		return $this->isAdmin;
	}
	
	public function setIsAdmin($isAdmin)
	{
		$this->isAdmin = $isAdmin;
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
