<?php
if (session_status() !== PHP_SESSION_ACTIVE)
{
session_start();
}
require_once __DIR__.'/../core/DB.php';
require_once __DIR__."/../core/config.php";

class Register
{
	public DB $db;
	public pdo $pdo;
	public array $errors = [];
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
		

		$this->validatePassword($passwd, $confirmPW);
		$this->validateEmail($email);
		$this->validateUsername($username);
/*
		if (! $this->validatePassword($passwd, $confirmPW))
		{
		
			$_SESSION['validationError'] = $this->errors;
			header ("location : /views/register.php");
			return ;
		}
		if (! $this->validateEmail($email))
		{

			$_SESSION['validationError'] = $this->errors;
			header ("location :/views/register.php");
			return ;
		}
		if (! $this->validateUsername($username))
		{	
			$_SESSION['validationError'] = $this->errors;
			header ("location :/views/register.php");
			return ;
		}
		 */
		if (! empty ($_SESSION['validationError']))
		{
			header ("location: register.php");
			exit ;
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
			$_SESSION['state'] = 'user created successully you can now log in';
			header("location: login.php");
			exit;
		}
		catch (PDOException $e)
		{
			$_SESSION['state'] ="unexpected error";
			header("location : register.php");
			exit;	
		}
	}
	public function validatePassword($password, $confirmPassWD)
	{	
		if (! isset($_POST['password']))
		{
        $this->errors['password'] = "Enter a password";
        $_SESSION['validationError'] = $this->errors;
        return ;
    	}
		if (! isset($_POST['confirmPassword']))
		{
			$this->errors['password'] = "confirm the password";
			 $_SESSION['validationError'] = $this->errors;
			 return;

		}
		if ($password !== $confirmPassWD)
		{
			$this->errors['password'] = 'enter the password correctly';
			 $_SESSION['validationError'] = $this->errors;

			 return;
		}
		if (strpbrk($password ,"';\\<>&%!|#$") !== false)
		{
			$this->errors['password'] = " password can't have any of these chrchters \"';\\<>&%!|#$";
			 $_SESSION['validationError'] = $this->errors;
			 return;

		}
		if (strlen($password)< 6)
		{
			$this->errors['password'] = "password is too short must be at least 6" ;
			 $_SESSION['validationError'] = $this->errors;
			 return;

		}

		if (strlen($password)>16)
		{
			$this->errors['password'] = "password is too long" ;
			 $_SESSION['validationError'] = $this->errors;
			 return;

		}

	}
	public function validateEmail($email)
	{
		if (! isset($_POST['email']))
		{
			$this->errors['email'] = "email required";
			$_SESSION['validationError'] = $this->errors;
			return;

		}
		if (! filter_var($email, FILTER_VALIDATE_EMAIL))
		{
			$this->errors['email'] = "enter valid email";
			$_SESSION['validationError'] = $this->errors;;
			return;
		}
		$query = "SELECT email FROM users WHERE email = :email";
		$stmt = $this->pdo->prepare($query);
		$stmt->execute
			(
				[
					'email' => $email
				]
			);
		if (($stmt->fetch()) !=false)
		{
			$this->errors['email'] = "email already exist";
			$_SESSION['validationError'] = $this->errors;;
			return;
		}
		if (strpbrk($email , "\"';\\<>&%!|#$") !== false)
		{
			$this->errors['email'] = "email can't have these \"';\\<>&%!|#$ charchters";
			$_SESSION['validationError'] = $this->errors;;
			return;
		}


		return true;
	
	}
	public function validateUsername($username)
	{	
		if (! isset($_POST['username']))
		{
				$this->errors['username'] = "email required";
				 $_SESSION['validationError'] = $this->errors;
				 return;
				
		}
		if (strpbrk($username , "\"';\\<>&%!|#$") !== false)
		{
			$this->errors['username'] = "username can't have these \"';\\<>&%!|#$ charchters";
			 $_SESSION['validationError'] = $this->errors;
			 return;
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
			 $_SESSION['validationError'] = $this->errors;
			 return;
		}
	if (strlen($username)>16)
		{
			$errors['username'] = "username is too long" ;
			 $_SESSION['validationError'] = $this->errors;
			 return;
		}
		return true;
	}
}
