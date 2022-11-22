<?php session_start(); ?>
<!DOCTYPE html>
<html lang="es">

<head>
<?php
include("head.html");
?>  
<link rel="stylesheet" href="//code.jquery.com/ui/1.13.1/themes/base/jquery-ui.css">
<link rel="stylesheet" href="/resources/demos/style.css">
<script src="https://code.jquery.com/jquery-3.6.0.js"></script>
<script src="https://code.jquery.com/ui/1.13.1/jquery-ui.js"></script>
<script>
$( function() {
var dateFormat = "yy-mm-dd",
    from = $( "#from" )
    .datepicker({
        defaultDate: "+1w",
        changeMonth: true,
        dateFormat: "yy-mm-dd",
        numberOfMonths: 3
    })
    .on( "change", function() {
        to.datepicker( "option", "minDate", getDate( this ) );
    }),
    to = $( "#to" ).datepicker({
    defaultDate: "+1w",
    changeMonth: true,
    dateFormat: "yy-mm-dd",
    numberOfMonths: 3
    })
    .on( "change", function() {
    from.datepicker( "option", "maxDate", getDate( this ) );
    });

function getDate( element ) {
    var date;
    try {
    date = $.datepicker.parseDate( dateFormat, element.value );
    } catch( error ) {
    date = null;
    }

    return date;
}
} );
</script>
</head>
<body>  
<?php
if (isset($_SESSION['usuario']) & $_SESSION['rol']!=1){
    header("location:index.php");
}
elseif (isset($_SESSION['usuario']) & $_SESSION['rol']==1){
    include("conexion.inc");
    $vIDalumno = 1; #$_POST ['id_alumno'];
    $vIDespecialidad = 1; #$_POST ['especialidad'];

    if (!empty($_POST ['actionType']) && !empty($_POST["inputIDconsulta"]) && $_POST ['actionType']=="inscribirse") {
        $vIDconsulta = $_POST["inputIDconsulta"];
        $vSqlCount = "SELECT COUNT(*) as cantidad FROM inscripciones WHERE id_consulta = '$vIDconsulta' and id_alumno = '$vIDalumno'";
        $resultCount = mysqli_query($link, $vSqlCount);
        $data=mysqli_fetch_assoc($resultCount);
        if ($data['cantidad'] == 0){
            $vSql = "INSERT INTO inscripciones (fecha_inscripcion, estado_inscripcion, id_consulta, id_alumno) 
                    Values (sysdate(), 1, $vIDconsulta, $vIDalumno)";
            }
            else{
                $vSql = "UPDATE inscripciones SET estado_inscripcion = 1 WHERE id_consulta = '$vIDconsulta' and id_alumno = '$vIDalumno'";
            }
        if(mysqli_query($link, $vSql)) {
            //se envia mail de notificacion de inscripcion al profesor
            $vSqlmail = "SELECT a.legajo, a.nombre_apellido, m.nombre_materia, c.fecha_consulta, c.hora_consulta, p.mail  FROM inscripciones i 
                            INNER JOIN consultas c on i.id_consulta = c.id_consulta
                            INNER JOIN alumnos a on i.id_alumno = a.legajo
                            INNER JOIN profesores p on p.id_profesor = c.id_profesor
                            INNER JOIN materias m on c.id_materia = m.id_materia
                            WHERE i.id_consulta = $vIDconsulta AND i.id_alumno = $vIDalumno";
            $vResultadoMail = mysqli_query($link, $vSqlmail);
            
            while ($fila = mysqli_fetch_array($vResultadoMail))
                    {
                        $legajoAlumno = $fila['legajo'];
                        $nombreAlumno = $fila['nombre_apellido'];
                        $Emateria = $fila['nombre_materia'];
                        $Efecha = $fila['fecha_consulta'];
                        $Ehora = $fila['hora_consulta'];
                        $EmailProfesor = $fila['mail'];
                    }

            $destinatario = $EmailProfesor;
            $asunto = "Nueva inscripción a consultas - UTN";
            $cuerpo = "
            <html>
            <head>
            <title>UTN - Consultas</title>
            </head>
            <body>
            <p>Un nuevo alumno se ha inscrito a consulta</p>
            <p>Legajo: ".$legajoAlumno." </p> 
            <p>Alumno: ".$nombreAlumno." </p> 
            <p>Materia: ".$Emateria." </p>
            <p>Fecha: ".$Efecha." </p>
            <p>Hora: ".$Ehora." </p>
            </body>
            </html>";
            $cabeceras  = 'MIME-Version: 1.0' . "\r\n";
            $cabeceras .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
            $cabeceras .= 'From: me@you.com' . "\r\n";
            mail($destinatario,$asunto,$cuerpo,$cabeceras);
            //se envia mail de notificacion de inscripcion al profesor

            $vTipoMensaje = "success";
            $vMensaje = "Se ha inscripto exitosamente";
        }
        else{
            $vTipoMensaje = "danger";
            $vMensaje = "Ha ocurrido un error, intente nuevamente";
        }
    }
    include("headerAlumno.php");
    

    if (!empty($_POST ['from'])) {
        $vFechaDesde = $_POST ['from'];
    }
    if (!empty($_POST ['to'])) {
        $vFechaHasta = $_POST ['to'];
    }

    $vSql = "SELECT * FROM consultas c inner join materias m on c.id_materia = m.id_materia
            inner join especialidades e on m.id_especialidad = e.id_especialidad
            inner join especialidades_alumnos ea on e.id_especialidad = ea.id_especialidad
            inner join profesores p on c.id_profesor = p.id_profesor
            where ea.id_alumno = '$vIDalumno' and ea.id_especialidad = '$vIDespecialidad'
                and not exists ( SELECT * FROM inscripciones i where i.id_consulta = c.id_consulta 
                                        and i.id_alumno = '$vIDalumno'
                                        and i.estado_inscripcion != 4)";

    if (!empty($_POST ['from'])) {
        $vSql .= " and c.fecha_consulta between '$vFechaDesde' and '$vFechaHasta'";
    }

    if (!empty($_POST ['materia']) && $_POST ['materia']!="0") {
        $vMateriaFiltro = $_POST ['materia'];
        $vSql .= " and c.id_materia = '$vMateriaFiltro'";
    }

    $vSqlMaterias = "SELECT m.id_materia, m.nombre_materia FROM materias m
                    inner join especialidades e on m.id_especialidad = e.id_especialidad
                    inner join especialidades_alumnos ea on e.id_especialidad = ea.id_especialidad
                    where ea.id_alumno = '$vIDalumno' and ea.id_especialidad = '$vIDespecialidad'";
                                    
    $vResultado = mysqli_query($link, $vSql);
    $vMaterias = mysqli_query($link, $vSqlMaterias);

    ?>
        <form action="inscribir.php" method="POST" name="FiltrarConsultas">
            <label for="from">Fecha desde:</label>
            <?php
            if (empty($_POST ['from'])) {
            ?>
                <input type="text" id="from" name="from">
            <?php
            }
            else {
            ?>
                <input type="text" id="from" name="from" value=<?php echo ($_POST ['from'])?>>
            <?php
            }
            ?>
            <label for="to">hasta:</label>
            <?php
            if (empty($_POST ['to'])) {
            ?>
                <input type="text" id="to" name="to">
            <?php
            }
            else {
            ?>
                <input type="text" id="to" name="to" value=<?php echo ($_POST ['to'])?>>
            <?php
            }
            ?>
            <label for="materia">Materia:</label>
            <select name="materia" id="materia">
            <?php
            if (empty($_POST ['materia'])) {
            ?>
                <option value="0" selected>Todas</option>
            <?php        
            }
            else {
            ?>
                <option value="0">Todas</option>
            <?php
            }    
            while ($fila = mysqli_fetch_array($vMaterias))
            {
                if (!empty($_POST ['materia']) && $_POST ['materia']==$fila['id_materia']) {
                ?>
                    <option value=<?php echo ($fila['id_materia'])?> selected> <?php echo ($fila['nombre_materia'])?></option>
                <?php        
                }
                else {
                ?>
                    <option value=<?php echo ($fila['id_materia'])?>> <?php echo ($fila['nombre_materia'])?></option>
                <?php
                }
            }
            ?>    
            </select>
            <button type="submit" name="actionType" value="filtrar" class="btn btn-primary btn-block">Filtrar</button>
        </form>
        <div class="table-responsive">
        <table class="table">
            <thead style="background-color: #077b83; color: #ffff ;">
            <tr>
                <td><b>Materia</b></td>
                <td><b>Profesor</b></td>
                <td><b>Fecha</b></td>
                <td><b>Hora</b></td>
                <td></td>
            </tr>
        </thead>
    <?php

    while ($fila = mysqli_fetch_array($vResultado))
    {
    ?>
                <tr>
                    <td><?php echo ($fila['nombre_materia']); ?></td>
                    <td><?php echo ($fila['nombre_apellido']); ?></td>
                    <td><?php echo ($fila['fecha_consulta']); ?></td>
                    <td><?php echo ($fila['hora_consulta']); ?></td>
                    <td> 
                        <form action="inscribir.php" method="post">
                            <input name="inputIDconsulta" type="text" class="form-control" style="display:none" id="inputIDconsulta" value="<?php echo ($fila['id_consulta']); ?>">
                            <button type="submit" name="actionType" value="inscribirse" class="btn btn-info"> Inscribirse </button>
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
}
else {
    header("location:login.php");
}
?>
</body>