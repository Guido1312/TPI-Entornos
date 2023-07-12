<?php session_start(); ?>
<!DOCTYPE html>
<html lang="es">

<head>
<?php
include("head.html");
?>  
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
</head>

<body>  
<?php
if (isset($_SESSION['usuario']) & $_SESSION['rol']!=2){
    header("location:index.php");
}
elseif (isset($_SESSION['usuario']) & $_SESSION['rol']==2){
    include("conexion.inc");
    include("headerProfesor.php");
    $vIDprofesor = $_SESSION['id_profesor'];
    $vIDconsulta = $_POST['idconsulta'];

    $vSql = "SELECT * FROM inscripciones i inner join alumnos a on i.id_alumno = a.legajo
                                        inner join consultas c on i.id_consulta = c.id_consulta
                                        where c.id_profesor = '$vIDprofesor' and i.id_consulta = '$vIDconsulta' and i.estado_inscripcion in (1,2)";
    $vResultado = mysqli_query($link, $vSql);
    ?>
        
    <div id="myPrintArea" class="table-responsive">
        <table class="table">
            <thead style="background-color: #077b83; color: #ffff ;">
            <tr>
                <th><b>Legajo</b></th>
                <th><b>Nombre y apellido</b></th>
                <th><b>Email</b></th>
                <th>
                    <a title="Imprimir" class="nav-item" href="javascript:imprSelec('myPrintArea')" style="float:right;">
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
                <td><?php echo ($fila['legajo']); ?></td>
                <td><?php echo ($fila['nombre_apellido']); ?></td>
                <td><?php echo ($fila['mail']); ?></td>
                <td></td>
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
    <a href="consultasProfesor.php"><button type="button" class="btn btn-info"> Volver a Consultas </button></a>
    <?php
    include("footer.html");
}
else {
    header("location:index.php");
}
?>
</body> 