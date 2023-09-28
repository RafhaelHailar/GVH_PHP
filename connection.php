<?php
    if (isset($_SERVER['HTTP_ORIGIN'])) {
        $origin = $_SERVER['HTTP_ORIGIN'];
        $allowed_origins = array("http://localhost:3000","http://localhost:3001");
    
        if (isset($_SERVER['HTTP_ORIGIN']) && in_array($origin,$allowed_origins)) 
        header("Access-Control-Allow-Origin: $origin");
    }

    $server = 'localhost';
    $username = 'root';
    $password = '';
    $database = 'gvh_hospital';
    
    try {
        $connection = mysqli_connect($server,$username,$password,$database);
    } catch(Exception $error) {
        http_response_code(500);
    }
?>