<?php session_start(); ?>

<!DOCTYPE html>
<html lang="es">
<head>
<?php
include("head.html");
?>  
    <style>
        .card:hover {
    transform: scale(1.05);
    }
    .card{
    transition: transform .5s;
    }
    </style>
</head>
<body>
<?php
    if (isset($_SESSION['usuario'])){
        include("conexion.inc");
        //index alumno
        if ($_SESSION['rol']==1){
            include("headerAlumno.php");
            
            $vUsuario = $_SESSION['usuario'];
            $vSql = "SELECT a.nombre_apellido FROM usuarios u INNER JOIN alumnos a on a.id_usuario = u.id_usuario
                                    WHERE u.id_usuario = '$vUsuario'";
            $vResult = mysqli_query($link, $vSql);
            while ($fila = mysqli_fetch_array($vResult))
            {
            $nombrePersona = $fila['nombre_apellido']; 
            }
            ?>
    
                    <div class="row">
                        <h2>Bienvenido <?php echo $nombrePersona; ?></h2>
                    </div>

                    <div class="row card-deck">
                        <div class="card">
                            <img src="images/iconList.png" class="card-img-top" alt="Inscribirse a consultas">
                            <div class="card-body content-center">
                            <h5 class="card-title">Inscribirse a consultas</h5> 
                            <a href="inscribir.php" class="stretched-link"></a>
                            </div>
                        </div>
                        <div class="card">
                            <img src="images/iconMyInscriptions.png" class="card-img-top" alt="Mis inscripciones">
                            <div class="card-body content-center">
                            <h5 class="card-title">Mis inscripciones</h5> 
                            <a href="misinscripciones.php" class="stretched-link"></a>
                            </div>
                        </div>
                        <div class="card">
                            <img src="images/iconCalendar.png" class="card-img-top" alt="Calendario academico">
                            <div class="card-body content-center">
                            <h5 class="card-title">Calendario académico</h5> 
                            <a class="stretched-link" href="#modalCalendario" data-toggle="modal" data-target="#modalCalendario" > </a>
                            </div>
                        </div>
                    </div>
                
        <?php
        }
        //index profesor
        elseif($_SESSION['rol']==2){
            include("headerProfesor.php");

            $vUsuario = $_SESSION['usuario'];
            $vSql = "SELECT p.nombre_apellido FROM usuarios u INNER JOIN profesores p on p.id_usuario = u.id_usuario
                                    WHERE u.id_usuario = '$vUsuario'";
            $vResult = mysqli_query($link, $vSql);
            while ($fila = mysqli_fetch_array($vResult))
            {
            $nombrePersona = $fila['nombre_apellido']; 
            }
            ?>
                    <div class="row container content-center">
                        <h2>Bienvenido <?php echo $nombrePersona; ?></h2>
                    </div>

                    <div class="row card-deck" style="margin: 0px 120px 0px 120px;">
                        <div class="card" style="max-width: 500px;">
                            <img src="images/adminConsultas.png" class="card-img-top" alt="Administrar consultas">
                            <div class="card-body content-center">
                            <h5 class="card-title">Administrar consultas</h5> 
                            <a href="consultasProfesor.php" class="stretched-link"></a>
                            </div>
                        </div>
                        <div class="card">
                            <img src="images/iconCalendar.png" class="card-img-top" alt="Calendario academico">
                            <div class="card-body content-center">
                            <h5 class="card-title">Calendario académico</h5> 
                            <a class="stretched-link" href="#modalCalendario" data-toggle="modal" data-target="#modalCalendario" > </a>
                            </div>
                        </div>
                    </div>
        <?php }
        //index administrador
        if ($_SESSION['rol']==3){
            include("headerAdmin.php");
            ?>
                    <div class="row card-deck">
                        <div class="card">
                            <img src="images/iconAlumno.png" class="card-img-top" alt="ABM Alumnos">
                            <div class="card-body content-center">
                            <h5 class="card-title">ABM Alumnos</h5> 
                            <a href="abmAlumnos.php" class="stretched-link"></a>
                            </div>
                        </div>
                        <div class="card">
                            <img src="images/iconProfesor.png" class="card-img-top" alt="ABM Profesores">
                            <div class="card-body content-center">
                            <h5 class="card-title">ABM Profesores</h5> 
                            <a href="abmProfesores.php" class="stretched-link"></a>
                            </div>
                        </div>
                        <div class="card">
                            <img src="images/iconUser.png" class="card-img-top" alt="ABM Usuarios">
                            <div class="card-body content-center">
                            <h5 class="card-title">ABM Usuarios</h5> 
                            <a href="abmUsuarios.php" class="stretched-link"></a>
                            </div>
                        </div>
                    </div>
        <?php }?>
    <?php
    include("footer.html");
    }
    else {
        header("location:login.php");
    }?>
</body>