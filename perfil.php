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

$vIdUsuario = $_SESSION['usuario'];

if ($_SESSION['rol']==1){
$vSqlDatos = "SELECT * FROM alumnos a inner join especialidades_alumnos ea on a.legajo = ea.id_alumno
                                        inner join especialidades e on e.id_especialidad = ea.id_especialidad
                                        inner join usuarios u on u.id_usuario = a.id_usuario
                                        where a.id_usuario = '$vIdUsuario' ";
    $vDatos = mysqli_query($link, $vSqlDatos);
    
    $fila = mysqli_fetch_array($vDatos);
      $usuario = $fila['nombre_usuario'];
      $password = $fila['password'];
      $nombre = $fila['nombre_apellido']; 
      $legajo = $fila['legajo'];
      $dni= $fila['dni'];
      $mail= $fila['mail'];
      $especialidad= $fila['descripcion'];
      mysqli_data_seek($vDatos, 0);
      include("headerAlumno.php");
}
else{
    $vSqlDatos = "SELECT * FROM profesores p inner join usuarios u on u.id_usuario = p.id_usuario
                                        where p.id_usuario = '$vIdUsuario' ";
    $vDatos = mysqli_query($link, $vSqlDatos);
    
    $fila = mysqli_fetch_array($vDatos);
      $usuario = $fila['nombre_usuario'];
      $password = $fila['password'];
      $nombre = $fila['nombre_apellido']; 
      $legajo = $fila['id_profesor'];
      $dni= $fila['dni'];
      $mail= $fila['mail'];
      include("headerProfesor.php");
}



   // Se guardan los cambios de modificar
    if (!empty($_POST ['actionType']) && !empty($_POST["inputIDusuario"]) && $_POST ['actionType']=="modificarPass") {
        $vActualPass = $_POST["inputActualPass"];
        $vNewPassword = $_POST["inputNewPass"];
        $vConfirmPassword = $_POST["repeatNewPass"];
        if($vActualPass != $password)
        {
            $vTipoMensaje = "danger";
            $vMensaje = "La contraseña actual ingresada no es correcta";
        }
        elseif ($vNewPassword != $vConfirmPassword)
        {
            $vTipoMensaje = "danger";
            $vMensaje = "Las contraseñas no coinciden";
        }
        else{
            $vSql = "UPDATE usuarios SET password = '$vNewPassword'
                    WHERE id_usuario = '$vIdUsuario'";
            if(mysqli_query($link, $vSql)) {
                $vTipoMensaje = "success";
                $vMensaje = "Se ha modificado la contraseña";
            }
            else{
                $vTipoMensaje = "danger";
                $vMensaje = "Ha ocurrido un error, intente nuevamente";
            }
        }
    }
?>
<br>
<br>

    <div class="container">
        <div class="row">
            <br>
        </div>
        <div class="row">
            <div class="col-12" style="text-align: center">
                <h2> <?php echo $usuario; ?> </h2>
            </div>
        </div>
        <div class="row" style="display: flex; justify-content: center;">
                <button type="button" class="btn btn-info" href="#modalModif" data-toggle="modal" data-target="#modalModif" style="float:right;"> Modificar contraseña </button>
        </div>  
        <div class="row">
            <br>
        </div>
        <div class="row marginApply">
            <div class="col-12 col-md-1">
                <br>
            </div>
            <div class="col-12 col-md-5">
                <h4>Datos del usuario</h5>
                <p style="color: #252525">
                Nombre: <?php echo $nombre; ?> <br>
                Legajo: <?php echo $legajo; ?> <br>
                DNI: <?php echo $dni; ?> <br>
                Mail: <?php echo $mail; ?>  <br>
                <?php if ($_SESSION['rol']==1){?>
                Especialidad: <br>
                <?php while ($fila2 = mysqli_fetch_array($vDatos))
                            {
                            ?>
                            &nbsp; &nbsp; - <?php echo ($fila2['descripcion']); ?> <br>
                                    <?php
                            }
                }?>
                </p>
                
            </div>
            <div class="col-12 col-md-2">
                <br>
            </div>
            <div class="col-12 col-md-4">
                <h4>Otras opciones</h4>
                <p style="color: blue">
                <a href="https://www.alumnos.frro.utn.edu.ar/" >Inscripcion a cursado</a><br>
                <a href="https://www.frro.utn.edu.ar/">Pagina UTN</a><br>
                <a href="https://www.frro.utn.edu.ar/bolsa.php?cont=130&subc=2">Bolsa de trabajo</a><br>
                </p>
            </div>
            
        </div>
    </div>




    <!-- Modal Modificacion -->
    <div class="modal fade" id="modalModif" tabindex="-1" role="dialog"
                    aria-labelledby="exampleMlabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="modalLabel">Modificar
                                    Contraseña</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form action="perfil.php" method="post">
                                    <div class="form-group col-md-6">
                                        <label for="inputNombre">Nombre de usuario</label>
                                        <input name="inputNombre" type="text" class="form-control" id="inputNombre"
                                            value="<?php echo ($usuario)?> " readonly>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="inputActualPass">Ingrese contraseña actual</label>
                                        <input name="inputActualPass" type="password" class="form-control" id="inputActualPass" required/>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="inputNewPass">Ingrese contraseña nueva</label>
                                        <input name="inputNewPass" type="password" class="form-control" id="inputNewPass" required/>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="repeatNewPass">Repita su nueva contraseña</label>
                                        <input name="repeatNewPass" type="password" class="form-control" id="repeatNewPass" required/>
                                    </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                <input name="inputIDusuario" type="text" class="form-control" style="display:none"
                                    id="inputIDusuario" value="<?php echo ($vIdUsuario); ?>">
                                <button type="submit" name="actionType" value="modificarPass" class="btn btn-primary">Guardar cambios</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

<?php
include("footer.html");
}
else {
    header("location:login.php");
}?>

</body>