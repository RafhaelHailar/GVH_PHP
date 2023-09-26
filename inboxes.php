<?php
    include "connection.php";

    $method = $_SERVER['REQUEST_METHOD'];
    if ($method == "POST") {
        $function = $_POST['function'];
        $id = $_POST['id'];
        
        if ($function == 1) {
            $sql = "SELECT * FROM inboxes WHERE `user_id` = '$id'";
            $getInboxes = mysqli_query($connection,$sql);
    
            $inboxes = array();
            while ($result = mysqli_fetch_assoc($getInboxes)) {
                array_push($inboxes,$result);
            }
    
            echo json_encode($inboxes);
        } else if ($function == 2) {
            $markAsRead = "UPDATE inboxes SET `viewed` = '1' WHERE `id` = '$id'";
            mysqli_query($connection,$markAsRead);
        }
    }
?>