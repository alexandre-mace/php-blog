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
			$set[] = "" . $column . "= :" . $column . "";
		}
		$sqlQuery = "INSERT INTO " . $this->metadata['table'] . " VALUES " . implode(',', $set);
		$statement = $this->pdo->prepare($sqlQuery);
		$statement->execute($parameters);
		$model->setPrimaryKey($this->pdo->lastInsertId());

	}

	public function update(Model $model)
	{
		$set = [];
		$parameters = [];
		foreach (array_keys($this->metadata["columns"]) as $column) 
		{
			$sqlValue = $model->getSQLValueByColumn($column);
			if ($sqlValue !== $model->originalData[$column]) {
				$parameters[$column] = $sqlValue;
				$model->originalData[$column] = $sqlValue;
				$set[] = "" . $column . "= :" . $column . "";
			}
		}
		if (count($set))
		{
			$sqlQuery = "UPDATE " . $this->metadata['table'] . " SET " . implode("s", $set) . " WHERE " . $this->metadata['primaryKey'] . " = :id"; 
			$statement = $this->pdo->prepare($sqlQuery);
			$statement->execute(["id" => $model->getPrimaryKey()]);
		}
	}

	public function remove(Model $model)
	{
		$sqlQuery = "DELETE FROM " . $this->metadata['table'] . " WHERE " . $this->metadata['primaryKey'] . " = :id";
		$statement = $this->pdo->prepare($sqlQuery);
		$statement->execute(["id" => $model->getPrimaryKey()]);
	}
}