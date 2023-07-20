<?php
// Use the PHPMailer Class
use PHPMailer\PHPMailer\PHPMailer;

// Use SMTP
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Load Composer's autoloader
require 'vendor/autoload.php';

// Sender and Email information
$senderEmail='trabajopracticoconsultasutn@gmail.com';
$senderName='Consultas utn';
$replyTo='trabajopracticoconsultasutn@gmail.com';
$subJect='Probando mail';
$messageLetter='Prueba con phpMailer';

// Target Email address
$emailTarget='guidolorenzotti@gmail.com';

// Buiding the email object attributes
$mail = new PHPMailer;

// SMTP Configuration

$mail->SMTPDebug = SMTP::DEBUG_SERVER; //Enable verbose debug output
$mail->isSMTP(true); //Send using SMTP
$mail->Host = 'smtp.gmail.com';
$mail->SMTPAuth = true;
$mail->Username = 'trabajopracticoconsultasutn@gmail.com'; // SMTP username
$mail->Password = 'wxmxjxuureiwrohi'; // The Google Application password
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

// Fire your Email.
if (!$mail->send()) {
echo '[Error:]'.htmlspecialchars($mail->ErrorInfo);
}
else {
echo '[Status:] Sent';
}

?>