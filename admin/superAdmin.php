<?php
require_once __DIR__.'/../core/DB.php';

use pdo;

class users
{
	public DB $db;
	public pdo $pdo;
	public int $id; //set the value to the id stored in session

	public function __construct()
	{
		$this->db = new DB();
		$this->pdo = $this->db->getConnection();
	}


	public function validateSuperAdmin()
	{
		$query = "SELECT superAdmin FROM users WHERE ID = :id";
		$stmt = $this->pdo->prepare($query);
		$stmt->execute
			(
				[
					'id' => $this->id
				]
			);
		$superAdmin = $stmt->fetch();
		if ($superAdmin)
		{
			return $superAdmin;
		}
		else
		{
			return null;
		}
	}
		
	public function addAdmin($userName)
	{
		if ($this->validateSuperAdmin())
		{
			try
			{
				$query = "UPDATE users SET admin = 1 WHERE username = :username";
				$stmt = $this->pdo->prepare($query);
				$stmt->execute
					(
						[
							'username' => $userName
						]
					);
			
			return "$userName is now admin";
			}
			catch (PDOException $e)
			{
				return "unexpected error $e";
			}
		}
		else
		{
			return "not authorized to set admin";
		}

	}

	public function deleteAdmin($userName)
	{
		
		if ($this->validateSuperAdmin())
		{
			try
			{
				$query = "UPDATE users SET admin = 0 WHERE username = :username";
				$stmt = $this->pdo->prepare($query);
				$stmt->execute
					(
						[
							'username' => $userName
						]
					);
			
			return "$userName is no longer admin";
			}
			catch (PDOException $e)
			{
				return "unexpected error $e";
			}
		}
		else
		{
			return "not authorized to delete admin";
		}

	}
}
