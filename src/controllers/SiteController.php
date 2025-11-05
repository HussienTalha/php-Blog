<?php

namespace Controllers;

use App; 

class SiteController extends App\Controller
{

	
	 public function getHome()
	 {
		 return App\App::$app -> view -> render('home',[]);
	 }
}
