<?php session_start(); 
//validacion del lado del servidor
function validarDatos($vNombre,$vMail,&$vMensaje) {
    if(empty($vNombre) || empty($vMail))
    {
     $vTipoMensaje = "danger";
     $vMensaje = "No se han rellenado todos los campos";
     return false;
    }
    else if(!preg_match('/^[a-zA-ZáéíóúüñÁÉÍÓÚÜÑ\s]+$/', $vNombre))
    {
     $vTipoMensaje = "danger";
     $vMensaje = "Solo se deben usar letras en el nombre";
     return false;
    }
    else if(!filter_var($vMail,FILTER_VALIDATE_EMAIL))
    {
       $vTipoMensaje = "danger";
       $vMensaje = "El email ingresado es invalido";
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
    try {

    // Se guardan los cambios de alta
    if (!empty($_POST ['actionType']) && $_POST ['actionType']=="altaProfesor") {
        $vNombre = trim($_POST["inputNombre"]);
        $vMail= trim($_POST["inputMail"]);
        $vUser= $_POST["selectUser"];
        if (validarDatos($vNombre,$vMail,$vMensaje)){
            if(empty($vUser)){
                $vSql = "INSERT INTO profesores (nombre_apellido, mail)
                    Values ('$vNombre', '$vMail')";
                if(mysqli_query($link, $vSql)) {
                    $vTipoMensaje = "success";
                    $vMensaje = "Se ha creado el profesor";
                }
                else{
                    $vTipoMensaje = "danger";
                    $vMensaje = "Ha ocurrido un error, intente nuevamente";
                }
            }
            else{
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
        $vIDprofesor = trim($_POST["inputIDprofesor"]);
        $vNombre = trim($_POST["inputNombre"]);
        $vMail= trim($_POST["inputMail"]);
        $vUser= $_POST["selectUser"];
        if (validarDatos($vNombre,$vMail,$vMensaje)){
            if(empty($vUser)){
                $vSql = "UPDATE profesores SET nombre_apellido = '$vNombre', mail = '$vMail', id_usuario = null
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
            else{
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
        }
    }   
    } catch (mysqli_sql_exception $e) {
        $vTipoMensaje = "danger";
        $vMensaje = "Error al ejecutar la operación en la base de datos. Tenga en cuenta que no se puede borrar un profesor con materias/consultas asignadas.";
    }

    include("headerAdmin.php");

    try {
    if (!empty($_POST ['contiene'])) {
        $vContiene = $_POST ['contiene'];
    }
    $vSqlUser = "SELECT * FROM usuarios u
                            WHERE NOT EXISTS (SELECT * FROM alumnos a 
                                                WHERE u.id_usuario = a.id_usuario) 
                            AND NOT EXISTS (SELECT * FROM profesores p 
                                                WHERE u.id_usuario = p.id_usuario) 
                            AND u.rol=2;";
    $vUsers = mysqli_query($link, $vSqlUser);
    $users = mysqli_fetch_all($vUsers,MYSQLI_ASSOC);

    $vSqlUserAsignados = "SELECT * FROM usuarios u, profesores p
	                    WHERE u.id_usuario = p.id_usuario;";

    $vUsersAsignados = mysqli_query($link, $vSqlUserAsignados);
    $usersAsignados = mysqli_fetch_all($vUsersAsignados,MYSQLI_ASSOC);

    $vSql = "SELECT p.*, u.nombre_usuario, u.dni
                    FROM profesores p left join usuarios u 
                    on p.id_usuario = u.id_usuario";
    
    if (!empty($_POST ['contiene'])) {
        $vSql .= " WHERE p.nombre_apellido LIKE '%$vContiene%' OR p.id_profesor LIKE '%$vContiene%'";
    }
    $vResultado = mysqli_query($link, $vSql);
    $results_per_page = 5;
    $data = mysqli_fetch_all($vResultado, MYSQLI_ASSOC);
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

    } catch (mysqli_sql_exception $e) {
        $total_pages = 0;
        $numrows = 0;
        $data_page = [];
        $vTipoMensaje = "danger";
        $vMensaje = "Problemas de conexión a la base de datos.";
    }
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
            <button type="submit" name="actionType" value="filtrar" class="btn btn-primary btn-sm">Filtrar</button>
            <div name="ayudaFiltro" title="Filtre por id o nombre del profesor">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-question-circle" viewBox="0 0 16 16">
                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                    <path d="M5.255 5.786a.237.237 0 0 0 .241.247h.825c.138 0 .248-.113.266-.25.09-.656.54-1.134 1.342-1.134.686 0 1.314.343 1.314 1.168 0 .635-.374.927-.965 1.371-.673.489-1.206 1.06-1.168 1.987l.003.217a.25.25 0 0 0 .25.246h.811a.25.25 0 0 0 .25-.25v-.105c0-.718.273-.927 1.01-1.486.609-.463 1.244-.977 1.244-2.056 0-1.511-1.276-2.241-2.673-2.241-1.267 0-2.655.59-2.75 2.286zm1.557 5.763c0 .533.425.927 1.01.927.609 0 1.028-.394 1.028-.927 0-.552-.42-.94-1.029-.94-.584 0-1.009.388-1.009.94z"/>
                </svg>
            </div>
        </form>
        
        </div>
        <div class="table-responsive">
        <table class="table">
            <thead style="background-color: #077b83; color: #ffff ;">
            <tr>
                    <th><b>ID Profesor</b></th>
                    <th><b>Nombre y apellido</b></th>
                    <th><b>DNI</b></th>
                    <th><b>Email</b></th>
                    <th><b>Nombre de usuario</b></th>
                    <th><b></b></th>
                    <th><b></b></th>
                    <th><b></b></th>
                    <th>
                        <a title="Agregar" class="nav-item" href="#modalAlta" data-toggle="modal" data-target="#modalAlta" style="float:right;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="27" height="27" fill="currentColor" class="bi bi-person-plus-fill" viewBox="0 0 16 16">
                                <path d="M1 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
                                <path fill-rule="evenodd" d="M13.5 5a.5.5 0 0 1 .5.5V7h1.5a.5.5 0 0 1 0 1H14v1.5a.5.5 0 0 1-1 0V8h-1.5a.5.5 0 0 1 0-1H13V5.5a.5.5 0 0 1 .5-.5z"/>
                            </svg>
                        </a>
                    </th>
                </tr>
            </thead>
            <tbody>
            <?php
    foreach ($data_page as $fila)
    {?>
            <tr>
                <td><?php echo ($fila['id_profesor']); ?></td>
                <td><?php echo ($fila['nombre_apellido']); ?></td>
                <td><?php echo ($fila['dni']); ?></td>
                <td><?php echo ($fila['mail']); ?></td>
                <td><?php echo ($fila['nombre_usuario']); ?></td>
                <td>
                    <form action="abmConsultas.php" method="post">
                        <input type="hidden" name="id_profesor" value="<?php echo ($fila['id_profesor']) ?>">
                        <button type="submit" class="btn btn-info"> Ver consultas </button>
                    </form>
                </td>
                <td>
                    <form action="abmMateriasProfesor.php" method="post">
                        <input type="hidden" name="id_profesor" value="<?php echo ($fila['id_profesor']) ?>">
                        <button type="submit" class="btn btn-info"> Ver materias </button>
                    </form>
                </td>
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
            </tr>
            
            <?php
        }?>
        </tbody>
    
        <?php
        if (isset($vResultado)) {
            // Liberar conjunto de resultados
            mysqli_free_result($vResultado);
            mysqli_free_result($vUsers);
            // Cerrar la conexion
            mysqli_close($link);
        }
    ?>
        </table>

        <!-- Modal Alta -->
        <div class="modal fade" id="modalAlta" tabindex="-1" role="dialog"
            aria-labelledby="modalAltaLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form action="abmProfesores.php" method="post">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalAltaLabel">Alta de Profesor</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                                <div class="form-group col-md-6">
                                    <label for="inputNombre">Nombre y apellido<span class="data-required">*</span></label>
                                    <input name="inputNombre" type="text" class="form-control" id="inputNombre" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="inputMail">Mail<span class="data-required">*</span></label>
                                    <input name="inputMail" type="email" class="form-control" id="inputMail" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="selectUser">Usuario</label>
                                    <select name="selectUser" id="selectUser">
                                    <option value="">Sin asignar</option>
                                        <?php 
                                foreach($users as $user)
                                {   
                                    ?>
                                        <option value=<?php echo ($user['id_usuario'])?>>
                                            <?php echo ($user['nombre_usuario'])?></option>
                                        <?php
                                }
                                ?>
                                    </select>
                                </div>
                        </div>
                        <div class="modal-footer">
                            <input name="page" type="hidden" class="form-control"
                                id="page" value="<?php echo ($current_page); ?>">  
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                            <button type="submit" name="actionType" value="altaProfesor" class="btn btn-success">Crear profesor</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <?php
        foreach ($data_page as $fila)
        {?>
        <!-- Modal Modificacion -->
        <div class="modal fade" id="modalModif<?php echo ($fila['id_profesor']); ?>" tabindex="-1" role="dialog"
            aria-labelledby="modalModifLabel<?php echo ($fila['id_profesor']); ?>" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form action="abmProfesores.php" method="post">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalModifLabel<?php echo ($fila['id_profesor']); ?>">Modificar
                                Profesor: <?php echo ($fila['nombre_apellido']); ?></h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                                <div class="form-group col-md-6">
                                    <label for="inputNombre">Nombre y apellido<span class="data-required">*</span></label>
                                    <input name="inputNombre" type="text" class="form-control" id="inputNombre<?php echo ($fila['id_profesor']); ?>"
                                        value="<?php echo ($fila['nombre_apellido'])?>" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="inputMail">Mail<span class="data-required">*</span></label>
                                    <input name="inputMail" type="email" class="form-control" id="inputMail<?php echo ($fila['id_profesor']); ?>"
                                        value="<?php echo ($fila['mail'])?>" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="selectUser">Usuario</label>
                                    <select name="selectUser" id="selectUser<?php echo ($fila['id_profesor']); ?>">
                                    <option value="">Sin asignar</option>
                                    <?php
                                        foreach($users as $user)
                                        {   
                                            ?>
                                            <option value=<?php echo ($user['id_usuario'])?>>
                                                <?php echo ($user['nombre_usuario'])?></option>
                                            <?php
                                        }
                                        foreach($usersAsignados as $userAsignado) 
                                        {
                                            if ($fila['id_profesor']==$userAsignado['id_profesor']) {
                                        ?>
                                            <option value=<?php echo ($userAsignado['id_usuario'])?> selected>
                                                <?php echo ($userAsignado['nombre_usuario'])?></option>
                                            <?php
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                            <input name="inputIDprofesor" type="hidden" class="form-control"
                                id="inputModifIDprofesor<?php echo ($fila['id_profesor']); ?>" value="<?php echo ($fila['id_profesor']); ?>">
                            <input name="page" type="hidden" class="form-control"
                                id="pageModif<?php echo ($fila['id_profesor']); ?>" value="<?php echo ($current_page); ?>">      
                            <button type="submit" name="actionType" value="modificarProfesor"
                                class="btn btn-primary">Guardar cambios</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Modal Baja -->
        <div class="modal fade" id="modalbaja<?php echo ($fila['id_profesor']); ?>" tabindex="-1" role="dialog"
            aria-labelledby="modalDeleteLabel<?php echo ($fila['id_profesor']); ?>" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalDeleteLabel<?php echo ($fila['id_profesor']); ?>">Baja de
                            Profesor <?php echo ($fila['id_profesor']); ?></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Está a punto de eliminar el profesor: <?php echo ($fila['nombre_apellido']); ?></p>
                        <p>¿Esta seguro de querer hacerlo?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <form action="abmProfesores.php" method="post">
                            <input name="inputIDprofesor" type="hidden" class="form-control"
                                id="inputDeleteIDprofesor<?php echo ($fila['id_profesor']); ?>" value="<?php echo ($fila['id_profesor']); ?>">
                            <input name="page" type="hidden" class="form-control"
                                id="pageDelete<?php echo ($fila['id_profesor']); ?>" value="<?php echo ($current_page); ?>">  
                            <button type="submit" name="actionType" value="eliminarProfesor"
                                class="btn btn-danger">Eliminar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <?php
        }
        ?>

        </div>
        <ul class="pagination">
        <?php
for ($page = 1; $page <= $total_pages; $page++) {?>
    <li class="page-item
    <?php
    if ($page == $current_page) {
        echo 'active';
    }?>"><a class="page-link" href="<?php echo('abmProfesores.php?page='.$page)?>"><?php echo($page)?></a></li>
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