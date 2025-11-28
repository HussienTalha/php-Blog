<?php

require_once __DIR__.'/../core/DB.php';
class UserPosts
{

	public DB $db;
	public PDO $pdo;

	public function __construct()
	{
		$this->db = new DB();
		$this->pdo = $this->db->getConnection();
	}

	//return all posts
	public function index()
	{
		$query = "SELECT posts.*, users.username, categories.category_name FROM posts LEFT JOIN users ON posts.user_id = users.ID LEFT JOIN categories ON posts.category_id = categories.category_id  ORDER BY posts.created_at";
		$stmt = $this->pdo->prepare($query);
		$stmt->execute();
		return $stmt->fetchAll(PDO::FETCH_ASSOC);
	}

	//return all user's posts
	public function profilePosts($userId)
	{
		$query = "SELECT posts.*, users.username, categories.category_name FROM posts JOIN users ON posts.user_id = users.ID JOIN categories ON posts.category_id = categories.category_id WHERE users.ID = :id";
		$stmt = $this->pdo->prepare($query);
		$stmt->execute
			(
				[
					'id' => $userId
				]
			);
		return $stmt->fetchAll(PDO::FETCH_ASSOC);
	}

	//get id of the post's author
	public function getUserId($postId)
	{
		$query = "SELECT user_id FROM posts WHERE post_id = :postId";
		$stmt = $this->pdo->prepare($query);
		$stmt->execute
			(
				[
					'postId' => $postId
				]
			);
		return $stmt->fetch(PDO::FETCH_ASSOC);
	}
	public function getCategories()
	{
		$query = "SELECT * FROM categories";
		$stmt = $this->pdo->prepare($query);
		$stmt->execute();
		return $stmt->fetch();
	}
	//get author data
	public function getAuthor($authorId)
	{
		$query = "SELECT * FROM users WHERE ID = :authorId";
		$stmt = $this->pdo->prepare($query);
		$stmt->execute
			(
				[
					'authorId' => $authorId
				]
			);
		return $stmt->fetch();
	}

	//get id of the category
	public function getCategoryId($categoryName)
	{

			$query = "SELECT category_id FROM categories WHERE category_name = :categoryName";
			$stmt = $this->pdo->prepare($query);
			$stmt->execute
				(
					[
						'categoryName' => $categoryName
					]
				);
			$categoryId =$stmt->fetch();
			if ($categoryId)
			{
				return $categoryId;
			}
			return "category not found";
	}
	//validate user id to preform actoin
	public function validateUser($userId)
	{
		if (isset($SESSION['account']))
		{
			if ($userId === $_SESSION['account']['password'])
			{
				return true;
	
			}
			else
			{
				return false;
			}
		}
		else 
		{
			header("location: http://localhost:8000/auth/login.php");
			exit;
		}

	}


	//create new post
	public function createPost($title, $status, $content, $userId, $categoryName)
	{
		if ($userId)
		{
			$categoryId = $this->getCategoryId($categoryName);
			if (is_int($categoryId))
			{
				try
				{
					$query = "INSERT INTO posts (title , status, content, user_id, category_id) VALUES (:title, :status, :content, :user_id, category_id)";
					$stmt = $this->pdo->prepare($query);
					$stmt->execute
						(
							[
								'title' => $title,
								'status' => $status,
								'content' => $content,
								'user_id' => $userId,
								'category_id' => $categoryId
							]
						);
					return "post created susccefully";
				}
				catch (PDOException $e)
				{
					echo "unexpected error happened";
				}
			}
			return $categoryId;

		}
		return "log in to create a post";
	}
	
	//delete post
	public function deletePost($postId,$authorUsername)
	{
		if ($authorUsername === $_SESSION['account']['username']) 
		{
			$query = "DELETE FROM posts WHERE post_id = :postId";
			$stmt = $this->pdo->prepare($query);
			$stmt->execute
				(
					[
						'postId' => $postId
					]
				);
			return  "post deleted succesfully";
		}
		else
			return "can't delete this post";
	}

	//edit post
	public function editPost($authorUsername, $postId, $title, $content, $categoryName, $status)
	{
		$categoryId = $this->getCategoryId($categoryName);

		if ($authorUsername === $_SESSION['account']['username'])
		{
			try{
		$query = "UPDATE posts SET title = :title ,content = :content , status = :status , category_id = :category_id WHERE post_Id = :postId";
		$stmt = $this->pdo->prepare($query);
		$stmt->execute
			(
				[
					'title'	=> $title,
					'content' => $content,
					'status' => $status,
					'category_id' => $categoryId
				]
			);
			return "post edited succefully";
			}
			catch(PDOException $e)
			{
			return "unexpected error happened";
			}
		}
		return "you can't edit this post";
	}
	//read one post
	public function readPost($postId)
	{
		$query = "SELECT posts.* , users.username, categories.category_name FROM posts JOIN users ON posts.user_id = users.ID JOIN categories ON posts.category_id = categories.category_id WHERE post_id = :id";
		$stmt = $this->pdo->prepare($query);
		$stmt->execute
			(
				[
					'id' => $postId
				]
			);
		return $stmt->fetch();
	}
}
