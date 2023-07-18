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
function imprSelec(nombre) {
  var ficha = document.getElementById(nombre);
  var ventimp = window.open(' ', 'popimpr', 'height=400,width=600');
  ventimp.document.write( ficha.innerHTML );
  ventimp.document.close();
  ventimp.print( );
  ventimp.close();
}
</script>
</head>

<body>  
<?php
if (isset($_SESSION['usuario']) & $_SESSION['rol']!=3){
    header("location:index.php");
}
elseif (isset($_SESSION['usuario']) & $_SESSION['rol']==3){
    include("conexion.inc");
    include("headerAdmin.php");

    if (!empty($_POST['from'])) {
        $vFechaSeleccionada = $_POST['from'];
    }
    else{
        $vFechaSeleccionada = new DateTime("now", new DateTimeZone('America/Argentina/Buenos_Aires'));
        $vFechaSeleccionada = $vFechaSeleccionada->format('Y-m-d');
    }


    try {
    $vSql = "SELECT * FROM consultas c inner join profesores p on c.id_profesor = p.id_profesor
                                        inner join materias m on c.id_materia = m.id_materia
                                        where c.fecha_consulta = '$vFechaSeleccionada';";
    $vResultado = mysqli_query($link, $vSql);
    ?>
    
        <form action="listadocentesdia.php" method="POST" name="FiltrarPorDia">
            <label for="from">Fecha:</label>
            <input type="date" id="from" name="from" value=<?php echo ($vFechaSeleccionada)?>>
            <button type="submit" class="btn btn-primary btn-block">Seleccionar</button>
        </form>


    <div id="myPrintArea" class="table-responsive">
        <table class="table">
            <thead style="background-color: #077b83; color: #ffff ;">
            <tr>
                <th><b>Profesor</b></th>
                <th><b>Materia</b></th>
                <th><b>Hora</b><th>
                <th><b>Motivo de cancelacion</b></th>
                   
                <th>
                <a class="nav-item" href="javascript:imprSelec('myPrintArea')" title="Imprimir lista" style="float:right;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="27" height="27" fill="currentColor" class="bi bi-printer-fill" viewBox="0 0 16 16">
                            <path d="M5 1a2 2 0 0 0-2 2v1h10V3a2 2 0 0 0-2-2H5zm6 8H5a1 1 0 0 0-1 1v3a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1v-3a1 1 0 0 0-1-1z"/>
                            <path d="M0 7a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v3a2 2 0 0 1-2 2h-1v-2a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v2H2a2 2 0 0 1-2-2V7zm2.5 1a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1z"/>
                    </svg>
                </a>   
                </th>     
            </tr>
            </thead>
    <?php

    while ($fila = mysqli_fetch_array($vResultado)){?>
            <tr>
                <td><?php echo ($fila['nombre_apellido']); ?></td>
                <td><?php echo ($fila['nombre_materia']); ?></td>
                <td><?php echo ($fila['hora_consulta']); ?></td>
                <td><?php echo ($fila['motivo_cancelacion']); ?></td>
                <td></td>
                <td></td>
            </tr>
    <?php
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
}
?>
</body> 