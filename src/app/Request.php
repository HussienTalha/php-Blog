<?php
namespace App;

class Request{
	
public function getPath(){

	$uri = $_SERVER['REQUEST_URI']?? '/';

	$path = explode ('?' , $uri)[0] ; 

	return $path ;
		
}
	public function getMethod(){
		$method  = $_SERVER['REQUEST_METHOD'];
		return $method;
	}
}
