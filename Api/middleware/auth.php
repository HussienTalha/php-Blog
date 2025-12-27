<?php
require_once __DIR__.'/../JWT/JWT.php';
class AuthMiddleWare
{
	public $jwt;
	public function __construct()
	{
		$this->jwt = new JWT();
	}

function checkAuth()
{
	$headers = getallheaders();
	if (! array_key_exists('Authorization', $headers))
		return false;

	$token = $headers['Authorization'];
	$token = str_ireplace('Bearer ','',$token);
	return $this->jwt->validateToken($token);
}
}
