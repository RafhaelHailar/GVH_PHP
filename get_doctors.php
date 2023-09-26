<?php
    include "connection.php";

    $sql = "SELECT * FROM doctors_info INNER JOIN users ON doctors_info.doctor_id = users.id WHERE users.type_id = '2'";
    $getDoctors = mysqli_query($connection,$sql);

    $doctors = array();
    
    while ($result = mysqli_fetch_assoc($getDoctors)) {
        array_push($doctors,$result);
    }

    echo json_encode($doctors);
?>