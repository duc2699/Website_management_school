<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if (isset($_POST['submit'])) {
    $to         = "";
    $subject    = $_POST['subject'];
    $body       = $_POST['body'];
    $email      = $_POST['email'];

    require_once('includes/PHPMailer/src/PHPMailer.php');
    require_once('includes/PHPMailer/src/Exception.php');
    require_once('includes/PHPMailer/src/SMTP.php');

    $mail = new PHPMailer();
    $mail->isSMTP();
    $mail->SMTPAuth = true;
    $mail->SMTPSecure = 'ssl';
    $mail->Host = 'smtp.gmail.com';
    $mail->Port = '465';
    $mail->isHTML();
    $mail->Username = 'thanhphat19@gmail.com';
    $mail->Password = '';
    $mail->SetFrom($email);
    $mail->AddReplyTo($email);
    $mail->Subject = $subject;
    $mail->Body = $body;
    $mail->AddAddress($to);

    $mail->Send();

    if ($mail->Send()) {
        echo "<p class='bg-success'>Send mail successful</p>";
    } else {
        echo "<p class='bg-danger'>Send mail failed</p>";
    }
}
