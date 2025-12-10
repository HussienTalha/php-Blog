<?php
if (session_status() !== PHP_SESSION_ACTIVE)
{
session_start();
}
require_once __DIR__.'/../core/DB.php';
require_once __DIR__."/../core/config.php";

class Users
{
	public DB $db;
	public pdo $pdo;
	public int $id;

	public array $errors;

	public function __construct()
	{
		$this->db = new DB();
		$this->pdo = $this->db->getConnection();
	}

	public function validateAdmin($username) //make default value the id from the session
	{
		$query = "SELECT admin FROM users WHERE username = :username";
		$stmt = $this->pdo->prepare($query);
		$stmt->execute
			(
				[
					'username' => $username
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



	public function createUser()
	{	
		$username = trim($_POST['username']);
		$email = trim($_POST['email']);
		$passwd =trim($_POST['password']);
		$confirmPW = trim($_POST['confirmPassword']);
		$admin = trim($_POST['admin']);

		$this->validatePassword($passwd, $confirmPW);
		$this->validateEmail($email);
		$this->validateUsername($username);
		if (! empty ($_SESSION['validationError']))
		{
			header ("location: createUser.php");
			exit ;
		}
		$passwd = password_hash($passwd, PASSWORD_DEFAULT);

		try
		{
			$query = "INSERT INTO users (username, email, password, admin) values (:username, :email, :password, :admin)";
			$stmt = $this->pdo->prepare($query);
			$stmt->execute
				(
						[
						'username' => $username,
						'email' => $email,
						'password' => $passwd,
						'admin' => $admin
						]
				);
			return 'user created successully';
		}
		catch (PDOException $e)
		{
			return "unexpected error";
		}
	}
	public function deleteUser($username)
	{

			if(! isset($_SESSION['account']['admin']) )
			{

				return "not authorized to delete users";
			}
			if (($this->validateAdmin($username)) && ! isset($_SESSION['account']['superAdmin']))
			{

				return "not authorized to delete admin's profile";
			}
			else
			{
			try
			{
				$query = "DELETE FROM users WHERE username = :username";
				$stmt = $this->pdo->prepare($query);
				$stmt->execute
					(
						[
							'username' => $username
						]
					);
				
				if ($stmt->rowCount() > 0)
				{
					return "User $username is deleted";
				}
				else 
				{
					return "couldn't find the username $username";
				}
			}
			catch (PDOException $e)
			{
				 return "unexpected error $e";
			}
			}
	}
	
	public function getAdmins()
	{
		$query = "SELECT * FROM users WHERE admin = 1";
		$stmt = $this->pdo->prepare($query);
		$stmt->execute();
		return $stmt->fetchAll(PDO::FETCH_ASSOC);
	}

 	public function getUsers()
	{
		$query = "SELECT * FROM users";
		$stmt = $this->pdo->prepare($query);
		$stmt->execute();
		return $stmt->fetchAll(PDO::FETCH_ASSOC);
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
