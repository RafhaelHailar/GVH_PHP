<?php
    include "connection.php";

    $email = mysqli_real_escape_string($connection,$_POST['email']);
    $password = mysqli_real_escape_string($connection,$_POST['password']);
    $firstName = mysqli_real_escape_string($connection,$_POST['firstName']);
    $lastName = mysqli_real_escape_string($connection,$_POST['lastName']);
    $birthDay = mysqli_real_escape_string($connection,$_POST['birthDay']);
    $birthMonth = mysqli_real_escape_string($connection,$_POST['birthMonth']);
    $birthYear = mysqli_real_escape_string($connection,$_POST['birthYear']);
    $address = mysqli_real_escape_string($connection,$_POST['address']);
    $city = mysqli_real_escape_string($connection,$_POST['city']);
    $region = mysqli_real_escape_string($connection,$_POST['region']);
    $zip =  mysqli_real_escape_string($connection,$_POST['zip']);
    $birthDate = "$birthYear-$birthMonth-$birthDay";
    $user_type = 4;

    if (isset($_POST['user_type'])) $user_type = $_POST['user_type'];
    if (isset($_POST['number'])) $number = $_POST['number'];

    $sql = "INSERT INTO users (`email`,`password`,`type_id`,`firstname`,`lastname`,`number`,`birthdate`,`address`,`city`,`region`,`zip`) VALUES ('$email','$password','$user_type','$firstName','$lastName','$number','$birthDate','$address','$city','$region','$zip')";
    mysqli_query($connection,$sql);

    if ($user_type == 2) {
        $getDocId = "SELECT id FROM users WHERE `email` = '$email'";
        $docId = mysqli_fetch_assoc(mysqli_query($connection,$getDocId))['id'];
        $specialty = $_POST['specialty'];
        $experience = $_POST['experience'];
        $createDocInfo = "INSERT INTO doctors_info (`doctor_id`,`specialty_id`,`experience`) VALUES ('$docId','$specialty','$experience')";
        mysqli_query($connection,$createDocInfo);
    }
?>