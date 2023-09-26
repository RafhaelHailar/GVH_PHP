<?php
    include "connection.php";

    $email = $_POST['email'];
    $token = $_POST['token'];  
    $password = $_POST['password'];

    $getUser = "SELECT * FROM users WHERE `email` = '$email' AND `verify_token` = '$token'";
    $getUserRun = $connection -> prepare($getUser);
    $getUserRun -> execute();

    if (!mysqli_fetch_assoc($getUserRun -> get_result())) {
        echo "Token Expired!";
        exit();
    }

    $getUserRun -> close();

    $new_token = md5(rand()) . $email;
    $updateUser = "UPDATE users SET `password` = '$password' , `verify_token` = '$new_token' WHERE `email` = '$email'";
    mysqli_query($connection,$updateUser);
    
    echo "PASSWORD RESET!";
?>