<?php
$link = mysqli_connect(getenv('AZURE_MYSQL_HOST'), getenv('AZURE_MYSQL_USERNAME'), getenv('AZURE_MYSQL_PASSWORD')) or die ("Problemas de conexión a la base de
datos");
mysqli_select_db($link, getenv('AZURE_MYSQL_DBNAME'));
?>