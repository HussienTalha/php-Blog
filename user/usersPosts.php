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
		//todo after authentication
	
	}


	//return all posts
	public function index()
	{
		$query = "SELECT posts.*, users.username, categories.category_name FROM posts LEFT JOIN users ON posts.user_id = users.ID LEFT JOIN categoroies ON posts.category_id = categories.category_id  ORDER BY posts.created_at";
		$stmt = $this->pdo->prepare($query);
		$stmt->execute();
		return $stmt->fetchAll(PDO::FETCH_ASSOC);
	}

	//return all user's posts
	public function profilePosts($userId)
	{
		$query = "SELECT posts.*, users.username, categorires.category_name FROM posts JOIN users ON posts.user_id = users.ID JOIN categories ON posts.category_id = categories.category_id WHERE users.ID = :id";
		$stmt = $this->pdo->prepare($query);
		$stmt->execute
			(
				[
					'id' => $userId
				]
			);
		return $stmt->fetchAll(PDO::FETCH_ASSOC);
	}

	//create new post
	public function createPost($title, $status, $content, $image, $userId, $categoryName)
	{
		if ($userId)
		{
			$categoryId = $this->getCategoryId($categoryName);
			if (is_int($categoryId))
			{
				try
				{
					$query = "INSERT INTO posts (title , status, content, image, user_id, category_id) VALUES (:title, :status, :content, :image, :user_id, category_id)";
					$stmt = $this->pdo->prepare($query);
					$stmt->execute
						(
							[
								'title' => $title,
								'status' => $status,
								'content' => $content,
								'image' => $image,
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
	public function deletePost($postId)
	{
		$userId = $this->getUserId($postId);
		if ($this->validateUser($userId))
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
	public function editPost($userId, $postId, $title, $content, $status, $image)
	{
		if ($this -> validateUser($userId))
		{
		$query = "UPDATE posts SET title = :title ,content = :content , status = :status , image = :image WHERE post_Id = :postId";
		$stmt = $this->pdo->prepare($query);
		$stmt->execute
			(
				[
					'userId' => $userId,
					'postId' => $postId,
					'title'	=> $image,
					'content' => $content,
					'status' => $status,
					'image'	=> $image
				]
			);
			return "post edited succefully";
		}
		return "can't edit this post";
	}
	//read one post
	public function readPost($postId)
	{
		$query = "SELECT * FROM posts WHERE post_id = :id";
		$stmt = $this->pdo->prepare($query);
		$stmt->execute
			(
				[
					'id' => $postId
				]
			);
	}
}
