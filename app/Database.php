<?php

namespace App;

class Database 
{

	private $pdo;

	private $managers = [];

	private static $_databaseInstance;


	public function __construct($host, $dbName, $username, $password)
	{
		$this->pdo = new \PDO("mysql:dbname=$dbName;host=$host", $username, $password); // A modifier
	}

	public static function getInstance()
	{
		if (is_null(self::$_databaseInstance)) {
			self::$_databaseInstance = new Database('localhost', 'blog_oc', 'root', '');
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
			$this->managers[$model] = new $managerClass($this->pdo, $model);
		}

		return $this->managers[$model];
	}
}