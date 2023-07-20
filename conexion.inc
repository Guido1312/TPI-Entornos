<?php
try {
$link = mysqli_connect("localhost", "root", "root") or die ("Problemas de conexión a la base de
datos");
mysqli_select_db($link, "consultasutn");
} catch (mysqli_sql_exception $e) {
        $vTipoMensaje = "danger";
        $vMensaje = "Problemas de conexión a la base de datos";
    }
?>