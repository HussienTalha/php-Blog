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
	
	public function readAll($column , $table)
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

	public function readByColumn ($column, $val1, $val2, $table)
	{
		$query = "SELECT :column FROM :table WHERE :val1 = :val2";
		$stmt = $db -> prepare($query);
		return $stmt -> execute
			(
				[
					'column' => $column,
					'table' => $table,
					'val1' => $val1,
					'val2' => $val2
				]
			)
	
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
			)
	}
	public function updateColumn($table, $column, $val)
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
			)
	}

}
