<?php
    include "connection.php";

    $function = $_POST['function'];

    if ($function == 1) {
        $cru = $_POST['cru'];
        $sc = $_POST['sc'];
    
        $getUser = "SELECT * FROM users WHERE `id` = '$cru' AND `authentication_code` = '$sc'";
        $user = mysqli_fetch_assoc(mysqli_query($connection,$getUser));
    
        if ($user['type_id'] == 2) {
            $getInfo = "SELECT * FROM doctors_info INNER JOIN users ON doctors_info.doctor_id = users.id WHERE doctors_info.doctor_id = '$cru'";
            $user = mysqli_fetch_assoc(mysqli_query($connection,$getInfo));
        }
    
        if (!$user) exit();
        
        echo json_encode($user);
    } else if ($function == 2) {
        $id = $_POST['id'];
    
        $getUser = "SELECT * FROM users WHERE `id` = '$id'";
        $user = mysqli_fetch_assoc(mysqli_query($connection,$getUser));
    
        if ($user['type_id'] == 2) {
            $getInfo = "SELECT * FROM doctors_info INNER JOIN users ON doctors_info.doctor_id = users.id WHERE doctors_info.doctor_id = '$id'";
            $user = mysqli_fetch_assoc(mysqli_query($connection,$getInfo));
        }
    
        if (!$user) exit();
        
        echo json_encode($user);
    }
?>