<?php 
namespace App;
use \Pdo;
class DB{
private PDO $pdo;
public function __construct() {
    try {
        $this->pdo = new PDO(
            'mysql:host=mysql;dbname=myapp;charset=utf8mb4',
            'root',
            'root',
        );
    } catch (PDOException $e) {
        // Log the error and re-throw
        error_log("Database connection error: " . $e->getMessage());
        throw new Exception("Database connection failed");
    }
}public function __call(string $method, array $args){

    return call_user_func_array([$this -> pdo ,$method]  ,$args);

    /*this enable us to invoke pdo methods using $db static object of
        DB class without using inheritance and extending the pdo class*/    

}
}
