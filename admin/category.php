<?php
use PDO;

require_once __DIR__."../core/DB.php";

class Category
{
	public DB $db;
	Public pdo $pdo;
	public int $id;
	//todo assign id variable to the user id stored in the session after making the auth

	public function __construct()
	{
		$this->db = new DB();
		$this->pdo = $this->db->getConnection();
	}

	public function validateAdmin()
	{
		$query = "SELECT admin FROM users WHERE ID = :id";
		$stmt = $this->pdo->prepare($query);
		$stmt->execute
			(
				[
					'id' => $this->id
				]
			);
		$admin = $stmt->fetch();

		if ($admin)
		{
			return $admin;
		}
		else 
			return null;
	}

	public function addCategory($categoryName)
	{
		if ($this->validateAdmin())
		{
			try
			{
				$query = "INSERT INTO categories (category_name) values (:categoryName)";
				$stmt = $this->pdo->prepare($query);
				$stmt->execute
					(
						[
							'categoryName' => $categoryName
						]
					);
				return "category added succefully";
			}
			catch (PDOException $e)
			{
				return "unexpected error happened";
			}
		}
		else
			return "not authorized to add category";
	}

	public function deleteCategory($categoryName)
	{
		if ($this->validateAdmin())
		{
			try
			{
				$query = "DELETE FROM categories WHERE category_name = :categoryName";
				$stmt = $this->pdo->prepare($query);
				$stmt->execute
					(
						[
							'categoryName' => $categoryName
						]
					);
				return "category deleted";
			}
			catch (PDOException $e)
			{
				return "unexpected error $e";
			}
		}
		else
		{
			return "not authorized to delete category";
		}
	}


	public function editCategory($oldCategory , $newCategory)
	{
		if ($this->validateAdmin())
		{
			try
			{
				$query = "UPDATE categories set category_name = :newCategory WHERE category_name = oldCategory";
				$stmt = $this->pdo->prepare($query);
				$stmt->execute
					(
						[
							'oldCategory' => $oldCategory,
							'newCategory' => $newCategory
						]
					);
				return "category updated";
			
			}
			catch (PDOException $e)
			{
				return "unexpected error $e";
			}

		}
	}
}
