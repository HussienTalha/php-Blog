<?php
spl_autoload_register(function($class){

	
    $path = __DIR__ .'/../'.lcfirst(str_replace('\\','/',$class)).'.php';
    require $path;
    /*register the autoload function which is triggered whenever we use a class
	    that hasn't been loaded it recieves the fully qualified class name and loads */
}); 
$app = new App\App();
$app -> router -> get('/',[Controllers\SiteController::class,'getHome']);
$app -> router -> get('/login',[Controllers\AuthController::class,'login']);
$app -> router -> post('/login',[Controllers\AuthController::class,'login']);
$app -> router -> get('/register',[Controllers\AuthController::class,'register']);
$app -> router -> post('/register',[Controllers\AuthController::class,'register']);
$app -> router -> get('/categories', [Controllers\SiteController::class,'getCategories']);
$app -> router -> get('/profile',[Controllers\SiteController::class,'getProfile']);
$app->run();
