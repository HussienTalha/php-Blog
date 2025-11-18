<?php

use PDO;

class DB
{	
	private PDO $pdo;

	public function  __construct()
	{
		try
		{
			$this->pdo = new PDO('mysql:host=mysql;dbname=my_db;','root','root');
		}
		catch (PDOException $e)
		{
			throw new Exception ('error connecting to database');
		}
	}

	public function getConnection()
		{
			return $this->pdo;
		}
}
