<?php
    include "connection.php";

    $id = $_POST['id'];
    $getDoctor = "SELECT * FROM users INNER JOIN doctors_info ON users.id = doctors_info.doctor_id WHERE users.id = '$id'";
    $getDoctorRun = mysqli_fetch_assoc(mysqli_query($connection,$getDoctor));

    echo json_encode($getDoctorRun);
?>