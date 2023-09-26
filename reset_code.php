<?php
    include "connection.php";

    try {
        $email = $_POST['email'];
    } catch (Exception $error) {
        echo "You pass email! <br/> $error";
        exit();
    }

    $token = md5(rand());

    $update_token = "UPDATE users SET verify_token = '$token' WHERE email = '$email' LIMIT 1";
    $update_token_run = mysqli_query($connection,$update_token);

    if (!$update_token_run) {
        echo "PROCESS FAILED!";
        exit();
    }

    //Import PHPMailer classes into the global namespace
    //These must be at the top of your script, not inside a function
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;

    //Load Composer's autoloader
    require 'vendor/autoload.php';


    //Create an instance; passing `true` enables exceptions
    $mail = new PHPMailer(true);
    try {
        //Server settings
        //$mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
        $mail->isSMTP();                                            //Send using SMTP
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
        $mail->Username   = 'hospitalgvh@gmail.com';                     //SMTP username
        $mail->Password   = 'kuld uacd bsva monl';                               //SMTP password
        $mail->SMTPSecure = "ssl";            //Enable implicit TLS encryption
        $mail->Port =  465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
    
        //Recipients
        $mail->setFrom('rafhael4hailar@gmail.com');
        $mail->addAddress($email);     //Add a recipient
       /*  $mail->addAddress('ellen@example.com');               //Name is optional
        $mail->addReplyTo('info@example.com', 'Information');
        $mail->addCC('cc@example.com');
        $mail->addBCC('bcc@example.com'); */
    
    /*     //Attachments
        $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
        $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name */
    
        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = 'Reset Password Notification';
        $mail->Body    = "
            <h1>Hello,</h1>
            <p>We receiveid a request to reset the password for the GVH Hospital account assosciated with $email .No changes have been made to your account yet.</p>
            <br />
            <p>You can reset your password by clicking the link below :
            <br/>
            <a href='http://localhost:3000/resetpassword?email=$email&token=$token'>
                <button style='background:#0E9BD3;color:white;padding:.7rem 2rem;border-radius:10px;border:none' >Reset your password</button>
            </a>
            <p>If you did not request a new password,please let us know immediately by replying to this email.</p>
            <p>You can find answers to most questions and get in touch with us at <a href='https://youtube.com'>support.gvhhospital.com</a>.We're here to help you at any step along the way.</p>

            <p> ---The GVH Hospital Team</p>
        ";
    
        $mail->send();
        echo "{\"email\" : \"$email\",\"token\" : \"$token\"}";
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        exit();
    }
?>