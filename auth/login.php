<?php
session_start();

require_once __DIR__.'/../core/DB.php';
use pdo;

class login
{

		public DB $db;
		public pdo $pdo;
		public function __construct()
		{
			$this->db = new DB();
			$this->pdo = $this->db->getConnection();
		}

		public function getUser($account, $password)
		{
			try
			{
				$query = "SELECT * FROM users WHERE email = :email OR username = :username";
				$stmt = $this->pdo->prepare($query);
				$stmt->execute
					(
						[
							'email' => $account,
							'username' => $account
						]
					);
				$user = $stmt->fetch(PDO::FETCH_ASSOC);
				if (! $user)
				{
					$_SESSION['error'] = "wrong username or email" ;
					header("location : /../views/login.php");
					return;
				}
				else
				{
					$pass = password_verify($password, $user['password']);
					if (! $pass)
					{
						$_SESSION['error'] = "wrong password";
						header("location : /../views/login.php");
						return;
					}
					else
					{
						$_SESSION['account'] = $user;
						if ($_SESSION['account']['admin'])
						{
							header("location : /../views/dashboard.php");
							return;
						}
						else
							header("location : /../views/home.php");
						return;
					}
				}
			}
			catch (PDOException $e)
			{
				$_SESSION['error'] =  "unexpected error $e";
				header("location : /../views/login.php");
				return;
			}
		}

}
