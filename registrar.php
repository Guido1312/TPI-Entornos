<?php 
include("conexion.inc");
// Llamar a la función con un parámetro de entrada
$parametroEntrada = $_GET['code'];

// Utilizamos la función SELECT para llamar a la función y obtener su valor de retorno
$resultado = $link->query("SELECT validar_registro('$parametroEntrada') AS resultado");
if ($resultado) {
    $fila = $resultado->fetch_assoc();
    $valorRetorno = $fila['resultado'];
    // Cerrar la conexión
    $link->close();
    header("location:login.php?mensaje=".$valorRetorno);
} else {
    // Cerrar la conexión
    $link->close();
    header("location:login.php?mensaje=Error al registrar el usuario");
}
?>