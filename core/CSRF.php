<?php
if (session_status() !== PHP_SESSION_ACTIVE)
{
session_start();
}

class CSRF
{
	public static function generateToken($name)
	{
		if (empty($_SESSION[$name]))
		{
			$token = bin2hex(random_bytes(32));
			$_SESSION[$name]= $token;
		}
		return $_SESSION[$name];

	}

	public  function validateToken($token , $name)
	{
		if (empty($_SESSION[$name]))
		{
		return false;
		}
		else if (! hash_equals($token , $_SESSION[$name]))
		{
		return false;
		}
		
		else if (hash_equals($_SESSION[$name],$token ))
		{
			unset($_SESSION[$name]);
			return true ;
		}
	}

	public static function getTokenField($name)
	{
		$token = self::generateToken($name);
		$field = '<input type="hidden" name="'.htmlspecialchars($name).'" value ="'.htmlspecialchars($token).'">';
			return $field;
	}
}
