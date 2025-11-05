<?php

namespace App;

class Controller
{
	public function render ($view , $params = [])
	{
		return App::$app -> view -> render ($view , $params);
	}
}


