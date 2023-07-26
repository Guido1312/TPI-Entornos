<!DOCTYPE html>
<html lang="es">
<?php 
include("sendMail.php");
session_start(); ?>

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
elseif (!empty($_POST ['actionType']) && $_POST ['actionType']=="recuperacion") {
  $vEmail = $_POST["inputEmail"];
  $vSql = "SELECT * FROM usuarios u LEFT JOIN alumnos a on a.id_usuario = u.id_usuario and u.rol = 1
                                  LEFT JOIN profesores p on p.id_usuario = u.id_usuario and u.rol = 2
                                  WHERE a.mail = '$vEmail' or p.mail = '$vEmail'";

      $vUsuario = mysqli_query($link, $vSql);
      while ($fila = mysqli_fetch_array($vUsuario))
      {
      $nombreUsuario = $fila['nombre_usuario']; 
      $password = $fila['password']; 
      customMail($vEmail, 'Datos de ingreso', '<p>Datos de ingreso al sistema de '.
                'gestión de consultas.</p> <p>Usuario: '.$nombreUsuario.'.</p> <p>Contraseña: '.$password.'.<p>');
      }
}
//Login toma datos de la BD
elseif(isset($_POST['ingresar'])){
    $Lusuario = $_POST["inputUser"];
    $Lpass = $_POST["inputPass"];
    if (isset($link)) {
    try {
    $vSql = "SELECT distinct u.*, ea.id_alumno, p.id_profesor FROM usuarios u 
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

    <div class="text-center">
        <a href="#modalRecuperacion" data-toggle="modal" data-target="#modalRecuperacion">
          Olvidaste tu contraseña?
        </a>
    </div>

  <?php include("mensaje.php"); ?>

    <!-- Modal Recuperacion -->
    <div class="modal fade" id="modalRecuperacion" tabindex="-1" role="dialog" aria-labelledby="labellRecuperacion"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
      <form action="login.php" method="post">
        <div class="modal-header">
          <h1 class="modal-title" id="labellRecuperacion" style="font-size: 25px">Ingrese su correo electronico</h1>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <div class="form-group col-md-6">
              <label for="inputEmail">Correo</label>
              <input name="inputEmail" type="text" class="form-control" id="inputEmail" required>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
          <button type="submit" name="actionType" value="recuperacion" class="btn btn-success">Enviar</button>
        </div>
        </form>
      </div>
    </div>
  </div>
</body>