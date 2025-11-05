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
		$stmt = $db -> prepare($query);

		return $stmt -> execute
			(
				[
				'column' => $column,
				'table' => $table
				]
			)
	}

	public function readByColumn ($table, $column, $condition, $val2)
	{
		$query = "SELECT :column FROM :table WHERE :condition = :val2";
		$stmt = $db -> prepare($query);
		return $stmt -> execute
			(
				[
					'column' => $column,
					'table' => $table,
					'val1' => $val1,
					'val2' => $val2
				]
			);
	
	}

	public function deleteAll($table)
	{
		$query = "TRUNCATE TABLE :table";
		$stmt = $db -> prepare($query);
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
		$stmt = $db -> prepare($qurey);
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
