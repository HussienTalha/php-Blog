<?php
namespace \App;

class Router{
	private $routes[];
	public function register(string $method, string $route, callable|self $action) :self{
		if is_callable($action){
		$this -> routes[$route] = $action;
		}
		if is_array($action){
			[$class,$method] = $action;
			if (class_exists($class){
			  $class = new $class();
			  if (method_exists($class,$method)){
			  	call_user_func_array([$class, $method],[]);
			  }
			}
		}
		return $this;
	}

	public function resolve(string $request_method,string $uri){
		$route = explode(?, $uri)[0];
		$action = $routes[$route] ;
	}

}
