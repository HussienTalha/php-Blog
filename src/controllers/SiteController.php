<?php

namespace Controllers;

use App; 
use Models;
class SiteController extends App\Controller
{

	public Models\CRUD $crud;
	public Models\Posts $posts;
	public function __construct()
	{	
		$this-> crud = Models\CRUD::getInstance();
	}
	 public function getHome()
	 {
		 //invoke the method readAll from CRUD model
		 $homePosts = $this -> crud -> readAll('posts','content');
		 return App\App::$app -> view -> render('home',$homePosts);
	 }
	 public function getCategories()
	 {
		 //invoke readAll from CRUD model

		 $categories = $this -> crud -> readAll('categories','category_name');
	 	return App\App::$app -> view ->render('categories',$categories);
	 }
	 public function getProfile()
	 {
		 $id = 1;
		 //get the user's posts using his id 
		$profilePosts = $this -> crud -> readByColumn('posts', 'content', 'post_id', $id);
	 	return App\App::$app -> view -> render('profile',$profilePosts);
	 }
}
