<?php 
namespace Models;

use App;

class CategoryModel
{
	 public function __construct()
	 {
	 	$this -> db = App::$db;
	 }

	 public function addCategory($category)
	 {
	 	$query = "INSERT INTO categories (category_name) VALUES (:category)";
		$stmt = $db -> prepare($query);
		$stmt -> execute
			(
				[
					'category' = $category
				]
			);
	 }

	 public function getCategoryPosts($category)
	 {
		$query = "SELECT categories.category_name, posts.content, posts.title, posts.user_id WHERE category_name = :category)";
		$stmt = $dn -> prepare($query);
		$stmt -> execute
			(
				[
					'category' = $category;	
				]
			);
		return $stmt -> fetchAll(PDO::FETCH_ASSOC);
	 }
	 public function getCategoryId($category):string:
	 {
		$query = "SELECT category_id FROM categories WHERE category_name = :category";
		$stmt = $this -> db -> prepare($query);
		$stmt -> execute
			(
				[
					'category' = $category
				]
			)
		return $stmt fetch(PDO::FETCH_ASSOC);
	 }
    		
