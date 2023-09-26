<?php
    include "connection.php";

    $email = $_POST['email'];
    $password = $_POST['password'];
    
    if (!isset($email) || $email == "") exit("Provide Email!");
    if (!isset($password) || $password == "") exit("Provide Password!");

    $email = mysqli_real_escape_string($connection,$_POST['email']);
    $password = mysqli_real_escape_string($connection,$_POST['password']);

    $sql = "SELECT * FROM users WHERE `email` = '$email' AND `password` = '$password'";
    $account = mysqli_fetch_assoc(mysqli_query($connection,$sql));
    
    if ($account == "" || !$account) exit();
    
    $autherization_code = md5(rand()) . $account["email"];

    $updateSC = "UPDATE users SET `authentication_code` = '$autherization_code' WHERE `email` = '$email'";
    mysqli_query($connection,$updateSC);

    $data = array(
        "cru" => $account["id"],
        "sc" => $autherization_code
    );

    echo json_encode($data);
?>