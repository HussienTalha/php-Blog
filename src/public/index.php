<?php


spl_autoload_register(function($class){
    $path = __DIR__ .'/../'.lcfirst(str_replace('\\','/',$class)).'.php';
    require $path;
    /*register the autoload function which is triggered whenever we use a class
	    that hasn't been loaded it recieves the fully qualified class name and loads */
}); 

$app = new App\App();

    $app->run();
