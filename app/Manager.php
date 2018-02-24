<?php

namespace App;

/**
* Main Manager
*/
class Manager
{
	
	private $pdo;

	private $model;

	private $metadata;


	public function __construct(\PDO $pdo, $model)
	{
		$this->pdo = $pdo;
		$this->model = $model;
		$this->metadata = $this->model::metadata();
	}

	public function find($id)
	{
		return $this->fetch([$this->metadata["primaryKey"] => $id]);
	}

	public function insert(Model $model)
	{
		$set = [];
		$parameters = [];
		foreach (array_keys($this->metadata["columns"]) as $column) 
		{
			$sqlValue = $model->getSQLValueByColumn($column);
			$model->originalData[$column] = $sqlValue;
			$parameters[$column] = $sqlValue;
			$set[] = $column = :$column;
		}
		$sqlQuery = "INSERT INTO '" . $this->metadata['table']. "' SET  '" . implode(",", $set) . "'";
		$statement 

	}

	public function update(Model $model)
	{

	}

	public function remove(Model $model)
	{
		$request = $pdo->prepare("DELETE FROM ' .$this->metadata['table']. ' WHERE ' .$this->metadata['primaryKey']. ' = :id");
		$request->execute(["id" => $model->getPrimaryKey()];
	}
}