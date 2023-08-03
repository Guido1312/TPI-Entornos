<?php 
function generarCodigoAleatorio($longitud) {
    $caracteres = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $codigo = '';
    for ($i = 0; $i < $longitud; $i++) {
        $codigo .= $caracteres[mt_rand(0, strlen($caracteres) - 1)];
    }
    return $codigo;
}
//validacion del lado del servidor
function validarDatos($vNombreUsuario,$vDNI,&$vMensaje) {
  if(empty($vNombreUsuario) || empty($vDNI))
    {
    $vTipoMensaje = "danger";
    $vMensaje = "No se han rellenado todos los campos";
    return false;
    }
    $vSql = "SELECT count(*) FROM usuarios u
              WHERE u.nombre_usuario = '$vNombreUsuario'";
    $vResultado = mysqli_query($link, $vSql);
    if(mysqli_num_rows($vResultado) == 0)
    {
        $vTipoMensaje = "danger";
        $vMensaje = "Nombre de usuario ya registrado. Por favor seleccione uno distinto.";
        return false;
    }
    else if(!preg_match('/^[a-zA-Z\s]+$/', $vNombreUsuario))
    {
    $vTipoMensaje = "danger";
    $vMensaje = "Solo se deben usar letras en el nombre de usuario, sin espacios";
    return false;
    }
    else if(!is_numeric($vDNI))
    {
        $vTipoMensaje = "danger";
        $vMensaje = "Solo se deben usar numeros en el DNI";
        return false;
    }
    else if($vDNI > 999999999)
    {
        $vTipoMensaje = "danger";
        $vMensaje = "El DNI debe tener 9 dígitos o menos";
        return false;
    }
    else
    {
        return true;
    }
 }
?>
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
if (isset($_GET['mensaje'])){
  $vMensaje=$_GET['mensaje'];
}
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
elseif(isset($_POST['registrar'])){
  $vEmail = $_POST["inputEmail"];
  $vNombreUsuario = $_POST['inputUser']; 
  $vPassword = $_POST['inputPassword']; 
  $vRol = $_POST['selectRol']; 
  $vDNI = $_POST['inputDni']; 
  if (validarDatos($vNombreUsuario,$vDNI,$vMensaje))
  {
    if ($vRol == "Alumno")
    {
      $vSql = "SELECT * FROM alumnos a WHERE a.mail = '$vEmail' and a.dni='$vDNI'";
      $vIDRol = 1;
    }
    else
    {
      $vSql = "SELECT * FROM profesores p WHERE p.mail = '$vEmail' and p.dni='$vDNI'";
      $vIDRol = 2;
    }
    $vResultado = mysqli_query($link, $vSql);
    if (mysqli_num_rows($vResultado) == 0) {
      $vTipoMensaje = "danger";
      $vMensaje = "No se encontro un ".$vRol." para los datos ingresados. Comuniquese con el departamento de alumnos.";
    }
    else {
      // Generar un código aleatorio de 8 caracteres
      $codigoAleatorio = generarCodigoAleatorio(20);
      $vSql = "INSERT INTO registro_usuarios(id_rol_usuario,dni,nombre_usuario,password,codigo,validado,fecha) values($vIDRol,$vDNI,'$vNombreUsuario','$vPassword','$codigoAleatorio',
              0,current_timestamp())";
     if(mysqli_query($link, $vSql)){
          customMail($vEmail, 'Registro a gestión de consultas', '<p>Se ha ingresado una solicitud para registrarse al sistema de gestión de consultas.</p>'.
          '<br><p>Datos de ingreso al sistema de '.
          'gestión de consultas.</p> <p>Usuario: '.$vNombreUsuario.'.</p> <p>Contraseña: '.$vPassword.'.<p>'.
          '<p>Para confirmar el registro haz click en el siguiente link: </p>'.getenv('URL_SITIO').'?code='.$codigoAleatorio.
          '<p>Link válido por 2 horas.</p>');
          $vTipoMensaje = "success";
          $vMensaje = "Se envío un mail a su correo para confirmar el registro.";
      }
      else{
          $vTipoMensaje = "danger";
          $vMensaje = "Ha ocurrido un error al registrarse.";
      }
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
                      <button type="submit" name="ingresar" title="Boton ingresar" value="Ingresar" class="btn btn-sm btn-success btn-block"> Ingresar </button>
                    </div>
                </div>
              </form>
            </div>
            <div class="card-footer content-center">
              <a name="registrar" title="Boton registrarse" href="#modalRegistro" data-toggle="modal" data-target="#modalRegistro" class="btn btn-sm btn-info btn-block"> Registrarse </a>
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

  <!-- Modal Registro -->
  <div class="modal fade" id="modalRegistro" tabindex="-1" role="dialog" aria-labelledby="labellRegistro"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
      <form action="login.php" method="post">
        <div class="modal-header">
          <div style="align-items: center;display: flex;">
            <h1 class="modal-title" id="labellRecuperacion" style="font-size: 25px;margin-right: 10px;">Registro de usuario</h1>
            <div name="ayudaRegistro" title="Para registrarse su DNI y Correo electrónico deben coincidir con los datos brindados a la Universidad.">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-question-circle" viewBox="0 0 16 16">
                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                    <path d="M5.255 5.786a.237.237 0 0 0 .241.247h.825c.138 0 .248-.113.266-.25.09-.656.54-1.134 1.342-1.134.686 0 1.314.343 1.314 1.168 0 .635-.374.927-.965 1.371-.673.489-1.206 1.06-1.168 1.987l.003.217a.25.25 0 0 0 .25.246h.811a.25.25 0 0 0 .25-.25v-.105c0-.718.273-.927 1.01-1.486.609-.463 1.244-.977 1.244-2.056 0-1.511-1.276-2.241-2.673-2.241-1.267 0-2.655.59-2.75 2.286zm1.557 5.763c0 .533.425.927 1.01.927.609 0 1.028-.394 1.028-.927 0-.552-.42-.94-1.029-.94-.584 0-1.009.388-1.009.94z"/>
                </svg>
            </div>
          </div>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <div class="form-group col-md-6">
              <label for="selectRol">Rol: </label>
              <select name="selectRol" id="selectRol" required>
                <option value="Alumno" selected>Alumno</option>
                <option value="Profesor">Profesor</option>
              </select>
            </div>
            <div class="form-group col-md-6">
              <label for="inputDni">DNI <span class="data-required">*</span></label>
              <input name="inputDni" type="text" class="form-control" id="inputDni" required>
            </div>
            <div class="form-group col-md-6">
              <label for="inputEmail">Correo <span class="data-required">*</span></label>
              <input name="inputEmail" type="text" class="form-control" id="inputEmailRegistro" required>
            </div>
            <div class="form-group col-md-6">
              <label for="inputUser">Nombre de usuario <span class="data-required">*</span></label>
              <input name="inputUser" type="text" class="form-control" id="inputUser" required>
            </div>
            <div class="form-group col-md-6">
              <label for="inputPassword">Contraseña <span class="data-required">*</span></label>
              <input name="inputPassword" type="password" class="form-control" id="inputPassword" required>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
          <button type="submit" name="registrar" class="btn btn-success">Registrar</button>
        </div>
        </form>
      </div>
    </div>
  </div>


</body>