<?php
session_start();

require_once __DIR__.'/../core/DB.php';

class Login
{

		public DB $db;
		public pdo $pdo;
		public function __construct()
		{
			$this->db = new DB();
			$this->pdo = $this->db->getConnection();
		}

		public function getUser()
		{
			$email = trim($_POST['email']);
			$password = trim($_POST['password']);

			try
			{
				$query = "SELECT * FROM users WHERE email = :email";
				$stmt = $this->pdo->prepare($query);
				$stmt->execute
					(
						[
							'email' => $email,
						]
					);
				$user = $stmt->fetch(PDO::FETCH_ASSOC);
				if (! $user)
				{
					$_SESSION['error'] = "wrong email" ;
					header("location: login.php");
					exit;
				}
				else
				{
					$pass = password_verify($password, $user['password']);
					if (! $pass)
					{
						$_SESSION['error'] = "wrong password";
						header("location: login.php");
						exit;
					}
					else
					{
						$_SESSION['account'] = $user;
						if ($_SESSION['account']['admin'])
						{
							header("location: dashboard.php");
							exit;
						}
						else
							header("location: home.php");
							echo $_SESSION['account'];
						exit;
					}
				}
			}
			catch (PDOException $e)
			{
				$_SESSION['error'] =  "unexpected error $e";
				header("location: login.php");
				exit;
			}
		}

}
