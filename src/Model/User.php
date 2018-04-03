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

	private $isAdmin;


    public static function metadata()
    {
        return [
            "table"             => "users",
            "primaryKey"        => "id",
            "columns"           => [
                "id"            => [
                    "type"      => "string",
                    "property"  => "id"
                ],
                "password"            => [
                    "type"      => "string",
                    "property"  => "password"
                ],
                "is_admin"            => [
                    "type"      => "integer",
                    "property"  => "isAdmin"
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
}
