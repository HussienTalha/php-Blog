<?php
require_once __DIR__.'/../user/profile.php';
class JWT 
{
	private $secretKey ;
	public function __construct()
	{

		$profile = new UserProfile();
		$this->secretKey == 'mySecretKey';
	}


	public function base64UrlEncode($data)
	{
		$base64 = base64_encode($data);
		$base64url = strtr($base64,'+/','-_');
		return rtrim($base64url, '=');

	}
	public function base64UrlDecode($data):string
	{
		$data64 = strtr($data ,'-_','+/');
		$data64_paded = str_pad($data64, strlen($data64) % 4, '=',STR_PAD_RIGHT);
		$data = base64_decode($data64_paded); 
		return $data;
	}	


	public function createToken($user)
	{
	$header = 
		[
			'type' => 'jwt',
			'algo' => 'hs256'		
		];
	$header_64encoded = $this->base64UrlEncode(json_encode($header));

	if ($user['superAdmin'] == 1)
		$rolse = 'SuperAdmin';
	else if ($user['admin'] == 1)
	{
		$role = 'admin';
	}
	else
	{
		$role = 'user';
	}

	$payload =
		[
			'username' => $user['username'],
			'role' => $role,
			'id'=> $user['ID'],
			'created_at' => time(),
			'expire_at' => time() + 3600
		];

	$payload_64encoded = $this->base64UrlEncode(json_encode($payload));

	$signature = hash_hmac('sha256', $header_64encoded.'.'.$payload_64encoded,$this->secretKey,true);

	$signature_64encoded = $this->base64UrlEncode($signature);

	$token = "$header_64encoded.$payload_64encoded.$signature_64encoded";
	return $token;
	}


	public function validateToken($token)
	{
		$token_64encoded = explode('.',$token);
		$header_64encoded= $token_64encoded[0];
		$payload_64encoded = $token_64encoded[1];
		$signature_64encoded = $token_64encoded[2];
		$signature = $this->base64UrlDecode($signature_64encoded);
		$calculatedSignature = hash_hmac('sha256',$header_64encoded.'.'.$payload_64encoded,$this->secretKey,true);
		return hash_equals ($signature, $calculatedSignature);
	}
}
