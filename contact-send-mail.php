<?php

use PHPMailer\PHPMailer\PHPMailer;

//use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

$contactFormDTO = new stdClass();

$contactFormDTO->name = $_POST['name'];
$contactFormDTO->email = $_POST['email'];
$contactFormDTO->subject = $_POST['subject'];
$contactFormDTO->message = $_POST['message'];
$contactFormDTO->copy = isset($_POST['copy']) ? true : false;



$mail = new PHPMailer;

$mail->isSMTP();
$mail->SMTPDebug = 0;
$mail->Host = 'smtp.gmail.com';
$mail->Port = 587;
$mail->SMTPSecure = 'tls';
$mail->SMTPAuth = true;
$mail->Username = 'xtutor.info@gmail.com';
$mail->Password = 'ny1sh145';


$mail->setFrom($contactFormDTO->email, $contactFormDTO->name);

$mail->addAddress('xtutor.info@gmail.com', 'Me');

if ($contactFormDTO->copy) {
    $mail->addCC($contactFormDTO->email);
}
$mail->Subject = $contactFormDTO->subject;

$mail->Body = $contactFormDTO->message;

//send the message, check for errors
$response['message'] = 'Message sent!';
$response['status'] = 1;

if (!$mail->send()) {
    http_response_code(400);
    echo "Mailer Error: " . $mail->ErrorInfo;
} else {
    echo "Your message was successfully sent!";
}