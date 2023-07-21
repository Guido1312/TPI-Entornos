<?php 
include("sendMail.php");
session_start(); ?>
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
    
    try {
    $vIDalumno = $_SESSION['id_alumno'];

    $vIDespecialidad = $_SESSION['especialidad'];

    if (!empty($_POST ['actionType']) && !empty($_POST["inputIDconsulta"]) && $_POST ['actionType']=="inscribirse") {
        $vIDconsulta = $_POST["inputIDconsulta"];
        $vSqlCount = "SELECT COUNT(*) as cantidad FROM inscripciones WHERE id_consulta = '$vIDconsulta' and id_alumno = '$vIDalumno'";
        $vSqlValidate = "SELECT COUNT(*) as consulta FROM consultas WHERE id_consulta = '$vIDconsulta' and addtime(fecha_consulta,hora_consulta) >= date_add(utc_timestamp(), INTERVAL -3 HOUR)";
        $resultCount = mysqli_query($link, $vSqlCount);
        $data=mysqli_fetch_assoc($resultCount);
        $resultValidate = mysqli_query($link, $vSqlValidate);
        $dataValidate=mysqli_fetch_assoc($resultValidate);
        if ($dataValidate['consulta'] == 1){
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

                customMail($EmailProfesor, $asunto, $cuerpo);

                $vTipoMensaje = "success";
                $vMensaje = "Se ha inscripto exitosamente";
            }
            else{
                $vTipoMensaje = "danger";
                $vMensaje = "Ha ocurrido un error, intente nuevamente";
            }
        }
        else{
            $vTipoMensaje = "danger";
            $vMensaje = "Consulta no válida.";
        }
    }
    } catch (mysqli_sql_exception $e) {
        $vTipoMensaje = "danger";
        $vMensaje = "Problemas de conexión a la base de datos";
    }

    include("headerAlumno.php");
    
    try{
    if (!empty($_POST ['from'])) {
        $vFechaDesde = $_POST ['from'];
    }
    else {
        $vFechaDesde = new DateTime("now", new DateTimeZone('America/Argentina/Buenos_Aires'));
        $vFechaDesde = $vFechaDesde->format('Y-m-d');
    }

    if (!empty($_POST ['to'])) {
        $vFechaHasta = $_POST ['to'];
    }
    else {
        $vFechaHasta = date_add(new DateTime("now", new DateTimeZone('America/Argentina/Buenos_Aires')),date_interval_create_from_date_string('60 days'));
        $vFechaHasta = $vFechaHasta->format('Y-m-d');
    }

    $vSql = "SELECT * FROM consultas c inner join materias m on c.id_materia = m.id_materia
            inner join especialidades e on m.id_especialidad = e.id_especialidad
            inner join especialidades_alumnos ea on e.id_especialidad = ea.id_especialidad
            inner join profesores p on c.id_profesor = p.id_profesor
            where ea.id_alumno = '$vIDalumno' and ea.id_especialidad = '$vIDespecialidad'
                and not exists ( SELECT * FROM inscripciones i where i.id_consulta = c.id_consulta 
                                        and i.id_alumno = '$vIDalumno'
                                        and i.estado_inscripcion != 4) 
                                        and addtime(fecha_consulta,hora_consulta) >= date_add(utc_timestamp(), INTERVAL -3 HOUR) 
                                        and c.fecha_consulta between '$vFechaDesde' and '$vFechaHasta'";

    if (!empty($_POST ['materia']) && $_POST ['materia']!="0") {
        $vMateriaFiltro = $_POST ['materia'];
        $vSql .= " and c.id_materia = '$vMateriaFiltro'";
    }

    if (!empty($_POST ['profesor']) && $_POST ['profesor']!="0") {
        $vProfesorFiltro = $_POST ['profesor'];
        $vSql .= " and c.id_profesor = '$vProfesorFiltro'";
    }

    $vSqlMaterias = "SELECT m.id_materia, m.nombre_materia FROM materias m
                    inner join especialidades e on m.id_especialidad = e.id_especialidad
                    inner join especialidades_alumnos ea on e.id_especialidad = ea.id_especialidad
                    where ea.id_alumno = '$vIDalumno' and ea.id_especialidad = '$vIDespecialidad'"; 

    $vSqlProfesores = "SELECT DISTINCT p.id_profesor, p.nombre_apellido FROM profesores p
                        inner join consultas c on c.id_profesor = p.id_profesor
                        inner join materias m on m.id_materia = c.id_materia
                        inner join especialidades e on e.id_especialidad = m.id_especialidad
                        inner join especialidades_alumnos ea on ea.id_especialidad = e.id_especialidad
                        where ea.id_alumno = '$vIDalumno' and ea.id_especialidad = '$vIDespecialidad'";
                                    
    $vResultado = mysqli_query($link, $vSql);
    $vMaterias = mysqli_query($link, $vSqlMaterias);
    $vProfesores = mysqli_query($link, $vSqlProfesores);

    ?>
        <form action="inscribir.php" method="POST" name="FiltrarConsultas">
            <label for="from">Fecha desde:</label>
            <?php
            if (empty($_POST ['from'])) {
            ?>
                <input type="text" id="from" name="from" value=<?php echo ($vFechaDesde)?>>
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
                <input type="text" id="to" name="to" value=<?php echo ($vFechaHasta)?>>
            <?php
            }
            else {
            ?>
                <input type="text" id="to" name="to" value=<?php echo ($_POST ['to'])?>>
            <?php
            }
            ?>
            <br>
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
            <label for="profesor">Profesor:</label>
            <select name="profesor" id="profesor">
            <?php
            if (empty($_POST['profesor'])) {
            ?>
                <option value="0" selected>Todos</option>
            <?php        
            }
            else {
            ?>
                <option value="0">Todos</option>
            <?php
            }    
            while ($fila = mysqli_fetch_array($vProfesores))
            {
                if (!empty($_POST ['profesor']) && $_POST ['profesor']==$fila['id_profesor']) {
                ?>
                    <option value=<?php echo ($fila['id_profesor'])?> selected> <?php echo ($fila['nombre_apellido'])?></option>
                <?php        
                }
                else {
                ?>
                    <option value=<?php echo ($fila['id_profesor'])?>> <?php echo ($fila['nombre_apellido'])?></option>
                <?php
                }
            }
            ?>   
            </select>
            <button type="submit" name="actionType" value="filtrar" class="btn btn-primary btn-block">Filtrar</button>
        </form>

        <!-- Paginacion -->
        <?php $results_per_page = 5;
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
        
        ?>


        <div class="table-responsive">
        <table class="table">
            <thead style="background-color: #077b83; color: #ffff ;">
            <tr>
                <th><b>Materia</b></th>
                <th><b>Profesor</b></th>
                <th><b>Fecha</b></th>
                <th><b>Hora</b></th>
                <th></th>
            </tr>
        </thead>
        
    <?php
    foreach ($data_page as $fila)
    {?>
                <tr>
                    <td><?php echo ($fila['nombre_materia']); ?></td>
                    <td><?php echo ($fila['nombre_apellido']); ?></td>
                    <td><?php echo ($fila['fecha_consulta']); ?></td>
                    <td><?php echo ($fila['hora_consulta']); ?></td>
                    <td> 
                    <?php
                    if($fila['id_estado_consulta'] != 3) {
                    ?>
                        <form action="inscribir.php" method="post">
                            <input name="inputIDconsulta" type="text" class="form-control" style="display:none" id="inputIDconsulta<?php echo ($fila['id_consulta']); ?>" value="<?php echo ($fila['id_consulta']); ?>">
                            <button type="submit" name="actionType" value="inscribirse" class="btn btn-info"> Inscribirse </button>
                        </form>
                    <?php
                    }
                    else{
                    ?>
                        <input name="inputIDconsulta" type="text" class="form-control" style="display:none" id="inputIDconsulta<?php echo ($fila['id_consulta']); ?>" value="<?php echo ($fila['id_consulta']); ?>">
                        <button type="submit" name="actionTypeNone" class="btn btn-danger" disabled title="<?php echo ($fila['motivo_cancelacion']); ?>"> Bloqueada </button>
                    <?php
                    }
                    ?>
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
    <ul class="pagination">
            <?php
    for ($page = 1; $page <= $total_pages; $page++) {?>
        <li class="page-item
        <?php
        if ($page == $current_page) {
            echo 'active';
        }?>"><a class="page-link" href="<?php echo('inscribir.php?page='.$page)?>"><?php echo($page)?></a></li>
    <?php }
    } catch (mysqli_sql_exception $e) {
        $vTipoMensaje = "danger";
        $vMensaje = "Problemas de conexión a la base de datos";
    }
    ?>
    </ul>
            
            <p>&nbsp;</p>
            <?php
        include("footer.html");
    }
    else {
        header("location:index.php");
    }
    ?>
</body>