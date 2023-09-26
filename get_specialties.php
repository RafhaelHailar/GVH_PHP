<?php
    include "connection.php";

    $method = $_SERVER['REQUEST_METHOD'];

    if ($method == "GET") {
        $getSpecialties = "SELECT * FROM specialties";
        $specialties = mysqli_query($connection,$getSpecialties);
        
        $result = array();
        
        while ($specialty = mysqli_fetch_assoc($specialties)) {
            array_push($result,$specialty);
        }
    
        echo json_encode($result);
    } else if ($method == "POST") {
        $id = $_POST['id'];
        $getSpecialty = "SELECT * FROM specialties WHERE `id` = '$id'";
        $getSpecialtyRun = mysqli_fetch_assoc(mysqli_query($connection,$getSpecialty));

        echo json_encode($getSpecialtyRun);
    }
?>