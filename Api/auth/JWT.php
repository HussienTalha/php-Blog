<?php
require_once __DIR__.'/../user/profile';
class JWT 
{
	private $secretKey = 'myprivatekey';
	public function __construct()
	{

		$profile = new Profile();
	}


	public function base64UrlEncode($data)
	{
		$base64 = base64_encode($data);
		$base64url = strtr($base64,'+/','-_');
		return rtrim($base64url, '=');

	}


	public function createToken($id)
	{
	$header = 
		[
			'type' => 'jwt',
			'algo' => 'hs256'		
		];
	$header_64encode = base64UrlEncode($header);

	$data = $this->profile->getUser($id);
	if ($data ['admin'] == 1)
	{
		$role = 'admin';
	}
	else
	{
		$role = 'user';
	}

	$payload =
		[
			'username' => $data['username'],
			'role' => $role,
			'created_at' => time(),
			'expire+at' => time() + 3600
		];

	$payload_64encode = base64UrlEncode($payload);

	$signature = hash_hmac('sha256', $header_64encode.'.'$payload_64encode,$this->secretKey,true);

	$signature_64encode = base64UrlEncode($signature);

	$token = "$header_64encode.$header_64encode.$signature_64encode";
	return $token;
	}

	public function decodeToken($data)
	{
		$data64 = strtr($data ,'-_','+/');
		$data64_paded = str_pad($data64, strlen($data64) % 4, '=',STR_PAD_RIGHT);
		$data = base64_decode($data64_paded); 
		return $data;
	}


	public function validateToken($token)
	{
		$token_64encode = explode('.',$token);
		$header_64encode= $token_64encode[0];
		$payload_64encode = $token_64encode[1];
		$signature_64encode = $token_64encode[2];
		$signature = $this->decodeToken($signature_64encode);
		$calculatedSignature = hash_hmac('sha256',$header_64encode.'.'$payload_64encode,$this->secretKey,true);
		return hash_equals('h256',$signature, $calculatedSignature);
	}
}
