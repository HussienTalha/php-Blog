<?php
if (session_status() !== PHP_SESSION_ACTIVE)
{
session_start();
}

require_once __DIR__.'/../core/DB.php';
require_once __DIR__."/../core/config.php";
require_once __DIR__.'/JWT.php';

class Login
{

		public DB $db;
		public pdo $pdo;
		public $data;

		public $jwt;
		public function __construct()
		{
			$this->db = new DB();
			$this->pdo = $this->db->getConnection();
			$this->jwt = new JWT();
			$this->data = json_decode(file_get_contents('php://input'),true);
		}

	
		public function getUser()
		{
			$email = trim($this->data['email']);
			$password = trim($this->data['password']);

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
					http_response_code(400);
					header('content-type: application/json');
					return json_encode
						(
							[
								'messege' => 'wrong email'
							]
						);
				}
				else
				{
					$pass = password_verify($password, $user['password']);
					if (! $pass)
					{
						http_response_code(400);
						header('content-type: application/json');
						return json_encode
							(
								[
									'messege' => 'wrong password'
								]
						);
					}
					else
					{
						$token = $this->jwt->createToken($user);
						$_SESSION['toke'] = $token;
						header('content-type: Application/json');
						http_response_code(200);
						return json_encode
							(
								[
									'data' =>
								       		[
											'token' => $token,
											'username' => $user['username'],
											'id' => $user['ID']
	
											],
									'messege'=> 'user logged in',
									'errors' => null

								
								]
							);
					}
				}
			}
			catch (PDOException $e)
			{
						header('content-type: Application/json');
						http_response_code(400);
						return json_encode
							(
								[
									'messege'=> 'something went wrong',
									'errors' => $e
								]
							);
			}
		}

}
