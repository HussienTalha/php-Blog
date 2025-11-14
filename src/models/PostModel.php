<?php

namespace Models;

use App;

class PostsModel extends 
{
	public function __construct()
	{
		$this -> db = App::$db;
	}

	public function createPost($author, $title , $content, $image, $category)
	{
		$user_id = (new UserModel())-> getUser('id', 'username', $author);
		$category_id = (new CategoryModel()) -> getCategoryId($category);

		$query = "INSERT INTO posts (id, created_at, title , status, content, image, user "
	
	}

}
