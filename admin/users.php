<?php
require_once __DIR__.'/../core/DB.php';

use pdo;

class users
{
	session_start();
	public DB $db;
	public pdo $pdo;
	public int $id;

	public function __construct()
	{
		$this->db = new DB();
		$this->pdo = $this->db->getConnection();
	}

	public function validateAdmin() //make default value the id from the session
	{
		$this->id = $SESSION['account']['admin'];
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
			
			$username = trim($username);
			$email = trim($email);
			$passwd = trim($passwd);
			$confirmPW = trim($confirmPW);

			if ($passwd !== $confirmPW)
			{
				$_SESSION['state'] = 'enter the password correctly';
				header("location : ../views/register.php");
				return;
			}
			$passwd = password_hash($passwd, PASSWORD_DEFAULT);
		
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
				$_SESSION['state'] = 'user created successully';
				header("location : ../views/dashboard";
				return;
			}
			catch (PDOException $e)
			{
				$_SESSION['state'] ="unexpected error";
				header("location : ../views/dashboard";
				return;	
			}
		else
			{
				$_SESSION['state'] = "you're not authorized to create new user";
				header("location : ../views/dashboard";
				return;
			}

		}
	public function deleteUser($username)
	{
		$userId = $this->getUserId($username);

		if ($this->validateAdmin())
		{
			if ($this->validateAdmin($userId))
			{
				$_SESSION['state'] ="not authorized to delete admin's profile";
				header("location : ../views/dashboard";
				return;
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
				$_SESSION['state'] = "users is deleted";
				header("location : ../views/dashboard";
				return;
			}
			catch (PDOException $e)
			{
				 $_SESSION['state'] ="unexpected error $e";
				 header("location : ../views/dashboard";
				 return;
			}
			}
		}
		else 
		{
			$_SESSION['state'] = "not authorized to delete user";
			header("location : ../views/dashboard";
			return;
		}
		}
	}
