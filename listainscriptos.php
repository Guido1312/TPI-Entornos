<!DOCTYPE html>
<html lang="es">

<head>
<?php
include("head.html");
?>  
</head>
<body>  
<?php
include("headerAlumno.html");
include("conexion.inc");
$vIDprofesor = 1; #$_POST ['id_profesor'];
$vIDconsulta = 2; #$_POST ['id_consulta'];

$vSql = "SELECT * FROM inscripciones i inner join alumnos a on i.id_alumno = a.legajo
                                     inner join consultas c on i.id_consulta = c.id_consulta
                                    where c.id_profesor = '$vIDprofesor' and i.id_consulta = '$vIDconsulta'";
$vResultado = mysqli_query($link, $vSql);

?>
    <div class="table-responsive">
    <table class="table">
        <thead style="background-color: #077b83; color: #ffff ;">
        <tr>
            <th><b>Legajo</b></td>
            <th><b>Nombre y apellido</b></td>
            <th><b>Email</b></td>
        </tr>
        </thead>
<?php

while ($fila = mysqli_fetch_array($vResultado))
{
?>
            <tr>
                <td><?php echo ($fila['legajo']); ?></td>
                <td><?php echo ($fila['nombre_apellido']); ?></td>
                <td><?php echo ($fila['mail']); ?></td>
            </tr>
<?php
}
// Liberar conjunto de resultados
mysqli_free_result($vResultado);
// Cerrar la conexion
mysqli_close($link);
?>

    </table>
    </div>
    <p>&nbsp;</p>
<?php
include("footer.html");
?>
</body> 