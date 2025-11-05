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

	public function CreateUser($id, $userName, $email, $password)
	{
		$query = "INSERT INTO users (email, username, email, password) VALUES (:id, :username, :email, :password)";
		$stmt = $db -> prepare($query);
		$stmt -> execute
			(
			[
			'id' => $id,
			'username' => $userName,
			'email' => $email,
			'password' => $password
			]
			);
	}
	

}
