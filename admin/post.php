<?php
require_once __DIR__."/../core/DB.php";
use pdo;

class Post 
{
	public DB $db;
	public pdo $pdo;
	public int $id;
	public function __construct()
	{
		$this->db = new DB();
		$this->pdo = $this->db->getConnection();
	}

	public function validate()
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
		{
			return null;
		}
	}

	public function deletePost($postId)
	{
		if ($this->validate())
		{
			try
			{
				$query = "DELETE FROM posts WHERE post_id = :postId";
				$stmt = $this->pdo->prepare($query);
				$stmt->execute
					(
						[
							'postId' => $postId
						]
					);
				return "post deleted succefully";
			}
			catch (PDOException $e)
			{
				return "unexpected error happened $e";
			}
		}
		else
		{
			return "not authorized to delete this post";
		}
	}

}

