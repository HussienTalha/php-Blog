<?php
require_once __DIR__.'/../core/DB.php';

use pdo;

class users
{
	public DB $db;
	public pdo $pdo;
	public int $id;

	public function __construct()
	{
		$this->db = new DB();
		$this->pdo = $this->db->getConnection();
	}

	public function validateAdmin($id = 0) //make default value the id from the session
	{
		$query = "SELECT admin FROM users WHERE ID = :id";
		$stmt = $this->pdo->prepare($query);
		$stmt->execute
			(
				[
					'id' => $this->id
				]
			);
		$admin = $stmt->fetch();
		if ($admin)
		{
			return $admin;
		}
		else
		{
			return null;
		}
	}
	public function getUserId($username)
	{
		$query = "SELECT ID FROM users WHERE username = :username";
		$stmt = $this->pdo->prepare($query);
		$stmt->execute
			(
				[
					'username' => $username
				]
			);
		$userId = $stmt->fetch();
		return $userId;
	}


	public function createUser($userName, $email, $passwd, $admin)
	{	
		if ($this->validateAdmin()) 
		{
			try
			{
				$query = "INSERT INTO users (username, email, password, admin) values (:username, :email, :password, :admin)";
				$stmt = $this->pdo->prepare($query);
				$stmt->execute
					(
							[
							'username' => $userName,
							'email' => $email,
							'password' => $passwd,
							'admin' => $admin
						]
					);
				return "user created successfully";
			}
			catch (PDOException $e)
			{
				return "unexpected error $e";
			}
		}
		else
		{
			return "you're not authorized to create new user";
		}

	}
	public function deleteUser($username)
	{
		$userId = $this->getUserId($username);

		if ($this->validateAdmin())
		{
			if ($this->validateAdmin($userId))
			{
				return "not authorized to delete admin's profile";
			}
			else
			{
			try
			{
				$query = "DELETE FROM users WHERE ID = :id";
				$stmt = $this->pdo->prepare($query);
				$stmt->execute
					(
						[
							'id' => $userId
						]
					);
				return "users is deleted";
			}
			catch (PDOException $e)
			{
				return "unexpected error $e";
			}
			}
		}
		else 
		{
			return "not authorized to delete user";
		}
		}
	}
