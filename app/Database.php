<?php

namespace App;

class Database 
{

	private $pdo;

	private $managers = [];

	private static $_databaseInstance


	public function __construct($host, $dbName, $user, $password)
	{
		$this->pdo = new \PDO("mysql:dbname=$db;host=$host", $username, $password); // A modifier
	}

	public static function getInstance()
	{
		if (is_null(self::$_databaseInstance)) {
			self::$_databaseInstance = new App();
		}

		return self::$_databaseInstance;
	}

	public function getPdo()
	{
		return $this->pdo;
	}

	public function getManager($model)
	{
		$managerClass = $model::getManager();
		if (!isset($this->managers[$model])) {
			new $managerClass($this->pdo, $model);
		}

		return $this->managers[$model];
	}
}