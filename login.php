<!DOCTYPE html>
<html lang="es">
<?php session_start(); ?>

<head>
  <?php
include("head.html");
?>
</head>

<body>
  <?php
include("conexion.inc");
if (isset($_POST ['actionType']) && $_POST ['actionType']=="logout"){
  session_destroy();
}
elseif (isset($_SESSION['usuario'])){
  header("location:index.php");
}

//Login toma datos de la BD
elseif(isset($_POST['ingresar'])){
    $Lusuario = $_POST["inputUser"];
    $Lpass = $_POST["inputPass"];
    if (isset($link)) {
    try {
    $vSql = "SELECT u.*, ea.id_alumno, ea.id_especialidad, p.id_profesor FROM usuarios u 
            LEFT JOIN alumnos a ON a.id_usuario = u.id_usuario
            LEFT JOIN especialidades_alumnos ea ON ea.id_alumno = a.legajo
            LEFT JOIN profesores p ON p.id_usuario = u.id_usuario
             WHERE u.nombre_usuario = '$Lusuario' 
                                    and u.password = '$Lpass'";
    $vResult = mysqli_query($link, $vSql);
    
    while ($fila = mysqli_fetch_array($vResult))
    {
      $usuarioOk = $fila['nombre_usuario']; 
      $passwordOk = $fila['password'];
      $idUsuarioOk= $fila['id_usuario'];
      $rolUsuarioOk= $fila['rol'];  
      if (isset($fila['id_alumno'])){
        $especialidad = $fila['id_especialidad'];
        $idAlumno = $fila['id_alumno'];
      }
      if (isset($fila['id_profesor'])){
        $idProfesor = $fila['id_profesor'];
      }
    }
    } catch (mysqli_sql_exception $e) {
      $vTipoMensaje = "danger";
      $vMensaje = "Problemas de conexión a la base de datos";
    }
    }

    if(isset($Lusuario) && isset($Lpass))
    {
      if($Lusuario==$usuarioOk && $Lpass==$passwordOk){
        $_SESSION['usuario']=$idUsuarioOk;
        $_SESSION['rol']=$rolUsuarioOk;
        if ($rolUsuarioOk == 1) {
          $_SESSION['especialidad'] = $especialidad;
          $_SESSION['id_alumno'] = $idAlumno;
        }
        elseif ($rolUsuarioOk == 2) {
          $_SESSION['id_profesor'] = $idProfesor;
        }
        header("location:index.php");
      }
      else{
        $vTipoMensaje = "danger";
        $vMensaje = "Usuario o contraseña incorrectos";
      }
    }
}
?>

  <div class="container py-4" style="margin-top: 10%">
    <div class="row justify-content-center h-100 py-4">
        <div class="card col-sm-6 col-md-6 col-lg-6 shadow-lg p-3 mb-5 bg-white rounded">
            <div class="card-header content-center">
              <img class="card-img-top" src="images/iconLogoUTN.png" alt="UTN" style="max-inline-size: 30%;">
            </div>
            <div class="card-body" id="cardLogin">
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" id="formIngreso" aria-labelledby="labelForm">
              <h1 class="text-success text-center card-title" id="labelForm" style="font-size: 20px">Digita tus credenciales</h1>
              <div class="form-grup">
                  <div class="input-group">
                    <input type="text" style="text-transform:lowercase;" name="inputUser" title="Ingresar usuario" placeholder="Usuario" class="form-control" required>
                  </div>
                  <div class="input-group py-2">
                    <input type="password" name="inputPass" title="Ingresar contraseña" placeholder="contraseña" class="form-control" required>
                  </div>
                  <div class="input-group">
                    <button type="submit" name="ingresar" title="Boton ingresar" value="Ingresar" class="btn btn-sm btn-info btn-block"> Ingresar </button>
                  </div>
              </div>
            </form>
          </div>
        </div>
    </div>


  <?php include("mensaje.php"); ?>

</body>