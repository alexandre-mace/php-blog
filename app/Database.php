<?php

namespace App;

use App\Request;

class Database 
{

	private $pdo;

	private $managers = [];

	private static $_databaseInstance;


	public function __construct($host, $dbName, $username, $password)
	{
		$this->pdo = new \PDO("mysql:dbname=$dbName;host=$host", $username, $password);
	}

	public static function getInstance()
	{
		if (is_null(self::$_databaseInstance)) {
            self::$_databaseInstance = new Database(
                getEnv("DB_HOST"),
                getEnv("DB_NAME"),
                getEnv("DB_USER"),
                getEnv("DB_PASSWORD")
            );
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