<?php
$routes = [];
//Enable CORS
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, DELETE, PUT, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

$requestUri = $_SERVER['REQUEST_URI'];
$requestMethod = $_SERVER['REQUEST_METHOD'];

$routes =
       	[
			'posts' => __DIR__.'/routes/posts.php',
			'user' => __DIR__.'/routes/user.php',
			'category'=> __DIR__.'/routes/category.php',
			'admin'=> __DIR__.'/routes/admin.php',
			'404' => ''
	];

function resolve($requestUri)
{
$requestedResource = explode('/', $requestUri);
$requestedResource = $endpoint[0];
foreach ($routes as $resource => $file)
{
	if ($resource === $requestedResource)
	{
		require_once $file;
		exit;
	}
	else if ($resource === '404')
	{
		('Content-Type: Application/json');
		http_response_code(404);
		return json_encode(
			'message' => 'Not Found'
		);
	}
}
}

