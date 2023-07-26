<?php session_start(); ?>
<!DOCTYPE html>
<html lang="es">
<head>
<?php
include("head.html");
?>  
</head>
<body> 
<?php
error_reporting(0); //evita que se muestren los warning
if (isset($_SESSION['usuario']) & $_SESSION['rol']!=1){
    header("location:index.php");
}
elseif (isset($_SESSION['usuario']) & $_SESSION['rol']==1){
    include("conexion.inc");
    
    $vIDalumno = $_SESSION['id_alumno'];
    date_default_timezone_set("America/Argentina/Buenos_Aires");
    $vHoraLimiteCancelacion = strtotime('+ 24 hour');
    try {
    if (!empty($_POST ['actionType']) && !empty($_POST["inputIDconsulta"]) && $_POST ['actionType']=="cancelar") {
        $vIDconsulta = $_POST["inputIDconsulta"];
        $vSql = "UPDATE inscripciones SET estado_inscripcion = 4 WHERE id_consulta = '$vIDconsulta' and id_alumno = '$vIDalumno'";
        if(mysqli_query($link, $vSql)) {
            $vTipoMensaje = "success";
            $vMensaje = "Se ha cancelado la inscripción";
        }
        else{
            $vTipoMensaje = "danger";
            $vMensaje = "Ha ocurrido un error al cancelar, intente nuevamente";
        }
    }
    } catch (mysqli_sql_exception $e) {
        $vTipoMensaje = "danger";
        $vMensaje = "Problemas de conexión a la base de datos";
    }
    include("headerAlumno.php");
    try {
    $vSql = "SELECT * FROM inscripciones i inner join alumnos a on i.id_alumno = a.legajo
                                        inner join consultas c on i.id_consulta = c.id_consulta
                                        inner join estados_consulta e on c.id_estado_consulta = e.id_estado_consulta
                                        inner join profesores p on p.id_profesor = c.id_profesor
                                        inner join materias m on m.id_materia = c.id_materia
                                        where i.id_alumno = '$vIDalumno' and i.estado_inscripcion != 4 
                                        and c.id_estado_consulta in (1,3)
                                        and addtime(fecha_consulta,hora_consulta) >= date_add(utc_timestamp(), INTERVAL -3 HOUR)
                                        order by c.fecha_consulta, c.hora_consulta
                                        ";
    $vResultado = mysqli_query($link, $vSql);

    if (mysqli_num_rows($vResultado)==0)
    {
        echo("No tienes inscripciones a ninguna materia");
    }
    else
    {

    ?>
    <div class="table-responsive">
        <table class="table">
            <thead style="background-color: #077b83; color: #ffff ;">
                <tr>
                    <th><b>Fecha</b></th>
                    <th><b>Hora</b></th>
                    <th><b>Materia</b></th>
                    <th><b>Profesor</b></th>
                    <th><b>Estado</b></th>
                    <th></th>
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
                <td><?php echo ($fila['nombre_estado']);
                      if ($fila['id_estado_consulta'] == 3) {
                        echo (' - Motivo: '.$fila['motivo_cancelacion']);
                      }
                    ?></td>
                <td> 
                    <?php 
                    if ($fila['id_estado_consulta'] == 3){
                        ?>
                        <button type="submit" name="actionTypeNone" class="btn btn-danger" title="Consulta bloqueada." disabled> Cancelar inscripcion </button>
                        <?php
                    }
                    elseif (strtotime($fila['fecha_consulta'].' '.$fila['hora_consulta'])>$vHoraLimiteCancelacion) {
                    ?>
                        <form action="misinscripciones.php" method="post">
                            <input name="inputIDconsulta" type="text" class="form-control" style="display:none" id="inputIDconsulta" value="<?php echo ($fila['id_consulta']); ?>">
                            <button type="submit" name="actionType" value="cancelar" class="btn btn-danger"> Cancelar inscripcion </button>
                        </form>
                    <?php
                    }
                    else{ ?>
                        <button type="submit" name="actionTypeNone" class="btn btn-danger" title="Solo puede cancelar una inscripcion 24hs antes de la consulta." disabled> Cancelar inscripcion </button>
                    <?php
                    }
                    ?>
                </td>
            </tr>
            <?php
    }
    }
    // Liberar conjunto de resultados
    mysqli_free_result($vResultado);
    // Cerrar la conexion
    mysqli_close($link);
    } catch (mysqli_sql_exception $e) {
        $vTipoMensaje = "danger";
        $vMensaje = "Problemas de conexión a la base de datos";
    }
    ?>

        </table>
    </div>
    <p>&nbsp;</p>
    <?php
    include("footer.html");
}
else {
    header("location:index.php");
}?>
</body> 