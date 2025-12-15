<?php
if (session_status() !== PHP_SESSION_ACTIVE)
{
session_start();
}
require_once __DIR__."/../core/DB.php";
require_once __DIR__."/../core/config.php";

class UserProfile
{
	public DB $db;
	public PDO $pdo;
	public array $errors;
	public function __construct()
	{
		$this->db = new DB();
		$this->pdo= $this->db->getConnection();
	}

	//edit profile function

	public function getUser($email)
	{

		$query = "SELECT * FROM users WHERE email = :email";
				$stmt = $this->pdo->prepare($query);
				$stmt->execute
					(
						[
							'email' => $email,
						]
					);
				return $user = $stmt->fetch(PDO::FETCH_ASSOC);
	}
	
	public function editProfile()
	{
		
	if ($_POST['edit-email'] !== $_SESSION['account']['email'] && $_POST['edit-email'] != null)
	{
		$newEmail = trim($_POST['edit-email']);
		$this->validateEmail($newEmail);
	}
	else
	{
		$newEmail = trim($_SESSION['account']['email']);
	}

	if (isset($_POST['edit-password']))
	{
		if (isset ($_POST['confirm-password']) && $_POST['confirm-password'] === $_POST['edit-password'])
		{
			$newPassword = trim($_POST['edit-password']);
			$confirmPassword = trim($_POST['confirm-password']);
			$this->validatePassword($newPassword,$confirmPassword);	
			$password = password_hash($newPassword, PASSWORD_DEFAULT);
		}
		else
		{
			$password = trim($_SESSION['password']);
		}
	
	}
				
	if ($_POST['edit-username'] !== $_SESSION['account']['username'] && $_POST['edit-username'] != null)
	{
		$newUsername = trim ($_POST['edit-username']);
		$this->validateUsername($newUsername);
	}
	else
	{
		$newUsername = trim($_SESSION['account']['username']);
	}

	if( !empty ($SESSION['Edit-Profile-Errors']))
	{
		header("location: /views/profile.php");
		exit;
	}
	try
	{
		$query = "UPDATE users SET username = :username, email = :email , password = :password  WHERE ID = :id";
		$stmt = $this->pdo->prepare($query);
		$stmt->execute
			(
				[
					'username' => $newUsername,
					'email' => $newEmail,
					'password' => $password,
					'id' => $_SESSION['account']['ID']
				]
			);

		$account = $this->getUser($newEmail);
		 $_SESSION['account'] = $account;
		 $_SESSION['Edit-Profile-State'] = "profile edited successfully";
		header("location: /views/profile.php");
		exit;
	}
	catch(PDOException $e)
	{
		echo $e;
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

/*
	public function editPassword($oldPasswd, $newPasswd)
	{
		//still need modification by using hashing
		$id = $_SESSION['account']['ID'];
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
				$query = "UPDATE users SET password = :newpassword WHERE ID = :id";
				$stmt = $this->pdo->prepare($query);
				$stmt->execute
					(
						[
							'newpassword' => $newPasswd1,
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
		$id = $_SESSION['account']['ID'];
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

	public function editUsername($username)
	{
		$id = $_SESSION['account']['ID'];
		try 
		{
			$query = "UPDATE users SET username = :username WHERE ID = :id";
			$stmt = $this->pdo->prepare($query);
			$stmt->execute
				(
					[
						'username' => $username,
						'id' => $id
					]
				);
			return "username updated";
		}
		catch (PDOException $e) 
		{
			if ($e->getCode() == 23000)
			{
			return "username already exist enter another username";
			}
			else
			return "unexpected error occured";
		}

		
	}
	}
	 */
}
