<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Corrected the path to use a leading slash for the directory
require __DIR__ . "/../vendor/autoload.php"; // Notice the slash before vendor

$mail = new PHPMailer(true);
//$mail->SMTPDebug = SMTP::DEBUG_SERVER;

$mail->isSMTP();
$mail->SMTPAuth = true;

$mail->Host = "smtp.gmail.com"; // Ensure you're using the correct SMTP host
$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
$mail->Port = 587;
$mail->Username = "Flashbook.emailer@gmail.com";
$mail->Password = "wvyg vtav atll vjgx"; // Be careful with your password in production

$mail->isHTML(true);

return $mail;
