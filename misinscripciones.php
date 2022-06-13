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
$vIDalumno = 1; #$_POST ['id_alumno'];

$vSql = "SELECT * FROM inscripciones i inner join alumnos a on i.id_alumno = a.legajo
                                     inner join consultas c on i.id_consulta = c.id_consulta
                                     inner join profesores p on p.id_profesor = c.id_profesor
                                     inner join materias m on m.id_materia = c.id_materia
                                    where i.id_alumno = '$vIDalumno'";
$vResultado = mysqli_query($link, $vSql);

?>
<div class="table-responsive">
    <table class="table">
        <thead style="background-color: #077b83; color: #ffff ;">
            <tr>
                <td><b>Fecha</b></td>
                <td><b>Hora</b></td>
                <td><b>Materia</b></td>
                <td><b>Profesor</b></td>
                <td></td>
            </tr>
        </thead>
        <?php

while ($fila = mysqli_fetch_array($vResultado))
{
?>
        <tr>
            <td><?php echo ($fila['fecha_consulta']); ?></td>
            <td><?php echo ($fila['hora_consulta']); ?></td>
            <td><?php echo ($fila['nombre_materia']); ?></td>
            <td><?php echo ($fila['nombre_apellido']); ?></td>
            <td style="text-align:center" ;><button type="button" class="btn btn-danger"> Cancelar inscripcion </button></td>
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