<?php
    include "connection.php";

    $method = $_SERVER['REQUEST_METHOD'];

    if ($method == "POST") {
        $function = $_POST['function'];
        if ($function == 1) {
            if (isset($_POST['id'])) {
                $type = $_POST['type'] . "_id";
                $getAppointments = "SELECT * FROM appointments WHERE `$type` = '$_POST[id]'";
            } else $getAppointments = "SELECT * FROM appointments";
    
            $sqlResult = mysqli_query($connection,$getAppointments);
            $appointments = array();
            while ($result = mysqli_fetch_assoc($sqlResult)) {
                array_push($appointments,$result);
            }
            echo json_encode($appointments);
        } else if ($function == 2) {
            if (isset($_POST['id'])) {
                $id = $_POST['id'];
                $removeAppointment = "DELETE FROM appointments WHERE `id` = '$id'";
                mysqli_query($connection,$removeAppointment);
            }
        }
    }
?>