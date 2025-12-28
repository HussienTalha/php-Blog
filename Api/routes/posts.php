<?php 
require_once __DIR__.'/../user/usersPosts.php';
require_once __DIR__.'/../middleware/auth.php';
require_once __DIR__.'/../middleware/role.php';
$posts = new UserPosts();

$authMiddleware = new AuthMiddleware();
$roleMiddleware = new RoleMiddleware();
$requestMethod = $_SERVER['REQUEST_METHOD'];
$requestUri = $_SERVER['REQUEST_URI'];
switch ($requestMethod)
{
	case 'GET':
		if (preg_match('#^/posts(?:/(\d+))?$#',$requestUri , $matches,PREG_UNMATCHED_AS_NULL))
		{
			$id = $matched[1];
			if ($id)
			{
			try
			{
			$data = $this->posts->readPost($id);
			http_response_code(200);
			header('content-type: application/json');
			return json_encode
				(
					[
						'data' => $data, 
						'message' => "the post with the id $id",
						'errors' => null
					]
				);
			}
			catch(Exception $e)
			{
				
				http_response_code(500);
				return json_encode
					(
					[
					 'message' =>"something went wrong try again later",
					 'errors' => $e
					]
				);
			}
			
			}
			else 
			{
				try
				{
				$data = $this->posts->index();
				http_response_code('200');
				header('content-Type: application/json');
			return	json_encode
					(
						[
							'data' => $data,
							'message' => 'posts list',
							'errors' => null,	
						]
					);
			}
			catch(Exception $e)
			{
				
				http_response_code(500);
				return json_encode
					(
					[
					 'message' =>"something went wrong try again later",
					 'errors' => $e
					]
				);
			}
				
			}
		}
		else if (preg_match('#^/posts/profile/(\d+)$#',$requestUri, ))
		{
			$profileId = $matches[1];
			try
			{
				$data = $this->posts->profilePosts($id);
				http_response_code(500);
				return json_encode
					(
						[
							'data' => $data,
							'message' => "list of the user $profileId",
							'error' => null
						]
					);
			}
			catch(Exception $e)
			{
				http_response_code(500);
				return json_encode
					(
					[
					 'message' =>"something went wrong try again later",
					 'errors' => $e
					]
				);
			}
		}
	case 'POST':

		if ($this->authMiddleware->checkAuth())
		{
		if (preg_match('#^/posts$#',$requestUri,$matches))
		{
			$data = json_decode(file_get_contents('php://input'),true);
			try
			{
			$message = $this->posts->createPost

				(
					$data['title'],
					'created',
					$data['content'],
					$id,
					$data['categoryName']
				);
			http_response_code(204);
			return json_encode
				(
				[
					'message' => $message,
					'errors' => null
				]
			);
			}
			catch(Exception $e)
			{
				http_response_code(500);
				return json_encode
					(
					[
					 'message' =>"something went wrong try again later",
					 'errors' => $e
					]
				);
			}

		}
		}
		else 
		{
			http_response_code(401);
			return json_encode
				(
					[
						'message' => 'unauthorized'
					]
				);
		}
	case 'PUT': 
		if ($this->authMiddleware->checkAuth())
		{
		if (preg_match('#^/posts/(\d+)$#',$requestUri,$matches))
		{
		
			$id = $matches[1];
			$data = json_decode(file_get_contents('php://input'),true);
			try
			{
			$message = $this->posts->editPost
				(
					$id,
					$data['post_Id'],
					$data['user_id'],
					$data['title'],
					$data['cotent'],
					$data['categoryName'],
					'edited'
				);
			http_response_code(204);
			return json_encode(
				[
					'message' => $message,
					'errors' => null	
				]
			);
			}
			catch(Exception $e)
			{
				http_response_code(500);
				return json_encode
					(
					[

					 'message' =>"something went wrong try again later",
					 'errors' => $e
					]
				);
			}

		}
		}
		else 
		{
			http_response_code(401);
			return json_encode
				(
					[
						'message' => 'unauthorized'
					]
				);
		}
	case 'DELETE':
		if ($this->authMiddleware->checkAuth())
		{
		if (preg_match('#^posts/(\d+)$#',$requestUri,$matches))
		{
			$id = $matches[1];
			$data = json_decode(file_get_contents('php://input'), true);
			try 
			{
				$message = $this->posts->deletePost($matches[2], $matches[1]);
				http_response_code(204);
				return json_encode
						(
						[
							'message' => $message,
							'errors' => null
						]
						);
			}
			catch(Exception $e)
			{
				http_response_code(500);
				return json_encode
					(
					[

					 'message' =>"something went wrong try again later",
					 'errors' => $e
					]
				);
			}
			

		}
		}
		else 
		{
			http_response_code(401);
			return json_encode
				(
					[
						'message' => 'unauthorized'
					]
				);
		}
}
