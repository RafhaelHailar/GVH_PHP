<?php 
    include "connection.php";

    $method = $_SERVER['REQUEST_METHOD'];

    if ($method == "POST") {
        $hmos_id = $_POST['hmos_id'];

        $insertHMOs = "";
        $hmos_id = explode(',',$hmos_id);
        
        for ($i = 1;$i < count($hmos_id);$i++) {
            $insertHMOs .= " OR `id` = '$hmos_id[$i]'"; 
        }

        $getHMOs = "SELECT * FROM hmos WHERE `hmo_id` = '$hmos_id[0]'";
        $getHMOs .= $insertHMOs;

        $getHMOsRun = mysqli_query($connection,$getHMOs);

        $hmos = array();

        while ($result = mysqli_fetch_assoc($getHMOsRun)) {
            array_push($hmos,$result);
        }

        echo json_encode($hmos);
    }   

?>