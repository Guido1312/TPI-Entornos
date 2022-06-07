<?php
include("headerAlumno.html");
include("conexion.inc");
$vIDalumno = 1; #$_POST ['id_alumno'];
$vIDespecialidad = 1; #$_POST ['especialidad'];

$vSql = "SELECT * FROM consultas c inner join materias m on c.id_materia = m.id_materia
                                    inner join especialidades e on m.id_especialidad = e.id_especialidad
                                    inner join especialidades_alumnos ea on e.id_especialidad = ea.id_especialidad
                                    inner join profesores p on c.id_profesor = p.id_profesor
                                    where ea.id_alumno = '$vIDalumno'and ea.id_especialidad = '$vIDespecialidad' ";
$vResultado = mysqli_query($link, $vSql);

?>
    <table border=1>
        <tr>
            <td><b>Materia</b></td>
            <td><b>Profesor</b></td>
            <td><b>Fecha</b></td>
            <td><b>Hora</b></td>
            <td></td>
        </tr>
<?php

while ($fila = mysqli_fetch_array($vResultado))
{
?>
            <tr>
                <td><?php echo ($fila['nombre_materia']); ?></td>
                <td><?php echo ($fila['nombre_apellido']); ?></td>
                <td><?php echo ($fila['fecha_consulta']); ?></td>
                <td><?php echo ($fila['hora_consulta']); ?></td>
                <td><button type="button" class="btn btn-info"> Inscribirse </button></td>
            </tr>
<?php
}
// Liberar conjunto de resultados
mysqli_free_result($vResultado);
// Cerrar la conexion
mysqli_close($link);
?>

    </table>
    <p>&nbsp;</p>
<?php
include("footer.html");
?>