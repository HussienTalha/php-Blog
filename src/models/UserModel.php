<?php 
namespace Models;
use App;
class UserModel extends CRUD
{
	int $id;
	string $userName;
	string $email;
	string $password;
	string $table = 'users';
	public function __construct()
	{
		$this -> db = App::$db();
	}

	public function CreateUser($userName, $email, $password)
	{
		$query = "INSERT INTO users (username, email, password) VALUES (:username, :email, :password)";
		$stmt = $db -> prepare($query);
		return $stmt -> execute
			(
			[
			'username' => $userName,
			'email' => $email,
			'password' => $password
			]
			);
	}

	public function getUserPosts($userId)
	{
		$query = "SELECT users.username , posts.content FROM users INNER JOIN posts on user.id = posts.user_id WHERE user.id = :id";
		$stmt = $db -> prepare($query) ;
		$stmt -> execute
			(
				[
					'id' = $userId;
				]
			);
	
	}
	public function getUser($column, $condition, $value)
	{
		$query = "SELECT :column FROM users WHERE :condtion = :value";
		$stmt = $this -> db -> prepare($query);
		$stmt -> execute
			(
				[
					'column' = $column,
					'condition' = $condition,
					'value' = $value
				]
			);
		return $stmt ->  fetchAll(PDO::FETCH_ASSOC);
	}
    		
}
