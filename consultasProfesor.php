<?php 
include("sendMail.php");
session_start(); 
// Función para obtener el número del día de la semana (0 para domingo, 1 para lunes, etc.)
function obtenerNumeroDiaSemana($fecha) {
    $fecha_obj = DateTimeImmutable::createFromFormat('Y-m-d', $fecha);
    return (int) $fecha_obj->format('w');
}

// Función para obtener la fecha correspondiente al día seleccionado en la misma semana y el viernes
function obtenerFechaCorrespondiente($fecha, $dia_semana) {
    $numero_dia_semana = obtenerNumeroDiaSemana($fecha);
    $numero_dia_seleccionado = array_search($dia_semana, ['domingo', 'lunes', 'martes', 'miercoles', 'jueves', 'viernes', 'sabado']);

    $diferencia_dias = $numero_dia_seleccionado - $numero_dia_semana;        

    $fecha_obj = DateTimeImmutable::createFromFormat('Y-m-d', $fecha);
    $fecha_correspondiente = $fecha_obj->modify("+$diferencia_dias day");

    return $fecha_correspondiente;
}?>

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
if (isset($_SESSION['usuario']) & $_SESSION['rol']!=2){
    header("location:index.php");
}
else if (isset($_SESSION['usuario']) & $_SESSION['rol']==2){
    include("conexion.inc");
    
    $vIDprofesor = $_SESSION['id_profesor'];
    date_default_timezone_set("America/Argentina/Buenos_Aires");
    $vHoraLimiteBloqueo = strtotime('+ 2 hour');
    try {
    if (!empty($_POST ['actionType']))
    {
        if($_POST ['actionType'] == 'bloquear'){
            if (!empty($_POST["selectDia"]) && !empty($_POST["inputHora"]))
            {
                $vIdMateria = $_POST["inputMateria"];
                $fecha = $_POST["fechaConsultaReal"];
                $dia_semana = $_POST["selectDia"];
                $horaAlternativa = $_POST["inputHora"];    
                // Obtener la fecha correspondiente y el viernes de la misma semana
                $fecha_correspondiente = obtenerFechaCorrespondiente($fecha, $dia_semana);
            }

            if (empty($_POST ['id_consulta']))
            {
                $vMensaje = 'Invalid request.';
            }
            else if (empty($_POST ['motivo']) || ($_POST ['motivo'] == ''))
            {
                $vMensaje = 'Debe ingresar un motivo de bloqueo.';
            }
            else if (strtotime($fecha_correspondiente->format('Y-m-d').' '.$horaAlternativa) < strtotime("now"))
            {
                $fecha_correspondiente = null;
                $vMensaje = 'La fecha de consulta propuesta debe ser posterior al día y hora actual';
            }
            else
            {
                $fecha_correspondiente = $fecha_correspondiente->format('Y-m-d');
                if (!empty($_POST["selectDia"]) && !empty($_POST["inputHora"]))
                {
                    $vAlternativaSql = "INSERT INTO consultas (hora_consulta, fecha_consulta,id_estado_consulta,id_profesor,id_materia)
                            Values ('$horaAlternativa', '$fecha_correspondiente','1','$vIDprofesor','$vIdMateria')"; 
                    $flag = mysqli_query($link, $vAlternativaSql);
                }
                    
                $vIdConsulta = $_POST['id_consulta'];
                $vMotivoBloqueo = $_POST['motivo'];
                $vSql = "UPDATE consultas SET motivo_cancelacion = '$vMotivoBloqueo', id_estado_consulta = 3
                where id_consulta = $vIdConsulta";
                if(mysqli_query($link, $vSql)) {
                    $vTipoMensaje = 'success';
                    $vMensaje = 'Consulta bloqueada.';
                    //se envia mail de notificacion a los alumnos
                    $vSqlmail = "SELECT m.nombre_materia, c.fecha_consulta, c.hora_consulta, a.mail  FROM inscripciones i 
                                    INNER JOIN consultas c on i.id_consulta = c.id_consulta
                                    INNER JOIN alumnos a on i.id_alumno = a.legajo
                                    INNER JOIN materias m on c.id_materia = m.id_materia
                                    WHERE i.id_consulta = $vIdConsulta ";
                    $vResultadoMail = mysqli_query($link, $vSqlmail);
                    while ($fila = mysqli_fetch_array($vResultadoMail))
                        {
                            $Emateria = $fila['nombre_materia'];
                            $Efecha = $fila['fecha_consulta'];
                            $Ehora = $fila['hora_consulta'];
                            $EmailAlumno = $fila['mail'];
                            $asunto = "Consulta cancelada";
                            $cuerpo = "
                            <html>
                            <head>
                            <title>UTN - Consultas</title>
                            </head>
                            <body>
                            <p>La siguiente consulta ha sido cancelada:</p>
                            <p>Materia: ".$Emateria." </p>
                            <p>Fecha: ".$Efecha." </p>
                            <p>Hora: ".$Ehora." </p>
                            <p></p>";

                            if (!empty($_POST["selectDia"]) && !empty($_POST["inputHora"]) && $flag)
                            {
                                $cuerpo = $cuerpo."<p>Alternativa propuesta: ".$_POST["selectDia"]." ".$_POST["inputHora"]." hs.</p>";
                            }
                            $cuerpo = $cuerpo."</body></html>";

                            customMail($EmailAlumno, $asunto, $cuerpo);
                        }
                }
                else {
                    $vTipoMensaje = 'danger';
                    $vMensaje = 'Error al bloquear la consulta.';
                }
            }
        }
        if($_POST ['actionType'] == 'consultaRealizada'){
            if (empty($_POST ['id_consulta']))
            {
                $vMensaje = 'Invalid request.';
            }
            else
            {
                $vIdConsulta = $_POST['id_consulta'];
                $vSql = "UPDATE consultas SET id_estado_consulta = 2
                where id_consulta = $vIdConsulta";

                if(mysqli_query($link, $vSql)) {
                    $vTipoMensaje = 'success';
                    $vMensaje = 'Consulta marcada como realizada.';
                }
                else {
                    $vTipoMensaje = 'danger';
                    $vMensaje = 'Error al marcar como realizada la consulta.';
                }
            }
        }
    }
    } catch (mysqli_sql_exception $e) {
        $vTipoMensaje = "danger";
        $vMensaje = "Problemas de conexión a la base de datos";
    }
    include("headerProfesor.php");
    try {
    if (!empty($_POST ['from'])) {
        $vFechaDesde = $_POST ['from'];
    }
    else {
        $vFechaDesde = date_add(new DateTime("now", new DateTimeZone('America/Argentina/Buenos_Aires')),date_interval_create_from_date_string('-7 days'));
        $vFechaDesde = $vFechaDesde->format('Y-m-d');
    }
    if (!empty($_POST ['to'])) {
        $vFechaHasta = $_POST ['to'];
    }
    else {
        $vFechaHasta = date_add(new DateTime("now", new DateTimeZone('America/Argentina/Buenos_Aires')),date_interval_create_from_date_string('14 days'));
        $vFechaHasta = $vFechaHasta->format('Y-m-d');
    }

    $vSql = "SELECT e.descripcion, m.nombre_materia, m.id_materia, c.fecha_consulta, c.hora_consulta, c.id_consulta, c.id_estado_consulta
                FROM consultas c inner join materias m on c.id_materia = m.id_materia
                inner join especialidades e on m.id_especialidad = e.id_especialidad
                inner join profesores p on c.id_profesor = p.id_profesor
                where c.id_profesor = '$vIDprofesor'
                and c.fecha_consulta between '$vFechaDesde' and '$vFechaHasta'
                order by c.fecha_consulta, c.hora_consulta";
                                    
    $vResultado = mysqli_query($link, $vSql);
    $results_per_page = 15;
    $data = mysqli_fetch_all($vResultado, MYSQLI_ASSOC);
    $total_pages = ceil(count($data) / $results_per_page);

    if (isset($_GET['page']) && is_numeric($_GET['page']) && $_GET['page'] <= $total_pages) {
        $current_page = (int) $_GET['page'];
    } 
    else if (isset($_POST['page']) && is_numeric($_POST['page']) && $_POST['page'] <= $total_pages) {
        $current_page = (int) $_POST['page'];
    } 
    else {
        $current_page = 1;
    }
    
    $offset = ($current_page - 1) * $results_per_page;
    
    $data_page = array_slice($data, $offset, $results_per_page);

    } catch (mysqli_sql_exception $e) {
        $total_pages = 0;
        $data_page = [];
        $vTipoMensaje = "danger";
        $vMensaje = "Problemas de conexión a la base de datos";
    }    
        ?>
        <h1>Administración de consultas</h1>
        <div class="container">
            <form Class="content-center" action="consultasProfesor.php" method="POST" name="FiltrarConsultas">
                <label for="from">Fecha desde:</label>
                <input type="text" id="from" name="from" value=<?php echo ($vFechaDesde)?>>
                <label for="to">hasta:</label>
                <input type="text" id="to" name="to" value=<?php echo ($vFechaHasta)?>>
                <button type="submit" class="btn btn-primary btn-sm">Filtrar</button>
            </form>

        </div>
        <div class="table-responsive">
            <table class="table">
                <thead style="background-color: #077b83; color: #ffff ;">
                <tr>
                    <th><b>Especialidad</b></th>
                    <th><b>Materia</b></th>
                    <th><b>Fecha</b></th>
                    <th><b>Hora</b></th>
                    <th></th>
                    <th></th>
                </tr>
                </thead>
        <?php

        foreach ($data_page as $fila)
        {?>

                    <tr>
                        <td><?php echo ($fila['descripcion']); ?></td>
                        <td><?php echo ($fila['nombre_materia']); ?></td>
                        <td><?php echo ($fila['fecha_consulta']); ?></td>
                        <td><?php echo ($fila['hora_consulta']); ?></td>
                        <td>
                            <form action="listainscriptos.php" method="post">
                                <input type="hidden" name="idconsulta" value="<?php echo ($fila['id_consulta']) ?>">
                                <input type="hidden" name="page" value="<?php echo($current_page)?>">
                                <button type="submit" class="btn btn-info"> Ver inscriptos </button>
                            </form>
                        </td>
                        <?php
                        if($fila['id_estado_consulta'] == 3) {
                            ?>
                            <td><button type="button" class="btn btn-danger" disabled
                            title="Consulta bloqueada."> Bloqueada </button></td>
                        <?php
                        }
                        else if (strtotime($fila['fecha_consulta'].' '.$fila['hora_consulta'])>$vHoraLimiteBloqueo ) {
                        ?>
                            <td><button type="button" class="btn btn-danger" data-toggle="modal" data-target="#modal<?php echo ($fila['id_consulta']); ?>"> Bloquear </button></td>
                        
                        <!-- Modal Bloqueo -->
                        <div class="modal fade" id="modal<?php echo ($fila['id_consulta']); ?>" tabindex="-1" role="dialog"
                            aria-labelledby="modalbloqueo<?php echo ($fila['id_consulta']); ?>" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <form action="consultasProfesor.php" method="post">  
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="modalbloqueo<?php echo ($fila['id_consulta']); ?>">Bloqueo de consulta</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>  
                                        <div class="modal-body">
                                            <label for="motivo<?php echo ($fila['id_consulta']); ?>">Ingrese el motivo del bloqueo<span class="data-required">*</span></label>
                                            <input name="motivo" type="text" class="form-control" id="motivo<?php echo ($fila['id_consulta']);?>" required>
                                            <input name="fechaConsultaReal" type="hidden" id="fechaConsultaReal<?php echo ($fila['id_consulta']);?>" value="<?php echo($fila['fecha_consulta']);?>">
                                            <p> </p>
                                            <label for="consultaAlternativa<?php echo ($fila['id_consulta']); ?>">Ingrese consulta alternativa</label>
                                            <div id="consultaAlternativa<?php echo ($fila['id_consulta']); ?>">
                                                <div class="form-group col-4">
                                                    <label for="selectDia">Día</label>
                                                    <select class="form-control" name="selectDia" id="selectDia<?php echo ($fila['id_consulta']);?>">
                                                        <option value="lunes">Lunes</option>
                                                        <option value="martes">Martes</option>
                                                        <option value="miercoles">Miércoles</option>
                                                        <option value="jueves">Jueves</option>
                                                        <option value="viernes">Viernes</option>
                                                    </select>
                                                </div>
                                                <div class="form-group col-4">
                                                    <label for="inputHora">Hora</label>
                                                    <input name="inputHora" type="time" class="form-control" id="inputHora<?php echo ($fila['id_consulta']);?>">
                                                </div>
                                            </div>
                                            <input name="inputMateria" type="hidden" id="inputMateria<?php echo ($fila['id_consulta']); ?>" value="<?php echo($fila['id_materia']);?>">
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                            <input name="id_consulta" type="hidden" class="form-control"
                                                id="id_consulta<?php echo ($fila['id_consulta']); ?>" value="<?php echo ($fila['id_consulta']); ?>">
                                            <button type="submit" name="actionType" value="bloquear"
                                                class="btn btn-danger">Bloquear</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <?php
                        }
                        else {    
                            if($fila['id_estado_consulta'] == 2) {?>
                            <td><button type="button" class="btn btn-info" disabled
                            title="La consulta ya fue realizada."> Realizada </button></td>
                            <?php
                            }
                            if($fila['id_estado_consulta'] == 1) {?>
                                <form action="consultasProfesor.php" method="POST">
                                    <input type="hidden" name="id_consulta" id="id_realizar<?php echo ($fila['id_consulta']); ?>" value="<?php echo ($fila['id_consulta']); ?>">
                                    <td><button type="submit" class="btn btn-info" name="actionType" value="consultaRealizada"> Marcar como realizada </button></td>
                                </form>
                                <?php
                                }
                        }
                        ?>

                    </tr>
        <?php
        }
        if (isset($vResultado)) {
            // Liberar conjunto de resultados
            mysqli_free_result($vResultado);
            // Cerrar la conexion
            mysqli_close($link);
        }
        ?>

            </table>
        </div>
        <ul class="pagination">
        <?php
for ($page = 1; $page <= $total_pages; $page++) {?>
    <li class="page-item
    <?php
    if ($page == $current_page) {
        echo 'active';
    }?>"><a class="page-link" href="<?php echo('consultasProfesor.php?page='.$page)?>"><?php echo($page)?></a></li>
<?php }
?>
</ul>
        <p>&nbsp;</p>
        <?php
        include("footer.html");
}
else {
    header("location:index.php");
}?>
</body>