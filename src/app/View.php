<?php
namespace App;

class View{

		protected string $view;
		protected array $params = [];
		protected function render($viewfile)
		{
		$this-> view = $viewfile;
		$layoutContent = $this -> layoutContent();
	        $viewContent = $this -> viewContent();	
		return str_replace('{{content}}', $layoutContent,$viewContent);

	}
	protected function layoutContent()
	{
	$path = __DIR__ .'/../Views/layouts/main.php';
		ob_start;
	include $path;
	return ob_get_clean();
	}

	protected function viewContent(){

		foreach ($params as $key => $value){
			$$key = $value;
		}	
	$path = __DIR__ .'/../Views/'.$this -> view.'.php';
ob_Start;
include $path;
return ob_get_clean();
	}
}

