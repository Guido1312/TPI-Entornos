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
    if (!empty($_POST ['actionType']) && $_POST ['actionType']=="altaMateria") {
        $vNombre = $_POST["inputNombre"];
        $vEspecialidad= $_POST["selectEspecialidad"];
        $vSql = "INSERT INTO materias (nombre_materia, id_especialidad)
                Values ('$vNombre', $vEspecialidad)";
        if(mysqli_query($link, $vSql)) {
            $vTipoMensaje = "success";
            $vMensaje = "Se ha creado la materia";
        }
        else{
            $vTipoMensaje = "danger";
            $vMensaje = "Ha ocurrido un error, intente nuevamente";
        }
    }
    // Se guardan los cambios de eliminar
    if (!empty($_POST ['actionType']) && !empty($_POST["inputIDmateria"]) && $_POST ['actionType']=="eliminarMateria") {
        $vIDmateria= $_POST["inputIDmateria"];
        $vSql = "DELETE FROM materias m WHERE m.id_materia = '$vIDmateria'";
        if(mysqli_query($link, $vSql)) {
            $vTipoMensaje = "success";
            $vMensaje = "Se ha eliminado la materia";
        }
        else{
            $vTipoMensaje = "danger";
            $vMensaje = "Ha ocurrido un error, intente nuevamente";
        }
    }
    // Se guardan los cambios de modificar
    if (!empty($_POST ['actionType']) && !empty($_POST["inputIDmateria"]) && $_POST ['actionType']=="modificarMateria") {
        $vIDmateria = $_POST["inputIDmateria"];
        $vNombre = $_POST["inputNombre"];
        $vEspecialidad= $_POST["selectEspecialidad"];
        $vSql = "UPDATE materias SET nombre_materia = '$vNombre', id_especialidad = '$vEspecialidad'
                WHERE id_materia = '$vIDmateria'";
        if(mysqli_query($link, $vSql)) {
            $vTipoMensaje = "success";
            $vMensaje = "Se ha modificado la materia";
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
    $vSqlEspecialidad = "SELECT * FROM especialidades";
    $vEspecialidades = mysqli_query($link, $vSqlEspecialidad);
    $especialidades = mysqli_fetch_all($vEspecialidades,MYSQLI_ASSOC);

    $vSql = "SELECT m.*, e.descripcion FROM materias m 
            inner join especialidades e on m.id_especialidad = e.id_especialidad";
    if (!empty($_POST ['contiene'])) {
        $vSql .= " WHERE m.nombre_materia LIKE '%$vContiene%'";
    }
    $vResultado = mysqli_query($link, $vSql);

    ?>


    <div class="container">
    <h1 class="content-center">Gestión de Materias</h1>
    <form class="content-center" action="abmMaterias.php" method="POST" name="FiltrarConsultas">
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
        </form>
         <!-- Paginacion -->
         <?php $results_per_page = 10;
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
        
        ?>
        
        </div>
        <div class="table-responsive">
        <table class="table">
            <thead style="background-color: #077b83; color: #ffff ;">
            <tr>
                    <th><b>Nombre materia</b></th>
                    <th><b>Especialidad</b></th>
                    <th><b></b></th>
                    <th>
                        <a title="Agregar" class="nav-item" href="#modalAlta" data-toggle="modal" data-target="#modalAlta" style="float:right;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="27" height="27" fill="currentColor" class="bi bi-folder-plus" viewBox="0 0 16 16">
                            <path d="m.5 3 .04.87a1.99 1.99 0 0 0-.342 1.311l.637 7A2 2 0 0 0 2.826 14H9v-1H2.826a1 1 0 0 1-.995-.91l-.637-7A1 1 0 0 1 2.19 4h11.62a1 1 0 0 1 .996 1.09L14.54 8h1.005l.256-2.819A2 2 0 0 0 13.81 3H9.828a2 2 0 0 1-1.414-.586l-.828-.828A2 2 0 0 0 6.172 1H2.5a2 2 0 0 0-2 2zm5.672-1a1 1 0 0 1 .707.293L7.586 3H2.19c-.24 0-.47.042-.683.12L1.5 2.98a1 1 0 0 1 1-.98h3.672z"/>
                            <path d="M13.5 10a.5.5 0 0 1 .5.5V12h1.5a.5.5 0 1 1 0 1H14v1.5a.5.5 0 1 1-1 0V13h-1.5a.5.5 0 0 1 0-1H13v-1.5a.5.5 0 0 1 .5-.5z"/>
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
                <td><?php echo ($fila['nombre_materia']); ?></td>
                <td><?php echo ($fila['descripcion']); ?></td>
                <td>
                    <a title="Editar" class="nav-item" href="#modalModif<?php echo ($fila['id_materia']);?>" data-toggle="modal"
                        data-target="#modalModif<?php echo ($fila['id_materia']); ?>" style="float:right;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor"
                            class="bi bi-pencil-fill" viewBox="0 0 16 16">
                            <path
                                d="M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708l-3-3zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207l6.5-6.5zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.499.499 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11l.178-.178z" />
                        </svg>
                    </a>
                </td>
                <td>
                    <a title="Eliminar" class="nav-item" href="#modalbaja<?php echo ($fila['id_materia']);?>" data-toggle="modal"
                        data-target="#modalbaja<?php echo ($fila['id_materia']); ?>" style="float:right;">
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
    // Liberar conjunto de resultados
    mysqli_free_result($vResultado);
    mysqli_free_result($vEspecialidades);
    // Cerrar la conexion
    mysqli_close($link);
    ?>
        </table>

        <!-- Modal Alta -->
        <div class="modal fade" id="modalAlta" tabindex="-1" role="dialog"
            aria-labelledby="modalAltaLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form action="abmMaterias.php" method="post">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalAltaLabel">Alta de materia</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                                <div class="form-group col-md-6">
                                    <label for="inputNombre">Nombre de Materia</label>
                                    <input name="inputNombre" type="text" class="form-control" id="inputNombre" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="selectEspecialidad">Especialidad correspondiente</label>
                                    <select name="selectEspecialidad" id="selectEspecialidad">
                                        <?php 
                                        foreach($especialidades as $especialidad)
                                        {   
                                            if ($fila['descripcion']==$especialidad['descripcion']) {
                                            ?>
                                                <option value=<?php echo ($especialidad['id_especialidad'])?> selected>
                                                    <?php echo ($especialidad['descripcion'])?></option>
                                                <?php        
                                            }
                                            else {
                                            ?>
                                                <option value=<?php echo ($especialidad['id_especialidad'])?>>
                                                    <?php echo ($especialidad['descripcion'])?></option>
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
                            <button type="submit" name="actionType" value="altaMateria" class="btn btn-success">Crear materia</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <?php
        foreach ($data_page as $fila)
        {?>

        <!-- Modal Modificacion -->
        <div class="modal fade" id="modalModif<?php echo ($fila['id_materia']); ?>" tabindex="-1" role="dialog"
            aria-labelledby="modalModifLabel<?php echo ($fila['id_materia']); ?>" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form action="abmMaterias.php" method="post">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalModifLabel<?php echo ($fila['id_materia']); ?>">Modificar
                                Materia <?php echo ($fila['id_materia']); ?></h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                                <div class="form-group col-md-6">
                                    <label for="inputNombre">Nombre de Materia</label>
                                    <input name="inputNombre" type="text" class="form-control" id="inputNombre<?php echo ($fila['id_materia']); ?>"
                                        value="<?php echo ($fila['nombre_materia'])?> " required>
                                </div>
                                <div class="form-group col-md-6">
                                <label for="selectEspecialidad">Especialidad correspondiente</label>
                                    <select name="selectEspecialidad" id="selectEspecialidad<?php echo ($fila['id_materia']); ?>">
                                        <?php 
                                        foreach($especialidades as $especialidad)
                                        {   
                                            if ($fila['descripcion']==$especialidad['descripcion']) {
                                            ?>
                                                <option value=<?php echo ($especialidad['id_especialidad'])?> selected>
                                                    <?php echo ($especialidad['descripcion'])?></option>
                                                <?php        
                                            }
                                            else {
                                            ?>
                                                <option value=<?php echo ($especialidad['id_especialidad'])?>>
                                                    <?php echo ($especialidad['descripcion'])?></option>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                            <input name="inputIDmateria" type="hidden" class="form-control"
                                id="inputModifIDmateria<?php echo ($fila['id_materia']); ?>" value="<?php echo ($fila['id_materia']); ?>">
                            <input name="page" type="hidden" class="form-control"
                                id="pageModif<?php echo ($fila['id_materia']); ?>" value="<?php echo ($current_page); ?>">      
                            <button type="submit" name="actionType" value="modificarMateria"
                                class="btn btn-primary">Guardar cambios</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Modal Baja -->
        <div class="modal fade" id="modalbaja<?php echo ($fila['id_materia']); ?>" tabindex="-1" role="dialog"
            aria-labelledby="modalDeleteLabel<?php echo ($fila['id_materia']); ?>" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalDeleteLabel<?php echo ($fila['id_materia']); ?>">Baja de
                            Materia <?php echo ($fila['id_materia']); ?></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Está a punto de eliminar la materia <?php echo ($fila['nombre_materia']); ?></p>
                        <p>¿Esta seguro de querer hacerlo?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <form action="abmMaterias.php" method="post">
                            <input name="inputIDmateria" type="hidden" class="form-control"
                                id="inputIDmateria<?php echo ($fila['id_materia']); ?>" value="<?php echo ($fila['id_materia']); ?>">
                            <input name="page" type="hidden" class="form-control"
                                id="page<?php echo ($fila['id_materia']); ?>" value="<?php echo ($current_page); ?>">      
                            <button type="submit" name="actionType" value="eliminarMateria"
                                class="btn btn-danger">Eliminar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <?php
        }?>

        </div>
        <ul class="pagination">
        <?php
for ($page = 1; $page <= $total_pages; $page++) {?>
    <li class="page-item
    <?php
    if ($page == $current_page) {
        echo 'active';
    }?>"><a class="page-link" href="<?php echo('abmMaterias.php?page='.$page)?>"><?php echo($page)?></a></li>
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