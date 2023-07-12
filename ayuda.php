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

if (isset($_SESSION['usuario']) & ($_SESSION['rol']==1 || $_SESSION['rol']==2)){
include("conexion.inc");

$vRol = $_SESSION['rol'];
$vSql = "SELECT * FROM preguntas_frecuentes p where p.id_rol_usuario = '$vRol' ";
$vDatos = mysqli_query($link, $vSql);
    
$results_per_page = 5;
$data = mysqli_fetch_all($vDatos, MYSQLI_ASSOC);
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

if ($_SESSION['rol']==1){
    include("headerAlumno.php");
}
else{
    include("headerProfesor.php");
}
?>
<br>
<br>

    <div class="container content-center">
        <div class="row" style="text-align: center">
            <h2>Preguntas frecuentes</h2>
        </div>
        
        <div class="container"  id="accordion">
            <?php
            foreach ($data_page as $fila)
            {?>
                <div class="card">
                    <div class="card-header" id="heading<?php echo ($fila['id_pregunta_frecuente']); ?>">
                    <h5 class="mb-0">
                        <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapse<?php echo ($fila['id_pregunta_frecuente']); ?>" aria-expanded="false" aria-controls="collapse<?php echo ($fila['id_pregunta_frecuente']); ?>">
                        <?php echo ($fila['titulo']); ?>
                        </button>
                    </h5>
                    </div>

                    <div id="collapse<?php echo ($fila['id_pregunta_frecuente']); ?>" class="collapse" 
                        aria-labelledby="heading<?php echo ($fila['id_pregunta_frecuente']); ?>" data-parent="#accordion">
                    <div class="card-body">
                        <?php echo ($fila['descripcion']); ?>
                    </div>
                    </div>
                </div>
            <?php
            }
            ?>
        </div>
        
        
    <ul class="row pagination">
        <?php
        // Liberar conjunto de resultados
        mysqli_free_result($vDatos);
        // Cerrar la conexion
        mysqli_close($link);
        for ($page = 1; $page <= $total_pages; $page++) {?>
        <li class="page-item
        <?php
        if ($page == $current_page) {
            echo 'active';
        }?>"><a class="page-link" href="<?php echo('ayuda.php?page='.$page)?>"><?php echo($page)?></a></li>
        <?php }
        ?>
    </ul>

    </div>
    <p>&nbsp;</p>
<?php
include("footer.html");
}
else {
    header("location:index.php");
}?>

</body>