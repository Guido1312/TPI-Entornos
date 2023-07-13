<?php
require('vendor/autoload.php');

$hostname = 'smtp.cloudmta.net';
$username = '285731b2f948c506';
$password = 'Sh3M6kJRkgN3hUqMggQ7Kfb7';

$transport = (new Swift_SmtpTransport($hostname, 587, 'tls'))
  ->setUsername($username)
  ->setPassword($password);

$mailer = new Swift_Mailer($transport);

$message = (new Swift_Message())
  ->setSubject('Hello from PHP SwiftMailer')
  ->setFrom(['app313652285@heroku.com'])
  ->setTo(['guidolorenzotti@gmail.com' => 'Guido Lorenzotti']);

$headers = ($message->getHeaders())
  -> addTextHeader('X-CloudMTA-Class', 'standard');

$message->setBody(
  '<body>'.
  '<h1>hello from php</h1>'.
  '</body>'
);
$message->addPart('hello from PHP', 'text/plain');
$mailer->send($message);