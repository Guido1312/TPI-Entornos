<?php
$destinatario = "xx@xx.com ";
$asunto = "Prueba";
$cuerpo = "
<html>
<head>
  <title>HTML de prueba</title>
</head>
<body>
  <p>Esto es una prueba</p>
</body>
</html>";
$cabeceras  = 'MIME-Version: 1.0' . "\r\n";
$cabeceras .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
if(mail($destinatario,$asunto,$cuerpo,$cabeceras)) {
  header("Location: success.html");
}
else {
  header("Location: error.html");
};
?>