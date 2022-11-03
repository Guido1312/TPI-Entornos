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
if (isset($_SESSION['usuario']) & $_SESSION['rol']!=3){
    header("location:index.php");
}
elseif (isset($_SESSION['usuario']) & $_SESSION['rol']==3){
    include("conexion.inc");

    // Se guardan los cambios de alta
    if (!empty($_POST ['actionType']) && $_POST ['actionType']=="altaUsuario") {
        $vDNI = $_POST["inputDni"];
        $vNombre = $_POST["inputNombre"];
        $vPassword= $_POST["inputPassword"];
        $vRol= $_POST["selectRole"];
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
        $vIDusuario = $_POST["inputIDusuario"];
        $vDNI = $_POST["inputDni"];
        $vNombre = $_POST["inputNombre"];
        $vPassword= $_POST["inputPassword"];
        $vRol= $_POST["selectRole"];
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


    include("headerAlumno.php");

    $vSqlRol = "SELECT * FROM roles_usuario";
    $vRoles = mysqli_query($link, $vSqlRol);
    $roles = mysqli_fetch_all($vRoles,MYSQLI_ASSOC);

    $vSql = "SELECT u.*, ifnull(a.legajo, p.id_profesor) id_externo, ifnull(a.nombre_apellido, p.nombre_apellido) nombre_externo, r.nombre_rol
                                        FROM usuarios u inner join roles_usuario r on r.id_rol_usuario = u.rol
                                        left join alumnos a on u.id_usuario = a.id_usuario
                                        left join profesores p on u.id_usuario = p.id_usuario";
    $vResultado = mysqli_query($link, $vSql);
    ?>

    <h1>Gestión de usuarios</h1>
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
                        <a class="nav-item" href="#modalAlta" data-toggle="modal" data-target="#modalAlta" style="float:right;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="27" height="27" fill="currentColor" class="bi bi-person-plus-fill" viewBox="0 0 16 16">
                                <path d="M1 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
                                <path fill-rule="evenodd" d="M13.5 5a.5.5 0 0 1 .5.5V7h1.5a.5.5 0 0 1 0 1H14v1.5a.5.5 0 0 1-1 0V8h-1.5a.5.5 0 0 1 0-1H13V5.5a.5.5 0 0 1 .5-.5z"/>
                            </svg>
                        </a>
                </tr>
            </thead>

            <?php
    while ($fila = mysqli_fetch_array($vResultado))
    {?>
            <tr>
                <td><?php echo ($fila['nombre_rol']); ?></td>
                <td><?php echo ($fila['dni']); ?></td>
                <td><?php echo ($fila['nombre_usuario']); ?></td>
                <td><?php echo ($fila['password']); ?></td>
                <td><?php echo ($fila['id_externo']); ?></td>
                <td><?php echo ($fila['nombre_externo']); ?></td>
                <td>
                    <a class="nav-item" href="#modalModif<?php echo ($fila['id_usuario']);?>" data-toggle="modal"
                        data-target="#modalModif<?php echo ($fila['id_usuario']); ?>" style="float:right;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor"
                            class="bi bi-pencil-fill" viewBox="0 0 16 16">
                            <path
                                d="M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708l-3-3zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207l6.5-6.5zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.499.499 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11l.178-.178z" />
                        </svg>
                    </a>
                </td>
                <td>
                    <a class="nav-item" href="#modalbaja<?php echo ($fila['id_usuario']);?>" data-toggle="modal"
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
                                <input name="inputIDusuario" type="text" class="form-control" style="display:none"
                                    id="inputIDusuario" value="<?php echo ($fila['id_usuario']); ?>">
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
                                    <input name="inputIDusuario" type="text" class="form-control" style="display:none"
                                        id="inputIDusuario" value="<?php echo ($fila['id_usuario']); ?>">
                                    <button type="submit" name="actionType" value="eliminarUsuario"
                                        class="btn btn-danger">Eliminar</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </tr>
            <?php
    }
    // Liberar conjunto de resultados
    mysqli_free_result($vResultado);
    mysqli_free_result($vRoles);
    // Cerrar la conexion
    mysqli_close($link);
    ?>
        </table>

        <p>&nbsp;</p>
        <?php
    include("footer.html");
}
else {
    header("location:login.php");
}

?>
</body>