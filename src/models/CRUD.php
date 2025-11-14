<?php

namespace Models;
use \pdo;
use App;
class CRUD
{
	protected static ?CRUD $instance = null;
	protected App\DB $db;
	public function __construct()
	{
		$this -> db = App\App::$db;
	}
	public static function getInstance():CRUD
	{
		if (self::$instance == null)
		{
			self::$instance = new CRUD();
		}
		return self::$instance;
	}
	
	public function readAll($table, $column)
	{
		$query = "SELECT `$column` FROM `$table`";
		$stmt = $this -> db -> prepare($query);

		$stmt -> execute();
		return $stmt -> fetchAll(PDO::FETCH_ASSOC);
	}

	public function readByColumn ($table, $column, $condition, $val1)
	{
		$query = "SELECT `$column` FROM `$table` WHERE `$condition` = :val1";
		$stmt = $this -> db -> prepare($query);
		$stmt -> execute
			(
				[
					'val1' => $val1
				]
			);
		return $stmt -> fetchAll(PDO::FETCH_ASSOC);
	
	}

	public function deleteAll($table)
	{
		$query = "TRUNCATE TABLE `$table`";
		$stmt = $this -> db -> prepare($query);
		return $stmt -> execute();
	}

	public function deleteRecord($table, $column, $val)
	{
		$query = "DELETE FROM `$table` WHERE `$column` = :val";
		$stmt = $this -> db -> prepate($query);
		$stmt -> execute
			(
				[
				'val' => $val
				]
			);
	}
	public function updateValue($table, $column, $val)
	{
		$query = "UPDATE `$table` SET `$column` = :val";
		$stmt = $this -> db -> prepare($qurey);
		return $stmt -> execute
				(
					[
						'val' => $val
					]
				);
	}

}
