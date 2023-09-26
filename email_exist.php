<?php
    include "connection.php";

    if ($_POST['email']) $email = $_POST['email'];

    $checkEmail = "SELECT * FROM users WHERE email = '$email'";
    $user = mysqli_num_rows(mysqli_query($connection,$checkEmail));
    if ($user > 0) echo "Email Exist!";
    else echo "";
?>