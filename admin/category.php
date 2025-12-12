<?php
if (session_status() !== PHP_SESSION_ACTIVE)
{
session_start();
}
require_once __DIR__."/../core/DB.php";
require_once __DIR__."/../core/config.php";
class Category
{
	public DB $db;
	Public pdo $pdo;

	public function __construct()
	{
		$this->db = new DB();
		$this->pdo = $this->db->getConnection();
	}

	public function validateAdmin()
	{

		if ($_SESSION['account']['ID'])
		{
			return true;
		}
		else
			false;
	}

	public function addCategory($categoryName)
	{
	$categoryName = strtolower($categoryName);
	$categoryName = ucwords($categoryName);
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
				if ($stmt->rowCount() > 0)
				{
				return "category added succefully";
				}
			}
			catch (PDOException $e)
			{
				if ($e->errorInfo[1] == 1062)
				{
					return "category already exists";
				}
				return "unexpected error happened $e";
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
				$count = $stmt->execute
					(
						[
							'categoryName' => $categoryName
						]
					);
				if ($count === 1)
				{
				return "category deleted";
				}
				else if($count === 0)
				{
				return "the category $categoryName don't exist";
				}
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
	$categoryName = strtolower($categoryName);
	$categoryName = ucwords($categoryName);
		if ($this->validateAdmin())
		{
			if ($oldCategory === $newCategory)
			{
				return "you entered the same old name";
			}
			try
			{
				$query = "UPDATE categories set category_name = :newCategory WHERE category_name = :oldCategory";
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
				if ($e->errorInfo[1] == 1062)
				{
					return "you entered a category that already exists";
				}
				return "unexpected error $e";
			}

		}
	}
}
