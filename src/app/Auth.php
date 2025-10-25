<?php

namespace App;

class Auth
{
	public function __construct(){
		$db = App::db();
	}

	public function add_user(string $username, string $password ,string $email ,bool $role)
	{
		$username = trim($username);
		$password = trim ($password);

		$hash = password_hash($password , PASSWORD_DEFAULT);
		if ($hash === false){
			return false;
		}
		if ($hash === null){
			throw new \Exception ("Invalid hashing algorithm !");

		}
	try
	{
	$qurey = "insert into users (username, email, password,admin) values (:username, :email, :password, :admin)";
	$stmt = $this -> $db -> prepare($query);
	$stmt -> execute(
		[
	":username" => $username;
	":email" => $email;
	":password" => $hash;
	":admin" => $admin;
		]
	);
	}
	catch(\PDOException $e)
	{
		error_log($e -> getmessage());
		false;
	}
	$id = $this -> db -> lastInsertId();

	if($id === false)
	{
		return false;
	}
	return $id;
}
}
