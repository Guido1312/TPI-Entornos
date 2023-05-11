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
    if (!empty($_POST ['actionType']) && $_POST ['actionType']=="altaProfesor") {
        $vNombre = $_POST["inputNombre"];
        $vMail= $_POST["inputMail"];
        $vUser= $_POST["selectUser"];
        $vSql = "INSERT INTO profesores (nombre_apellido, mail, id_usuario)
                Values ('$vNombre', '$vMail', $vUser)";
        if(mysqli_query($link, $vSql)) {
            $vTipoMensaje = "success";
            $vMensaje = "Se ha creado el profesor";
        }
        else{
            $vTipoMensaje = "danger";
            $vMensaje = "Ha ocurrido un error, intente nuevamente";
        }
    }
    // Se guardan los cambios de eliminar
    if (!empty($_POST ['actionType']) && !empty($_POST["inputIDprofesor"]) && $_POST ['actionType']=="eliminarProfesor") {
        $vIDprofesor = $_POST["inputIDprofesor"];
        $vSql = "DELETE FROM profesores p WHERE p.id_profesor = '$vIDprofesor'";
        if(mysqli_query($link, $vSql)) {
            $vTipoMensaje = "success";
            $vMensaje = "Se ha eliminado el profesor";
        }
        else{
            $vTipoMensaje = "danger";
            $vMensaje = "Ha ocurrido un error, intente nuevamente";
        }
    }
    // Se guardan los cambios de modificar
    if (!empty($_POST ['actionType']) && !empty($_POST["inputIDprofesor"]) && $_POST ['actionType']=="modificarProfesor") {
        $vIDprofesor = $_POST["inputIDprofesor"];
        $vNombre = $_POST["inputNombre"];
        $vMail= $_POST["inputMail"];
        $vUser= $_POST["selectUser"];
        $vSql = "UPDATE profesores SET nombre_apellido = '$vNombre', mail = '$vMail', id_usuario = '$vUser'
                WHERE id_profesor = '$vIDprofesor'";
        if(mysqli_query($link, $vSql)) {
            $vTipoMensaje = "success";
            $vMensaje = "Se ha modificado el profesor";
        }
        else{
            $vTipoMensaje = "danger";
            $vMensaje = "Ha ocurrido un error, intente nuevamente";
        }
    }


    include("headerAdmin.php");

    if (!empty($_POST ['contiene'])) {
        $vContiene = $_POST ['contiene'];
    }
    $vSqlUser = "SELECT * FROM usuarios u
                            WHERE NOT EXISTS (SELECT * FROM alumnos a 
                                                WHERE u.id_usuario = a.id_usuario) 
                            AND NOT EXISTS (SELECT * FROM profesores p 
                                                WHERE u.id_usuario = p.id_usuario) ;";
    $vUsers = mysqli_query($link, $vSqlUser);
    $users = mysqli_fetch_all($vUsers,MYSQLI_ASSOC);

    $vSql = "SELECT p.*, u.nombre_usuario, u.dni
                    FROM profesores p left join usuarios u 
                    on p.id_usuario = u.id_usuario";
    
    if (!empty($_POST ['contiene'])) {
        $vSql .= " WHERE p.nombre_apellido LIKE '%$vContiene%' OR p.id_profesor LIKE '%$vContiene%'";
    }
    $vResultado = mysqli_query($link, $vSql);
    ?>

    <div class="container">
    <h1 class="content-center">Gestión de Profesores</h1>
    <form class="content-center" action="abmProfesores.php" method="POST" name="FiltrarConsultas">
            <label for="contiene">Buscar:</label>
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
        </div>
        <div class="table-responsive">
        <table class="table">
            <thead style="background-color: #077b83; color: #ffff ;">
            <tr>
                    <th><b>ID Profesor</b></td>
                    <th><b>Nombre y apellido</b></td>
                    <th><b>DNI</b></td>
                    <th><b>Email</b></td>
                    <th><b>Nombre de usuario</b></td>
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

            <?php
    while ($fila = mysqli_fetch_array($vResultado))
    {?>
            <tr>
                <td><?php echo ($fila['id_profesor']); ?></td>
                <td><?php echo ($fila['nombre_apellido']); ?></td>
                <td><?php echo ($fila['dni']); ?></td>
                <td><?php echo ($fila['mail']); ?></td>
                <td><?php echo ($fila['nombre_usuario']); ?></td>
                <td>
                    <a title="Editar" class="nav-item" href="#modalModif<?php echo ($fila['id_profesor']);?>" data-toggle="modal"
                        data-target="#modalModif<?php echo ($fila['id_profesor']); ?>" style="float:right;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor"
                            class="bi bi-pencil-fill" viewBox="0 0 16 16">
                            <path
                                d="M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708l-3-3zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207l6.5-6.5zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.499.499 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11l.178-.178z" />
                        </svg>
                    </a>
                </td>
                <td>
                    <a title="Eliminar" class="nav-item" href="#modalbaja<?php echo ($fila['id_profesor']);?>" data-toggle="modal"
                        data-target="#modalbaja<?php echo ($fila['id_profesor']); ?>" style="float:right;">
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
                                <h5 class="modal-title" id="modalLabel<?php echo ($fila['id_profesor']); ?>">Alta de Profesor</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form action="abmProfesores.php" method="post">
                                    <div class="form-group col-md-6">
                                        <label for="inputNombre">Nombre y apellido</label>
                                        <input name="inputNombre" type="text" class="form-control" id="inputNombre" required/>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="inputMail">Mail</label>
                                        <input name="inputMail" type="email" class="form-control" id="inputMail" required/>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="selectUser">Usuario</label>
                                        <select name="selectUser" id="selectUser">
                                            <?php 
                                    foreach($users as $user)
                                    {   
                                        if ($fila['nombre_usuario']==$user['nombre_usuario']) {
                                        ?>
                                            <option value=<?php echo ($user['id_usuario'])?> selected>
                                                <?php echo ($user['nombre_usuario'])?></option>
                                            <?php        
                                        }
                                        else {
                                        ?>
                                            <option value=<?php echo ($user['id_usuario'])?>>
                                                <?php echo ($user['nombre_usuario'])?></option>
                                            <?php
                                        }
                                    }
                                    ?>
                                        </select>
                                    </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                <button type="submit" name="actionType" value="altaProfesor" class="btn btn-success">Crear profesor</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>


                <!-- Modal Modificacion -->
                <div class="modal fade" id="modalModif<?php echo ($fila['id_profesor']); ?>" tabindex="-1" role="dialog"
                    aria-labelledby="exampleMlabel<?php echo ($fila['id_profesor']); ?>" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="modalLabel<?php echo ($fila['id_profesor']); ?>">Modificar
                                    Profesor <?php echo ($fila['id_profesor']); ?></h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form action="abmProfesores.php" method="post">
                                    <div class="form-group col-md-6">
                                        <label for="inputNombre">Nombre y apellido</label>
                                        <input name="inputNombre" type="text" class="form-control" id="inputNombre"
                                            value="<?php echo ($fila['nombre_apellido'])?> " required/>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="inputMail">Mail</label>
                                        <input name="inputMail" type="email" class="form-control" id="inputMail"
                                            value="<?php echo ($fila['mail'])?> " required/>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="selectUser">Usuario</label>
                                        <select name="selectUser" id="selectUser">
                                            <?php 
                                    foreach($users as $user)
                                    {   
                                        if ($fila['nombre_usuario']==$user['nombre_usuario']) {
                                        ?>
                                            <option value=<?php echo ($user['id_usuario'])?> selected>
                                                <?php echo ($user['nombre_usuario'])?></option>
                                            <?php        
                                        }
                                        else {
                                        ?>
                                            <option value=<?php echo ($user['id_usuario'])?>>
                                                <?php echo ($user['nombre_usuario'])?></option>
                                            <?php
                                        }
                                    }
                                    ?>
                                        </select>
                                    </div>

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                <input name="inputIDprofesor" type="text" class="form-control" style="display:none"
                                    id="inputIDprofesor" value="<?php echo ($fila['id_profesor']); ?>">
                                <button type="submit" name="actionType" value="modificarProfesor"
                                    class="btn btn-primary">Guardar cambios</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal Baja -->
                <div class="modal fade" id="modalbaja<?php echo ($fila['id_profesor']); ?>" tabindex="-1" role="dialog"
                    aria-labelledby="exampleModalLabel<?php echo ($fila['id_profesor']); ?>" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="modalLabel<?php echo ($fila['id_profesor']); ?>">Baja de
                                    Profesor <?php echo ($fila['id_profesor']); ?></h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <p id="modalLabel<?php echo ($fila['id_profesor']); ?>">Está a punto de eliminar
                                    el profesor <?php echo ($fila['id_profesor']); ?></p>
                                <p>¿Esta seguro de querer hacerlo?</p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                <form action="abmProfesores.php" method="post">
                                    <input name="inputIDprofesor" type="text" class="form-control" style="display:none"
                                        id="inputIDprofesor" value="<?php echo ($fila['id_profesor']); ?>">
                                    <button type="submit" name="actionType" value="eliminarProfesor"
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
    mysqli_free_result($vUsers);
    // Cerrar la conexion
    mysqli_close($link);
    ?>
        </table>
    </div>
        <p>&nbsp;</p>
        <?php
    include("footer.html");
}
else {
    header("location:index.php");
}
?>
</body>