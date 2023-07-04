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
error_reporting(0); //evita que se muestren los warning
include("conexion.inc");
if (isset($_POST ['actionType']) && $_POST ['actionType']=="logout"){
  session_destroy();
}
elseif (isset($_SESSION['usuario'])){
  header("location:index.php");
}
// Se envia la contraseña a recuperar
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
        }

        $destinatario = $vEmail;
        $asunto = "Contraseña sistema de consultas UTN";
        $cuerpo = "
        <html>
        <head>
        <title>UTN - Consultas</title>
        </head>
        <body>
        <p>Sus credenciales de acceso al sistema son:</p>
        <p>Usuario: ".$nombreUsuario." </p> 
        <p>Contraseña: ".$password." </p>
        </body>
        </html>";
        $cabeceras  = 'MIME-Version: 1.0' . "\r\n";
        $cabeceras .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
        $cabeceras .= 'From: me@you.com' . "\r\n";

        if(mail($destinatario,$asunto,$cuerpo,$cabeceras)){
            $vTipoMensaje = "success"; 
            $vMensaje = "Se ha enviado la contraseña";
          }
          else {
            $vTipoMensaje = "danger";
            $vMensaje = "Ha ocurrido un error, intente nuevamente";
        };
        
}
//Login toma datos de la BD
elseif(isset($_POST['ingresar'])){
    $Lusuario = $_POST["inputUser"];
    $Lpass = $_POST["inputPass"];
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

<div class="container py-4">
     <div class="row justify-content-center h-100 py-4">
         <div class="card col-sm-6 col-md-6 col-lg-6 shadow-lg p-3 mb-5 bg-white rounded">
            <article class="card-body">
                <div style="text-align: center";>
                  <img src="https://caimasegall.com.ar/wp-content/uploads/2020/08/logo-UTN-1.png" alt="UTN" style="max-inline-size: 30%;">
                </div>
                <h4 class="card-title text-center">Consultas</h4>
                <hr>
                <p class="text-success text-center">Digita tus credenciales</p>
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                  <div class="form-grup">
                     <div class="input-group">
                       <input type="text" name="inputUser" title="Ingresar usuario" placeholder="Usuario" class="form-control" required>
                     </div>
                     <div class="input-group py-2">
                       <input type="password" name="inputPass" title="Ingresar contraseña" placeholder="Contraseña" class="form-control" required>
                     </div>
                     <div class="input-group">
                       <input type="submit" name="ingresar" title="Boton ingresar" value="Ingresar" class="btn btn-sm btn-info btn-block">
                     </div>
                  </div>
                </form>
            </article>
         </div>
     </div>

    <div class="text-center">
        <a href="#modalRecuperacion" data-toggle="modal" data-target="#modalRecuperacion">
          Olvidaste tu contraseña?
        </a>
    </div>
  </div>
  <?php include("mensaje.php"); ?>

  <!-- Modal Recuperacion -->
  <div class="modal fade" id="modalRecuperacion" tabindex="-1" role="dialog" aria-labelledby="exampleAlabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalLabel">Ingrese su email</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form action="login.php" method="post">
            <div class="form-group col-md-6">
              <label for="inputEmail">Email</label>
              <input name="inputEmail" type="text" class="form-control" id="inputEmail" required />
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
          <button type="submit" name="actionType" value="recuperacion" class="btn btn-success">Enviar</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</body>