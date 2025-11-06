<?php

namespace Models;
use App;
class CRUD
{
	protected static CRUD $instance = null;
	protected DB $db;
	public function __construct()
	{
		$this -> $db = App::$db;
	}
	public static function getInstance()
	{
		if ($instance == null)
		{
			$instance = new CRUD();
		}
		return $instance;
	}
	
	public function readAll($table, $column)
	{
		$query = "SELECT :column FROM :table";
		$stmt = $this -> db -> prepare($query);

		$stmt -> execute
			(
				[
				'column' => $column,
				'table' => $table
				]
			);
		$stmt -> fetchAll(PDO::FETCH:_ASSOC);
	}

	public function readByColumn ($table, $column, $condition, $val1)
	{
		$query = "SELECT :column FROM :table WHERE :condition = :val1";
		$stmt = $this -> db -> prepare($query);
		$stmt -> execute
			(
				[
					'column' => $column,
					'table' => $table,
					'condition' => $val1,
					'val1' => $val1
				]
			);
		$stmt -> fetchAll(PDO::FETCH_ASSOC);
	
	}

	public function deleteAll($table)
	{
		$query = "TRUNCATE TABLE :table";
		$stmt = $this -> db -> prepare($query);
		return $stmt -> execute
			(
				[
					'table' => $query
				]
			);
	}

	public function deleteRecord($table, $column, $val)
	{
		$query = "DELETE FROM :table WHERE";
	
	}
	public function updateValue($table, $column, $val)
	{
		$query = "UPDATE :table SET :column = :val";
		$stmt = $this -> db -> prepare($qurey);
		return $stmt -> execute
			(
				[
					'table' => $table,
					'column' => $column,
					'val' => $val
				]
			);
	}

}
