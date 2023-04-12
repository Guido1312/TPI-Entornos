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
<script language="Javascript">
function imprSelec(nombre) {
  var ficha = document.getElementById(nombre);
  var ventimp = window.open(' ', 'popimpr', 'height=400,width=600');
  ventimp.document.write( ficha.innerHTML );
  ventimp.document.close();
  ventimp.print( );
  ventimp.close();
}
</script>
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
if (isset($_SESSION['usuario']) & $_SESSION['rol']!=3){
    header("location:index.php");
}
elseif (isset($_SESSION['usuario']) & $_SESSION['rol']==3){
    include("headerAlumno.php");
    include("conexion.inc");

    if (!empty($_POST['from'])) {
        $vFechaSeleccionada = $_POST['from'];
    }
    else{
        $vFechaSeleccionada = new DateTime("now", new DateTimeZone('America/Argentina/Buenos_Aires'));
        $vFechaSeleccionada = $vFechaSeleccionada->format('Y-m-d');
    }


    $vSql = "SELECT * FROM consultas c inner join profesores p on c.id_profesor = p.id_profesor
                                        inner join materias m on c.id_materia = m.id_materia
                                        where c.fecha_consulta = '$vFechaSeleccionada';";
    $vResultado = mysqli_query($link, $vSql);
    ?>
        

        <form action="listadocentesdia.php" method="POST" name="FiltrarPorDia">
            <label for="from">Fecha:</label>
            <?php
            if (empty($_POST ['from'])) {
            ?>
                <input type="text" id="from" name="from">
            <?php
            }
            else {
            ?>
                <input type="date" id="from" name="from" value=<?php echo ($_POST ['from'])?>>
            <?php
            }
            ?>
            <button type="submit" class="btn btn-primary btn-block">Seleccionar</button>
        </form>


    <div id="myPrintArea" class="table-responsive">
        <table class="table">
            <thead style="background-color: #077b83; color: #ffff ;">
            <tr>
                <th><b>Profesor</b></td>
                <th><b>Materia</b></td>
                <th><b>Hora</b></td><th>
                <th><b>Motivo de cancelacion</b></td>
                    
                <a class="nav-item" href="javascript:imprSelec('myPrintArea')" style="float:right;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="27" height="27" fill="currentColor" class="bi bi-printer-fill" viewBox="0 0 16 16">
                            <path d="M5 1a2 2 0 0 0-2 2v1h10V3a2 2 0 0 0-2-2H5zm6 8H5a1 1 0 0 0-1 1v3a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1v-3a1 1 0 0 0-1-1z"/>
                            <path d="M0 7a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v3a2 2 0 0 1-2 2h-1v-2a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v2H2a2 2 0 0 1-2-2V7zm2.5 1a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1z"/>
                    </svg>
                </a>        
            </tr>
            </thead>
    <?php

    while ($fila = mysqli_fetch_array($vResultado)){?>
            <tr>
                <td><?php echo ($fila['nombre_apellido']); ?></td>
                <td><?php echo ($fila['nombre_materia']); ?></td>
                <td><?php echo ($fila['hora_consulta']); ?></td><th>
                <td><?php echo ($fila['motivo_cancelacion']); ?></td>
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