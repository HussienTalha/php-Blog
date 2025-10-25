<?php
namespace App;

session_start();
class App{
	private static DB $db;
	public Router $router;
	public Request $request;
	public Response $response;
	public tfunction __construct(){
		
		$this -> request = new Request();
		$this -> response = new Response();
		$this -> router = new Router($this -> request , $this -> response);
		static::$db = new DB();

	}
	public static function db() : DB{
		//use this function to return the created db connection static instance
		return static::$db;
	}

	public function run(){
		$this -> router -> resolve(
			$_SERVER["REQUEST_URI"],
			strtolower($_SERVER["REQUEST_METHOD"])
		);

	
	}

}
