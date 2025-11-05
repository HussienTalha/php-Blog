<?php

namespace Controllers;
use App;

class AuthController extends App\Controller 
{

	 public function login(App\Request $request)
	 {
		if ($request -> getMethod() === 'get')
		{
			return $this -> render('login',[]);
		}

		$body = $request -> getBody();
		echo '<pre>';
		var_dump($body);
		echo '</pre>';

		return "handling data";	 
	 }

	public function register(App\Request $request)
	{
		if ($request -> getMethod() === 'get')
		{
			return $this -> render('register',[]);
		}
		
		$registerModel = new RegisterModel();

		$body = $request -> getBody();
		echo '<pre>';
		var_dump($body);
		echo '</pre>';

		return "handling data";	 
	}
}
