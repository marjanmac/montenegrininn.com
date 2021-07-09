<?php
/* Email input from a live contact form to your desired email address through a SMTP and access to your Gmail account of choice. */

$msg = '';
if (array_key_exists('email', $_POST)) {
    date_default_timezone_set('Etc/UTC');

    require_once("php/PHPMailerAutoload.php");
    
    require("php/PHPMailer.php");
    require("php/SMTP.php");
    require("php/Exception.php");
    

    $mail = new PHPMailer\PHPMailer\PHPMailer();
    //Tell PHPMailer to use SMTP - requires a local mail server so don't use
    //$mail->isSMTP();

    // 0 = off // 1 = client messages // 2 = client and server messages
    $mail->SMTPDebug = 2;
    $mail->Debugoutput = 'html';
    $mail->Host = 'localhost';
    $mail->Port = 25;
    //$mail->SMTPSecure = 'tls';
    //$mail->SMTPAuth = true;
    $mail->Username = "contact@goldensunset.mk";
    $mail->Password = "Example100";

    // Set as the same email address you just gave up the password to up above.
    $mail->setFrom('contact@goldensunset.mk', 'First Last');
    // Where do you want the message to be sent?
    $mail->addAddress('contact@goldensunset.mk', 'Name Here');

    if ($mail->addReplyTo($_POST['email'], $_POST['name'])) {
        // Edit the Subject line below, as desired
        $mail->Subject = 'GoldenSunset';
        $mail->isHTML(false);
        // If your form has other fields, add them below. ie: Phone: {$_POST['phone']}
        $mail->Body = <<<EOT
Email: {$_POST['email']}
Name: {$_POST['name']}
Reservation: {$_POST['reservationDate']}
People: {$_POST['totalPeople']}
Message: {$_POST['message']}
EOT;
        //Send the message, check for errors
        if (!$mail->send()) {
            $msg = 'Sorry, something went wrong. Please try again later.';
        } else {
          // JS popup alert to let user know the message was sent.
          $message = 'Message sent! Thanks for contacting us.';
          echo "<script type='text/javascript'>alert('$message');</script>";
        }
    } else {
        $msg = 'Invalid email address, message ignored.';
    }
}
?>