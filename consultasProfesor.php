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
if (isset($_SESSION['usuario']) & $_SESSION['rol']!=2){
    header("location:index.php");
}
else if (isset($_SESSION['usuario']) & $_SESSION['rol']==2){
    include("conexion.inc");
    include("headerProfesor.php");
    $vIDprofesor = $_SESSION['id_profesor'];
    date_default_timezone_set("America/Argentina/Buenos_Aires");
    $vHoraLimiteBloqueo = strtotime('+ 2 hour');
    try {
    if (!empty($_POST ['actionType']))
    {
        if($_POST ['actionType'] == 'bloquear'){
            if (empty($_POST ['id_consulta']))
            {
                $vMensaje = 'Invalid request.';
            }
            else if (empty($_POST ['motivo']) || ($_POST ['motivo'] == ''))
            {
                $vMensaje = 'Debe ingresar un motivo de bloqueo.';
            }
            else
            {
                $vIdConsulta = $_POST['id_consulta'];
                $vMotivoBloqueo = $_POST['motivo'];
                $vSql = "UPDATE consultas SET motivo_cancelacion = '$vMotivoBloqueo', id_estado_consulta = 3
                where id_consulta = $vIdConsulta";

                if(mysqli_query($link, $vSql)) {
                    $vTipoMensaje = 'success';
                    $vMensaje = 'Consulta bloqueada.';
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

    if (!empty($_POST ['from'])) {
        $vFechaDesde = $_POST ['from'];
    }
    if (!empty($_POST ['to'])) {
        $vFechaHasta = $_POST ['to'];
    }

    $vSql = "SELECT e.descripcion, m.nombre_materia, c.fecha_consulta, c.hora_consulta, c.id_consulta, c.id_estado_consulta
                FROM consultas c inner join materias m on c.id_materia = m.id_materia
                inner join especialidades e on m.id_especialidad = e.id_especialidad
                inner join profesores p on c.id_profesor = p.id_profesor
                where c.id_profesor = '$vIDprofesor'";
    if (!empty($_POST ['from'])) {
        $vSql .= " and c.fecha_consulta between '$vFechaDesde' and '$vFechaHasta'";
    }
                                    
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
                        else if (strtotime($fila['fecha_consulta'])>$vHoraLimiteBloqueo or (($fila['fecha_consulta'] == date('Y-m-d')) and (date("G") + strtotime($fila['hora_consulta'])>$vHoraLimiteBloqueo))) {
                        ?>
                            <td><button type="button" class="btn btn-danger" data-toggle="modal" data-target="#modal<?php echo ($fila['id_consulta']); ?>"> Bloquear </button></td>
                        
                        <!-- Modal Bloqueo -->
                        <div class="modal fade" id="modal<?php echo ($fila['id_consulta']); ?>" tabindex="-1" role="dialog"
                            aria-labelledby="modalbloqueo<?php echo ($fila['id_consulta']); ?>" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <form action="consultasProfesor.php" method="post">  
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="modalbloqueo<?php echo ($fila['id_consulta']); ?>">Ingrese 
                                            motivo de bloqueo:</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>  
                                        <div class="modal-body">
                                            <input name="motivo" type="text" class="form-control" id="motivo<?php echo ($fila['id_consulta']); ?>">
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