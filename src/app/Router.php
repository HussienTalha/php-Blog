<?php

namespace App;

class Router{
	protected array $routes = [];
	public Request $request;
	public Response $response;
	public View $view;
	public function __construct( Request $req, Response $res)
	{
		
		$this -> request = $req;
		$this -> response = $res;
	}
	public function post(
		string $route,
		callable|array $action
	)
	:self
	{
		return $this -> register(post , $route , $action);
	}


	public function get(
		string $route,
		callable|array $action
	)
	:self
	{
		return $this -> register(get , $route , $action);
	}



	public function register(
		string $method,
		string $route,
		callable|self $action
	)
	:self
	
	{
		$this -> routes[$method][$route] = $action;
		return $this;
	}



	public function resolve()
	{
		$route = $this -> request -> getPath();
		$method = $this -> request -> getMethod();

		$action  = $this -> routes[$method][$route] ?? false ;

		if ($action === false)
		{
			$this -> response -> setStatusCode(404);
			echo " 404 Not Found";
			exit;
		}
		if (is_callable($action))
		{
			 return call_user_func($action);
		}

		if (is_array($action))
		{
          		[$class, $method] = $action;
	
			if (class_exists($class))
			{
         			$class = new $class();

				if (method_exists($class, $method))
			  	{
                			return call_user_func_array([$class, $method], []);
 		         	 }
         		}
        	}

		if (is_string($action))

		{

	  		$this -> view = new View() ;
			$this -> view -> render($action);
			return $this -> view;
		}
	}

}
