<?php
if (session_status() !== PHP_SESSION_ACTIVE)
{
session_start();
}
require_once __DIR__.'/../core/DB.php';
require_once __DIR__."/../core/config.php";

class SuperAdmin
{
	public DB $db;
	public pdo $pdo;

	public function __construct()
	{
		$this->db = new DB();
		$this->pdo = $this->db->getConnection();
	}


	public function validateSuperAdmin()
	{
		if ($_SESSION['account']['superAdmin'])
			return true;
		else
			return false;
		/*$query = "SELECT superAdmin FROM users WHERE ID = :id";
		$stmt = $this->pdo->prepare($query);
		$stmt->execute
			(
				[
					'id' => $_SESSION['account']
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
		}*/
	}
		
	public function addAdmin($username)
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
							'username' => $username
						]
					);
			if ($stmt->rowCount() > 0)
			{	
				return "$username is now admin";
			}
			else
			{
				return "$username doesn't exist";
			}
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

	public function deleteAdmin($username)
	{
		
		if ($this->validateSuperAdmin())
		{
			try
			{
				$query = "UPDATE users SET admin = NULL WHERE username = :username";
				$stmt = $this->pdo->prepare($query);
				$stmt->execute
					(
						[
							'username' => $username
						]
					);
			
				if ($stmt->rowCount() > 0)
				{
				return "$username is no longer admin";
				}
				else 
				{
					return "no admin has the username $username";
				}
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
