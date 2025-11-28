<?php
session_start();
require_once __DIR__."/../core/DB.php";
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
				
	if ($_POST['edit-username'] !== $_SESSION['account']['username'] && $_POST['edit-email' != null])
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
		header("location: Root/views/profile.php");
		exit;
	}
	try
	{
		$query = "UPDATE users SET (username, email, password) values (:username, :email, :password)";
		$stmt = $this->pdo->prepare($query);
		$stmt->execute
			(
				[
					'username' => $newUsername,
					'email' => $newEmail,
					'password' => $password
				]
			);
		$_SESSION['Edit-Profile-State'] = "profile edited successfully";
		exit;
	}
	catch(PDOException $e)
	{
		$_SESSION['Edit-Profile-State'] = "unexpected error happened";
		exit;
	}


	}
	public function validatePassword($password, $confirmPassWD)
	{	
		if (! isset($_POST['password']))
		{
			$this->errors['password'] = "enter a password";
			return $_SESSION['Edit-Profile-Errors'] = $this->errors;

		}
		if (! isset($_POST['confirmPassword']))
		{
			$this->errors['password'] = "confirm the password";
			return $_SESSION['Edit-Profile-Errors'] = $this->errors;

		}
		if ($password !== $confirmPassWD)
		{
			$this->errors['password'] = 'enter the password correctly';
			return $_SESSION['Edit-Profile-Errors'] = $this->errors;

		}
		if (strpbrk($password ,"';\\<>&%!|#$") !== false)
		{
			$this->errors['password'] = " password can't have any of these chrchters \"';\\<>&%!|#$";
			return $_SESSION['Edit-Profile-Errors'] = $this->errors;

		}
		if (strlen($password)< 6)
		{
			$this->errors['password'] = "password is too short must be at least 6" ;
			return $_SESSION['Edit-Profile-Errors'] = $this->errors;

		}

		if (strlen($password)>16)
		{
			$this->errors['password'] = "password is too long" ;
			return $_SESSION['Edit-Profile-Errors'] = $this->errors;

		}
	}
	public function validateEmail($email)
	{
		if (! isset($_POST['email']))
		{
			$this->errors['email'] = "email required";
			return $_SESSION['Edit-Profile-Errors'] = $this->errors;;

		}
		if (! filter_var($email, FILTER_VALIDATE_EMAIL))
		{
			$this->errors['email'] = "enter valid email";
			return $_SESSION['Edit-Profile-Errors'] = $this->errors;;
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
			return $_SESSION['Edit-Profile-Errors'] = $this->errors;;
		}
		if (strpbrk($email , "\"';\\<>&%!|#$") !== false)
		{
			$this->errors['email'] = "email can't have these \"';\\<>&%!|#$ charchters";
			return $_SESSION['Edit-Profile-Errors'] = $this->errors;;
		}


		return true;
	
	}
	public function validateUsername($username)
	{	
		if (! isset($_POST['username']))
		{
				$this->errors['username'] = "email required";
				return $_SESSION['Edit-Profile-Errors'] = $this->errors;;
				
		}
		if (strpbrk($username , "\"';\\<>&%!|#$") !== false)
		{
			$this->errors['username'] = "username can't have these \"';\\<>&%!|#$ charchters";
			return $_SESSION['Edit-Profile-Errors'] = $this->errors;;
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
			return $_SESSION['Edit-Profile-Errors'] = $this->errors;;
		}
	if (strlen($username)>16)
		{
			$errors['username'] = "username is too long" ;
			return $_SESSION['Edit-Profile-Errors'] = $this->errors;;
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
