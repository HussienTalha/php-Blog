<?php
namespace App;

session_start();
class App{
	public static App $app;
	private static DB $db;
	public Router $router;
	public Request $request;
	public Response $response;
	public View $view;
	public function __construct(){

		self::$app =$this ;	
		$this -> request = new Request();
		$this -> response = new Response();
		$this -> view = new View();
		$this -> router = new Router($this -> request , $this -> response);
		static::$db = new DB();

	}
	public static function db() : DB{
		//use this function to return the created db connection static instance
		return static::$db;
	}

	public function run(){
		echo $this -> router -> resolve();
	}

}
