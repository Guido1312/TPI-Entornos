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
elseif (isset($_SESSION['usuario']) & $_SESSION['rol']==2){
    include("headerProfesor.php");
    include("conexion.inc");
    $vIDprofesor = $_SESSION['id_profesor'];

    if (!empty($_POST ['from'])) {
        $vFechaDesde = $_POST ['from'];
    }
    if (!empty($_POST ['to'])) {
        $vFechaHasta = $_POST ['to'];
    }

    $vSql = "SELECT e.descripcion, m.nombre_materia, c.fecha_consulta, c.hora_consulta, c.id_consulta FROM consultas c inner join materias m on c.id_materia = m.id_materia
                                        inner join especialidades e on m.id_especialidad = e.id_especialidad
                                        inner join profesores p on c.id_profesor = p.id_profesor
                                        where c.id_profesor = '$vIDprofesor'";
    if (!empty($_POST ['from'])) {
        $vSql .= " and c.fecha_consulta between '$vFechaDesde' and '$vFechaHasta'";
    }
                                    
        $vResultado = mysqli_query($link, $vSql);
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
                    <td><b>Especialidad</b></td>
                    <td><b>Materia</b></td>
                    <td><b>Fecha</b></td>
                    <td><b>Hora</b></td>
                    <td></td>
                    <td></td>
                </tr>
                </thead>
        <?php

        while ($fila = mysqli_fetch_array($vResultado))
        {
        ?>
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
                        <td><button type="button" class="btn btn-danger"> Bloquear </button></td>

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
}?>
</body>