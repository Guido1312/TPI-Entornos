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
include("headerAlumno.html");
include("conexion.inc");
$vIDprofesor = 1; #$_POST ['id_profesor'];
if (!empty($_POST ['from'])) {
    $vFechaDesde = $_POST ['from'];
}
if (!empty($_POST ['to'])) {
    $vFechaHasta = $_POST ['to'];
}


$vSql = "SELECT * FROM consultas c inner join materias m on c.id_materia = m.id_materia
                                    inner join especialidades e on m.id_especialidad = e.id_especialidad
                                    inner join profesores p on c.id_profesor = p.id_profesor
                                    where c.id_profesor = '$vIDprofesor'";
if (!empty($_POST ['from'])) {
    $vSql .= " and c.fecha_consulta between '$vFechaDesde' and '$vFechaHasta'";
}
                                   
$vResultado = mysqli_query($link, $vSql);

?>
    <form action="consultasProfesor.php" method="POST" name="FiltrarConsultas">
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
        <button type="submit" class="btn btn-primary btn-block">Filtrar</button>
    </form>
    <table border=1>
        <tr>
            <td><b>Especialidad</b></td>
            <td><b>Materia</b></td>
            <td><b>Fecha</b></td>
            <td><b>Hora</b></td>
            <td></td>
            <td></td>
        </tr>
<?php

while ($fila = mysqli_fetch_array($vResultado))
{
?>
            <tr>
                <td><?php echo ($fila['descripcion']); ?></td>
                <td><?php echo ($fila['nombre_materia']); ?></td>
                <td><?php echo ($fila['fecha_consulta']); ?></td>
                <td><?php echo ($fila['hora_consulta']); ?></td>
                <td><button type="button" class="btn btn-info"> Ver inscriptos </button></td>
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
    <p>&nbsp;</p>
<?php
include("footer.html");
?>
</body>