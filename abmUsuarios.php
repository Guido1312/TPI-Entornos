<?php session_start(); 
//validacion del lado del servidor
function validarDatos($vDNI,$vNombre,&$vMensaje) {
    if(empty($vDNI)|| empty($vNombre))
    {
     $vTipoMensaje = "danger";
     $vMensaje = "No se han rellenado todos los campos";
     return false;
    }
    else if(!preg_match('/^[a-zA-Z]+$/', $vNombre))
    {
     $vTipoMensaje = "danger";
     $vMensaje = "Solo se deben usar letras en el nombre de usuario";
     return false;
    }
    else if(!is_numeric($vDNI))
    {
       $vTipoMensaje = "danger";
       $vMensaje = "Solo se deben usar numeros en el DNI";
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

<head>
    <?php
        include("head.html");
    ?>
</head>

<body>
    <?php
    $vMensaje;
if (isset($_SESSION['usuario']) & $_SESSION['rol']!=3){
    header("location:index.php");
}
elseif (isset($_SESSION['usuario']) & $_SESSION['rol']==3){
    include("conexion.inc");

    // Se guardan los cambios de alta
    if (!empty($_POST ['actionType']) && $_POST ['actionType']=="altaUsuario") {
        $vDNI = trim($_POST["inputDni"]);
        $vNombre = trim($_POST["inputNombre"]);
        $vPassword= trim($_POST["inputPassword"]);
        $vRol= $_POST["selectRole"];
        if (validarDatos($vDNI,$vNombre,$vMensaje)){
            $vSql = "INSERT INTO usuarios (rol, dni, nombre_usuario, password)
                    Values ($vRol, $vDNI, '$vNombre', '$vPassword')";
            if(mysqli_query($link, $vSql)) {
                $vTipoMensaje = "success";
                $vMensaje = "Se ha creado el usuario";
            }
            else{
                $vTipoMensaje = "danger";
                $vMensaje = "Ha ocurrido un error, intente nuevamente";
            }
        }
    }
    // Se guardan los cambios de eliminar
    if (!empty($_POST ['actionType']) && !empty($_POST["inputIDusuario"]) && $_POST ['actionType']=="eliminarUsuario") {
        $vIDusuario = $_POST["inputIDusuario"];
        $vSql = "DELETE FROM usuarios u WHERE u.id_usuario = '$vIDusuario'";
        if(mysqli_query($link, $vSql)) {
            $vTipoMensaje = "success";
            $vMensaje = "Se ha eliminado el usuario";
        }
        else{
            $vTipoMensaje = "danger";
            $vMensaje = "Ha ocurrido un error, intente nuevamente";
        }
    }
    // Se guardan los cambios de modificar
    if (!empty($_POST ['actionType']) && !empty($_POST["inputIDusuario"]) && $_POST ['actionType']=="modificarUsuario") {
        $vIDusuario = trim($_POST["inputIDusuario"]);
        $vDNI = trim($_POST["inputDni"]);
        $vNombre = trim($_POST["inputNombre"]);
        $vPassword= trim($_POST["inputPassword"]);
        $vRol= $_POST["selectRole"];
        if (validarDatos($vDNI,$vNombre,$vMensaje)){
            $vSql = "UPDATE usuarios SET dni = '$vDNI', nombre_usuario = '$vNombre', password = '$vPassword', rol = '$vRol'
                    WHERE id_usuario = '$vIDusuario'";
            if(mysqli_query($link, $vSql)) {
                $vTipoMensaje = "success";
                $vMensaje = "Se ha modificado el usuario";
            }
            else{
                $vTipoMensaje = "danger";
                $vMensaje = "Ha ocurrido un error, intente nuevamente";
            }
        }
    }


    include("headerAdmin.php");

    if (!empty($_POST ['contiene'])) {
        $vContiene = $_POST ['contiene'];
    }
    $vSqlRol = "SELECT * FROM roles_usuario";
    $vRoles = mysqli_query($link, $vSqlRol);
    $roles = mysqli_fetch_all($vRoles,MYSQLI_ASSOC);

    $vSql = "SELECT u.*, ifnull(a.legajo, p.id_profesor) id_externo, ifnull(a.nombre_apellido, p.nombre_apellido) nombre_externo, r.nombre_rol
                                        FROM usuarios u inner join roles_usuario r on r.id_rol_usuario = u.rol
                                        left join alumnos a on u.id_usuario = a.id_usuario
                                        left join profesores p on u.id_usuario = p.id_usuario";
    if (!empty($_POST ['contiene'])) {
        $vSql .= " WHERE u.nombre_usuario LIKE '%$vContiene%'";
    }
    $vResultado = mysqli_query($link, $vSql);
    ?>

    <div class="container">
    <h1 class="content-center">Gestión de usuarios</h1>
    <form class="content-center" action="abmUsuarios.php" method="POST" name="FiltrarConsultas">
            <label for="contiene">Buscar por nombre de usuario:</label>
            <?php
            if (empty($_POST ['contiene'])) {
            ?>
                <input type="text" id="contiene" name="contiene">
            <?php
            }
            else {
            ?>
                <input type="text" id="contiene" name="contiene" value=<?php echo ($_POST ['contiene'])?>>
            <?php
            }
            ?>
            </select>
            <button type="submit" name="actionType" value="filtrar" class="btn btn-primary btn-sm">Filtrar</button>
        </form>
        <!-- Paginacion -->
        <?php $results_per_page = 5;
        $data = mysqli_fetch_all($vResultado, MYSQLI_ASSOC);
        $total_pages = ceil(count($data) / $results_per_page);

        if (isset($_GET['page']) && is_numeric($_GET['page'])) {
            $current_page = (int) $_GET['page'];
        } else {
            $current_page = 1;
        }
        
        $offset = ($current_page - 1) * $results_per_page;
        
        $data_page = array_slice($data, $offset, $results_per_page);
        
        ?>
        

        </div>
        <div class="table-responsive">
        <table class="table">
            <thead style="background-color: #077b83; color: #ffff ;">
            <tr>
                    <th><b>Rol</b></td>
                    <th><b>Dni</b></td>
                    <th><b>Usuario</b></td>
                    <th><b>Password</b></td>
                    <th><b>Legajo</b></td>
                    <th><b>Nombre y apellido</b></td>
                    <th><b></b></td>
                    <th><b></b></td>
                        <a title="Agregar" class="nav-item" href="#modalAlta" data-toggle="modal" data-target="#modalAlta" style="float:right;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="27" height="27" fill="currentColor" class="bi bi-person-plus-fill" viewBox="0 0 16 16">
                                <path d="M1 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
                                <path fill-rule="evenodd" d="M13.5 5a.5.5 0 0 1 .5.5V7h1.5a.5.5 0 0 1 0 1H14v1.5a.5.5 0 0 1-1 0V8h-1.5a.5.5 0 0 1 0-1H13V5.5a.5.5 0 0 1 .5-.5z"/>
                            </svg>
                        </a>
                </tr>
            </thead>
        <tbody>
            <?php
    foreach ($data_page as $fila)
    {?>
            <tr>
                <td><?php echo ($fila['nombre_rol']); ?></td>
                <td><?php echo ($fila['dni']); ?></td>
                <td><?php echo ($fila['nombre_usuario']); ?></td>
                <td><?php echo ($fila['password']); ?></td>
                <td><?php echo ($fila['id_externo']); ?></td>
                <td><?php echo ($fila['nombre_externo']); ?></td>
                <td>
                    <a title="Editar" class="nav-item" href="#modalModif<?php echo ($fila['id_usuario']);?>" data-toggle="modal"
                        data-target="#modalModif<?php echo ($fila['id_usuario']); ?>" style="float:right;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor"
                            class="bi bi-pencil-fill" viewBox="0 0 16 16">
                            <path
                                d="M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708l-3-3zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207l6.5-6.5zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.499.499 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11l.178-.178z" />
                        </svg>
                    </a>
                </td>
                <td>
                    <a title="Eliminar" class="nav-item" href="#modalbaja<?php echo ($fila['id_usuario']);?>" data-toggle="modal"
                        data-target="#modalbaja<?php echo ($fila['id_usuario']); ?>" style="float:right;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor"
                            class="bi bi-trash-fill" viewBox="0 0 16 16">
                            <path
                                d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0z" />
                        </svg>
                    </a>
                </td>


                <!-- Modal Alta -->
                <div class="modal fade" id="modalAlta" tabindex="-1" role="dialog"
                    aria-labelledby="exampleAlabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="modalLabel<?php echo ($fila['id_usuario']); ?>">Alta de usuario</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form action="abmUsuarios.php" method="post">
                                    <div class="form-group col-md-6">
                                        <label for="inputDni">DNI</label>
                                        <input name="inputDni" type="text" class="form-control" id="inputDni" required/>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="inputNombre">Nombre de Usuario</label>
                                        <input name="inputNombre" type="text" class="form-control" id="inputNombre" required/>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="inputPassword">Contraseña</label>
                                        <input name="inputPassword" type="text" class="form-control" id="inputPassword" required/>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="selectRole">Rol</label>
                                        <select name="selectRole" id="selectRole">
                                            <?php 
                                    foreach($roles as $rol)
                                    {   
                                        if ($fila['nombre_rol']==$rol['nombre_rol']) {
                                        ?>
                                            <option value=<?php echo ($rol['id_rol_usuario'])?> selected>
                                                <?php echo ($rol['nombre_rol'])?></option>
                                            <?php        
                                        }
                                        else {
                                        ?>
                                            <option value=<?php echo ($rol['id_rol_usuario'])?>>
                                                <?php echo ($rol['nombre_rol'])?></option>
                                            <?php
                                        }
                                    }
                                    ?>
                                        </select>
                                    </div>
                            </div>
                            <div class="modal-footer">
                                <input name="page" type="hidden" class="form-control"
                                    id="page" value="<?php echo ($current_page); ?>">  
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                <button type="submit" name="actionType" value="altaUsuario" class="btn btn-success">Crear usuario</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>


                <!-- Modal Modificacion -->
                <div class="modal fade" id="modalModif<?php echo ($fila['id_usuario']); ?>" tabindex="-1" role="dialog"
                    aria-labelledby="exampleMlabel<?php echo ($fila['id_usuario']); ?>" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="modalLabel<?php echo ($fila['id_usuario']); ?>">Modificar
                                    Usuario <?php echo ($fila['id_usuario']); ?></h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form action="abmUsuarios.php" method="post">
                                    <div class="form-group col-md-6">
                                        <label for="inputDni">DNI</label>
                                        <input name="inputDni" type="text" class="form-control" id="inputDni"
                                            value="<?php echo ($fila['dni'])?> " required/>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="inputNombre">Nombre de Usuario</label>
                                        <input name="inputNombre" type="text" class="form-control" id="inputNombre"
                                            value="<?php echo ($fila['nombre_usuario'])?> " required/>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="inputPassword">Contraseña</label>
                                        <input name="inputPassword" type="text" class="form-control" id="inputPassword"
                                            value="<?php echo ($fila['password'])?> " required/>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="selectRole">Rol</label>
                                        <select name="selectRole" id="selectRole">
                                            <?php 
                                    foreach($roles as $rol)
                                    {   
                                        if ($fila['nombre_rol']==$rol['nombre_rol']) {
                                        ?>
                                            <option value=<?php echo ($rol['id_rol_usuario'])?> selected>
                                                <?php echo ($rol['nombre_rol'])?></option>
                                            <?php        
                                        }
                                        else {
                                        ?>
                                            <option value=<?php echo ($rol['id_rol_usuario'])?>>
                                                <?php echo ($rol['nombre_rol'])?></option>
                                            <?php
                                        }
                                    }
                                    ?>
                                        </select>
                                    </div>

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                <input name="inputIDusuario" type="hidden" class="form-control"
                                    id="inputIDusuario" value="<?php echo ($fila['id_usuario']); ?>">
                                <input name="page" type="hidden" class="form-control"
                                    id="page" value="<?php echo ($current_page); ?>">  
                                <button type="submit" name="actionType" value="modificarUsuario"
                                    class="btn btn-primary">Guardar cambios</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal Baja -->
                <div class="modal fade" id="modalbaja<?php echo ($fila['id_usuario']); ?>" tabindex="-1" role="dialog"
                    aria-labelledby="exampleModalLabel<?php echo ($fila['id_usuario']); ?>" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="modalLabel<?php echo ($fila['id_usuario']); ?>">Baja de
                                    Usuario <?php echo ($fila['id_usuario']); ?></h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <p id="modalLabel<?php echo ($fila['id_usuario']); ?>">Está a punto de eliminar
                                    el usuario <?php echo ($fila['id_usuario']); ?></p>
                                <p>¿Esta seguro de querer hacerlo?</p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                <form action="abmUsuarios.php" method="post">
                                    <input name="inputIDusuario" type="hidden" class="form-control"
                                        id="inputIDusuario" value="<?php echo ($fila['id_usuario']); ?>">
                                    <input name="page" type="hidden" class="form-control"
                                        id="page" value="<?php echo ($current_page); ?>">  
                                    <button type="submit" name="actionType" value="eliminarUsuario"
                                        class="btn btn-danger">Eliminar</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                
            </tr>
            
            <?php
        }?>
        </tbody>
    
        <?php
    // Liberar conjunto de resultados
    mysqli_free_result($vResultado);
    mysqli_free_result($vRoles);
    // Cerrar la conexion
    mysqli_close($link);
    ?>
        </table>
        </div>
        <ul class="pagination">
        <?php
for ($page = 1; $page <= $total_pages; $page++) {?>
    <li class="page-item
    <?php
    if ($page == $current_page) {
        echo 'active';
    }?>"><a class="page-link" href="<?php echo('abmUsuarios.php?page='.$page)?>"><?php echo($page)?></a></li>
<?php }
?>
</ul>
        
        <p>&nbsp;</p>
        <?php
    include("footer.html");
}
else {
    header("location:index.php");
}

?>
</body>