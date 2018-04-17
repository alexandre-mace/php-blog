<?php

namespace Manager;

use App\Manager;
use Model\Report;

/**
* Report Manager
*/
class ReportManager extends Manager
{	
	public function getReported($page, $type)
	{
		$sqlQuery = "SELECT * FROM reports WHERE type = ?";
		$statement = $this->pdo->prepare($sqlQuery);
		$statement->execute(array($type));
		$nbReports = $statement->rowCount();
		$nbPages = ceil($nbReports / 10);
        $start = ($page-1)*10;
		$sqlQuery = "SELECT * FROM reports WHERE type = ? ORDER BY added_at DESC LIMIT $start, 10";
		$statement = $this->pdo->prepare($sqlQuery);
		$statement->execute(array($type));
		$results = $statement->fetchAll(\PDO::FETCH_ASSOC);
		array_walk($results, function(&$report) {
			$report = (new Report())->hydrate($report);
		});
		$arrayReturned = array('nbPages' => $nbPages, 'results' => $results);
		return $arrayReturned;
	}

	public function countReported($type)
	{
		$sqlQuery = "SELECT * FROM reports WHERE type = ?";
		$statement = $this->pdo->prepare($sqlQuery);
		$statement->execute(array($type));
		$nbReports = $statement->rowCount();
		return $nbReports;		
	}

}