<?php

require_once __DIR__.'/../core/DB.php';
use pdo;

class Register
{
	public DB $db;
	public pdo $pdo;
	public array $errors;
	public function __construct()
	{
		$this->db = new DB();
		$this->pdo = $this->db->getConnection();
	}

	public function createUser()
	{	
		$username = trim($_POST['username']);
		$email = trim($_POST['email']);
		$passwd =trim($_POST['password']);
		$confirmPW = trim($_POST['confirmPassword']);

		if (! $this->validatePassword($passwd, $confirmPW))
		{
		
			header ("location : /../views/register.php");
			return $this->errors;
		}
		if (! $this->validateEmail($email) == )
		{
			header ("location : /../views/register.php");
			return $this->errors;
		}
		if (! $this->validateUsername($username))
		{	
			header ("location : /../views/register.php");
			return $this->errors;
		}
		$passwd = password_hash($passwd, PASSWORD_DEFAULT);

		try
		{
			$query = "INSERT INTO users (username, email, password) values (:username, :email, :password)";
			$stmt = $this->pdo->prepare($query);
			$stmt->execute
				(
						[
						'username' => $username,
						'email' => $email,
						'password' => $passwd,
						]
				);
			$_SESSION['state'] = 'user created successully';
			header("location : ../views/login.php");
			return;
		}
		catch (PDOException $e)
		{
			$_SESSION['state'] ="unexpected error";
			header("location : ../views/login.php");
			return;	
		}
	}
	public function validatePassword($password, $confirmPassWD)
	{	
		if (! isset($_POST['password']))
		{
			$this->errors['password'] = "enter a password";
			return false
		}
		if (! isset($_POST['confirmPassword']))
		{
			$this->errors['password'] = "confirm the password";
			return false
		}
		if ($password !== $confirmPassWD)
		{
			$this->errors['password'] = 'enter the password correctly';
			return false
		}
		if (strpbrk($password ,"';\\<>&%!|#$") !== false)
		{
			$this->errors['password'] = " password can't have any of these chrchters \"';\\<>&%!|#$";
			return false
		}
		if (strlen($password)< 6)
		{
			$this->errors['password'] = "password is too short mus be at least 6" ;
			return false
		}

		if (strlen($password)>16)
		{
			$this->errors['password'] = "password is too long" ;
			return false
		}

	}
	public function validateEmail($email)
	{
		if (! isset($_POST['email']))
		{
			$this->errors['email'] = "email required";
			return false

		}
		if (! filter_var($email, FILTER_VALIDATE_EMAIL))
		{
			$this->errors['email'] = "enter valid email";
			return false
		}
		$query = "SELECT email FROM users WHERE email = :email";
		$stmt = $this->pdo->prepare($query);
		$stmt->execute
			(
				[
					'email' => $email
				]
			);
		if (($stmt->fetch()) != false)
		{
			$this->errors['email'] = "email already exist";
			return false
		}
		if (strpbrk($email , "\"';\\<>&%!|#$") !== false)
		{
			$this->errors['email'] = "email can't have these \"';\\<>&%!|#$ charchters";
			return false
		}


		return true;
	
	}
	public function validateUsername($username)
	{	
		if (! isset($_POST['username']))
		{
				$this->errors['username'] = "email required";
				return false
				
		}
		if (strpbrk($username , "\"';\\<>&%!|#$") !== false)
		{
			$this->errors['username'] = "username can't have these \"';\\<>&%!|#$ charchters";
			return false
		}

		$query = "SELECT username FROM users WHERE username = :username";
		$stmt = $this->pdo->prepare($query);
		$stmt->execute
			(
				[
					'username' => $username
				]
			);
		if (($stmt->fetch()) != false)
		{
			$this->errors['username'] = "username already exist";
			return false
		}
	if (strlen($username)>16)
		{
			$errors['username'] = "username is too long" ;
			return false
		}
		return true;
	}
}
