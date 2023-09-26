<?php
    include "connection.php";

    $method = $_SERVER['REQUEST_METHOD'];

    if ($method == "POST") {
        $function = $_POST['function'];
        if ($function == 1) {
            $doctorId = $_POST['doctor-id'];
            $patient_type = $_POST['patient-type'];
            $email = $_POST['email'];
            $appointmentType = $_POST['appointment-type'];
            $appointedDate = $_POST['appointment-date'];
            $appointmentReason = $_POST['appointment-reason'];
            $hmo = $_POST['hmo'];
            $requestDate = date("Y-m-d") . " " . date("H-i-s");


            if ($patient_type == "1") {
                $getPatient = "SELECT * FROM users WHERE `email` = '$email'";
                $getPatientRun = $connection -> prepare($getPatient);
                $getPatientRun -> execute();

                $patient = $getPatientRun -> get_result();
                $patient = (mysqli_fetch_assoc($patient));

                if ($patient) {
                    $patientId = $patient['id'];
                    $addQueue = "INSERT INTO queues (`doctor_id`,`patient_id`,`appointed_date`,`request_date`,`reason`,`hmo_id`,`type_id`) VALUES ('$doctorId','$patientId','$appointedDate','$requestDate','$appointmentReason','$hmo','$appointmentType') ";
                } else {
                    echo "Not Existing Patient!";
                    exit();
                }
            } else {
                exit();
            }

            mysqli_query($connection,$addQueue);

            $getAdmins = "SELECT `id` FROM users WHERE `type_id` = '1'";
            $admins = mysqli_query($connection,$getAdmins);
            while ($result = mysqli_fetch_assoc($admins)) {
                $message = "Appointment Request was added to the queue";
                $addMessage = "INSERT INTO inboxes (`user_id`,`message`,`datetime_received`) VALUES ('$result[id]','$message','$requestDate')";
                mysqli_query($connection,$addMessage);
            }
            exit();

        } else if ($function == 2) {
            $accept = $_POST['accept'];
            $id = $_POST['id'];
            $getAppointment = "SELECT `doctor_id`,`patient_id`,`appointed_date` FROM queues WHERE `id` = '$id'";
            $result = $connection -> prepare($getAppointment);
            $result -> execute();
            $appointment = $result -> get_result();
            $appointment = mysqli_fetch_assoc($appointment);
            $requestDate = date("Y-m-d") . " " . date("H-i-s");

            if ($accept == 'true') {
                $addAppointment = "INSERT INTO appointments (`doctor_id`,`patient_id`,`appointed_date`,`reason`,`hmo_id`,`type_id`) VALUES ('$appointment[doctor_id]','$appointment[patient_id]','$appointment[appointed_date]','$appointment[reason]','$appointment[hmo_id]','$appointment[type_id]')";
                mysqli_query($connection,$addAppointment);

                $appointmentMessageD = "An appointment is added.";
                $appointmentMessageP = "Your appointment request is accepted.";
                
                
                $addInbox = "INSERT INTO inboxes (`user_id`,`message`,`datetime_received`) VALUES ('$appointment[doctor_id]','$appointmentMessageD','$requestDate');
                             INSERT INTO inboxes (`user_id`,`message`,`datetime_received`) VALUES ('$appointment[patient_id]','$appointmentMessageP','$requestDate');";
                mysqli_multi_query($connection,$addInbox);
            } else {
                $dissappointmentMessage = "Your appointment request is declined.";
                $addInbox = "INSERT INTO inboxes (`user_id`,`message`,`datetime_received`) VALUES ('$appointment[patient_id]','$dissappointmentMessage','$requestDate')";
                mysqli_multi_query($connection,$addInbox);
            }
            $result -> close();
            $removeRequest = "DELETE FROM `queues` WHERE `id`='$id'";
            mysqli_query($connection,$removeRequest);

        } else if ($function == 3) {
            if (isset($_POST['id'])) {
                $id = $_POST['id'];
                $type = $_POST['type'] . "_id";
                $sql = "SELECT * FROM queues WHERE `$type` = '$id'";
            } else $sql = "SELECT * FROM queues";
            $getQueues = mysqli_query($connection,$sql);
            
            $queues = array();
            while ($result = mysqli_fetch_assoc($getQueues)) {
                array_push($queues,$result);
            }
    
            echo json_encode($queues);
        } else if ($function == 4) {
            if (isset($_POST['id'])) {
                $id = $_POST['id'];
                $cancelQueue = "DELETE FROM queues WHERE `id` = '$id'";
                mysqli_query($connection,$cancelQueue);
            }
        }

    }
?>