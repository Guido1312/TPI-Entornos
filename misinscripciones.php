<!DOCTYPE html>
<html lang="es">
<head>
<?php
include("head.html");
?>  
</head>
<body> 

<?php
include("conexion.inc");
$vIDalumno = 1; #$_POST ['id_alumno'];

if (!empty($_POST ['actionType']) && !empty($_POST["inputIDconsulta"]) && $_POST ['actionType']=="cancelar") {
    $vIDconsulta = $_POST["inputIDconsulta"];
    $vSql = "UPDATE inscripciones SET estado_inscripcion = 4 WHERE id_consulta = '$vIDconsulta' and id_alumno = '$vIDalumno'";
    if(mysqli_query($link, $vSql)) {
        $vTipoMensaje = "success";
        $vMensaje = "Se ha cancelado la inscripción";
    }
    else{
        $vTipoMensaje = "danger";
        $vMensaje = "Ha ocurrido un error, intente nuevamente";
    }
}

include("headerAlumno.html");
include("mensaje.php");

$vSql = "SELECT * FROM inscripciones i inner join alumnos a on i.id_alumno = a.legajo
                                     inner join consultas c on i.id_consulta = c.id_consulta
                                     inner join profesores p on p.id_profesor = c.id_profesor
                                     inner join materias m on m.id_materia = c.id_materia
                                    where i.id_alumno = '$vIDalumno' and i.estado_inscripcion != 4";
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
            <td> 
                <form action="misinscripciones.php" method="post">
                    <input name="inputIDconsulta" type="text" class="form-control" style="display:none" id="inputIDconsulta" value="<?php echo ($fila['id_consulta']); ?>">
                    <button type="submit" name="actionType" value="cancelar" class="btn btn-danger"> Cancelar inscripcion </button>
                </form>
            </td>
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