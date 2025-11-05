<?php
namespace App;

class View
{

		protected string $view;
		protected array $params = [];

		public function render(string $viewFile, array $paramsArray)
		{
			$this-> view = $viewFile;
			$this -> params = $paramsArray;
			$layoutContent = $this -> layoutContent();
	        	$viewContent = $this -> viewContent();	
			return str_replace('{{content}}', $viewContent,$layoutContent);

		}
		protected function layoutContent()
		{
			$path = __DIR__ .'/../Views/layouts/main.php';
			ob_start();
			include $path;
			return ob_get_clean();
		}

		protected function viewContent()
		{

			foreach ($this -> params as $key => $value)
			{
				$$key = $value;
			}	
			$path = __DIR__ .'/../Views/'.$this -> view.'.php';
			ob_Start();
			include $path;
			return ob_get_clean();
		}
}

