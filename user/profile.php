<?php
require_once __DIR__."/../core/DB.php";
use PDO;
class UserProfile
{
	public DB $db;
	public PDO $pdo;

	public function __construct()
	{
		$this->db = new DB();
		$this->pdo= $this->db->getConnection();
	}

	//get user ID from the session
	public function getUserId()
	{
		//todo after auth	
		return $id = 0;
	}

	
	public function editPassword($oldPasswd, $newPasswd1, $newPasswd2)
	{
		//still need modification by using hashing
		$id = $this->getUserId();
		$query = "SELECT password FROM users WHERE ID = :id";
		$stmt = $this->pdo->prepare($query);
		$stmt->execute
			(
				[
					'id' => $id
				]
			);
		$currentPasswd = $stmt->fetch();
		if ($currentPasswd === $oldPasswd)
		{
			if ($newPasswd1 === $newPasswd2)
			{
				$query = "UPDATE users SET password = :newpasswd WHERE ID = :id";
				$stmt = $this->pdo->prepare($query);
				$stmt->execute
					(
						[
							'newpasswd' => $newPasswd1,
							'id' => $id
						]
					);
			}
			return "enter the new password correctly";
		}
		return "enter your password correctly";
	}

	public function editEmail($email)
	{
		$id = $this->getUserId();
		try 
		{
			$query = "UPDATE users SET email = :email WHERE ID = :id";
			$stmt = $this->pdo->prepare($query);
			$stmt->execute
				(
					[
						'email' => $email,
						'id' => $id
					]
				);
			return "email updated";
		}
		catch (PDOException $e) 
		{
			if ($e->getCode() == 23000)
			{
			echo "email already exist enter another email";
			}
			else
			echo "unexpected error occured";
		}

		
	}

	public function editUserName($userName)
	{
		$id = $this->getUserId();
		try 
		{
			$query = "UPDATE users SET username = :username WHERE ID = :id";
			$stmt = $this->pdo->prepare($query);
			$stmt->execute
				(
					[
						'username' => $userName,
						'id' => $id
					]
				);
			return "username updated";
		}
		catch (PDOException $e) 
		{
			if ($e->getCode() == 23000)
			{
			echo "username already exist enter another username";
			}
			else
			echo "unexpected error occured";
		}

		
	}
}
