<?php
// Use the PHPMailer Class
use PHPMailer\PHPMailer\PHPMailer;

// Use SMTP
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Load Composer's autoloader
require 'vendor/autoload.php';

function customMail($emailTarget, $subJect, $messageLetter)
{
    // Sender and Email information
    $senderEmail=getenv('MAIL_FROM');
    $senderName=getenv('MAIL_SENDER_NAME');
    $replyTo=getenv('MAIL_FROM');

    // Buiding the email object attributes
    $mail = new PHPMailer;

    // SMTP Configuration

    //$mail->SMTPDebug = SMTP::DEBUG_SERVER; //Enable verbose debug output
    $mail->isSMTP(true); //Send using SMTP
    $mail->Host = getenv('MAIL_FROM_HOST');
    $mail->SMTPAuth = true;
    $mail->Username = getenv('MAIL_FROM'); // SMTP username
    $mail->Password = getenv('MAIL_FROM_PASSWORD'); // The Google Application password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; //Enable implicit TLS encryption
    $mail->Port = 587; //TCP port to connect to; 
    $mail->SMTPKeepAlive = true;

    // End Of SMTP Configuration


    $mail->setFrom($senderEmail,$senderName);
    $mail->addReplyTo($replyTo);
    $mail->addAddress($emailTarget);
    $mail->Subject = trim($subJect);
    $mail->Body = $messageLetter;

    // The Html Message Type, so message body can contain html tags.
    $mail->IsHTML(true);

    // Clean Body
    $mail->AltBody =strip_tags($messageLetter);
    $mail->CharSet = 'UTF-8';
    $mail->Encoding = '8bit';

    $mail->send();
}


?>