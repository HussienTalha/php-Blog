<?php 

require_once __DIR__.'/../JWT/JWT.php';

class RoleMiddleware
{
	public $jwt;
	public function __construct()
	{
		$this->jwt = new JWT();	
	}
	public function checkRole()
	{
	$headers = getallheaders();
	if (array_key_exists('Authorization', $headers))
		return false;
    $token = str_ireplace('Bearer ','',$headers['Authorization']);
	$token = $token['Authorization'];
    if ($this->jwt->validateToken($token)== false)
        return false;
	$payload_64encoded = explode('.', $token)[1];
	$payload = json_decode($this->jwt->base64UrlDecode($payload_64encoded));
	return $payload['role'];
	}
}
