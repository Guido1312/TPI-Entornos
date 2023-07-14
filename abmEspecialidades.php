<?php session_start(); 
//validacion del lado del servidor
function validarDatos($vNombre,&$vMensaje) {
    if(empty($vNombre))
    {
     $vTipoMensaje = "danger";
     $vMensaje = "No se han rellenado todos los campos";
     return false;
    }
    else if(!preg_match('/^[a-zA-Z\s]+$/', $vNombre))
    {
     $vTipoMensaje = "danger";
     $vMensaje = "Solo se deben usar letras en el nombre";
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
    if (!empty($_POST ['actionType']) && $_POST ['actionType']=="altaEspecialidad") {
        $vNombre = trim($_POST["inputNombre"]);
        if (validarDatos($vNombre,$vMensaje)){
            $vSql = "INSERT INTO especialidades (descripcion)
                    Values ('$vNombre')";
            if(mysqli_query($link, $vSql)) {
                $vTipoMensaje = "success";
                $vMensaje = "Se ha creado la especialidad";
            }
            else{
                $vTipoMensaje = "danger";
                $vMensaje = "Ha ocurrido un error, intente nuevamente";
            }
        }
    }
    // Se guardan los cambios de eliminar
    if (!empty($_POST ['actionType']) && !empty($_POST["inputIDespecialidad"]) && $_POST ['actionType']=="eliminarEspecialidad") {
        $vIDespecialidad= $_POST["inputIDespecialidad"];
        $vSql = "DELETE FROM especialidades e WHERE e.id_especialidad = '$vIDespecialidad'";
        if(mysqli_query($link, $vSql)) {
            $vTipoMensaje = "success";
            $vMensaje = "Se ha eliminado la especialidad";
        }
        else{
            $vTipoMensaje = "danger";
            $vMensaje = "Ha ocurrido un error, intente nuevamente";
        }
    }
    // Se guardan los cambios de modificar
    if (!empty($_POST ['actionType']) && !empty($_POST["inputIDespecialidad"]) && $_POST ['actionType']=="modificarEspecialidad") {
        $vIDespecialidad = $_POST["inputIDespecialidad"];
        $vNombre = trim($_POST["inputNombre"]);
        if (validarDatos($vNombre,$vMensaje)){
            $vSql = "UPDATE especialidades SET descripcion = '$vNombre'
                    WHERE id_especialidad = '$vIDespecialidad'";
            if(mysqli_query($link, $vSql)) {
                $vTipoMensaje = "success";
                $vMensaje = "Se ha modificado la especialidad";
            }
            else{
                $vTipoMensaje = "danger";
                $vMensaje = "Ha ocurrido un error, intente nuevamente";
            }
        }
    }




    include("headerAdmin.php");
    

    $vSql = "SELECT * FROM especialidades";
    $vResultado = mysqli_query($link, $vSql);

    ?>


    <h1>Gestión de especialidades</h1>

     <!-- Paginacion -->
     <?php $results_per_page = 3;
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
        
        <div class="table-responsive">
        <table class="table">
            <thead style="background-color: #077b83; color: #ffff ;">
                <tr>
                    <th><b>ID de especialidad</b></th>
                    <th><b>Nombre</b></th>
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
                <td><?php echo ($fila['id_especialidad']); ?></td>
                <td><?php echo ($fila['descripcion']); ?></td>
                <td>
                    <a title="Editar" class="nav-item" href="#modalModif<?php echo ($fila['id_especialidad']);?>" data-toggle="modal"
                        data-target="#modalModif<?php echo ($fila['id_especialidad']); ?>" style="float:right;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor"
                            class="bi bi-pencil-fill" viewBox="0 0 16 16">
                            <path
                                d="M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708l-3-3zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207l6.5-6.5zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.499.499 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11l.178-.178z" />
                        </svg>
                    </a>
                </td>
                <td>
                    <a title="Eliminar" class="nav-item" href="#modalbaja<?php echo ($fila['id_especialidad']);?>" data-toggle="modal"
                        data-target="#modalbaja<?php echo ($fila['id_especialidad']); ?>" style="float:right;">
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
    // Cerrar la conexion
    mysqli_close($link);
    ?>
        </table>

        <!-- Modal Alta -->
        <div class="modal fade" id="modalAlta" tabindex="-1" role="dialog"
            aria-labelledby="modalAltaLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form action="abmEspecialidades.php" method="post">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalAltaLabel">Alta de especialidad</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group col-md-6">
                                <label for="inputNombre">Nombre de Especialidad <span class="data-required">*</span></label>
                                <input name="inputNombre" type="text" class="form-control" id="inputNombre" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <input name="page" type="hidden" class="form-control"
                                id="page" value="<?php echo ($current_page); ?>">  
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                            <button type="submit" name="actionType" value="altaEspecialidad" class="btn btn-success">Crear especialidad</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <?php
        foreach ($data_page as $fila)
        {?>

        <!-- Modal Modificacion -->
        <div class="modal fade" id="modalModif<?php echo ($fila['id_especialidad']); ?>" tabindex="-1" role="dialog"
            aria-labelledby="modalModifLabel<?php echo ($fila['id_especialidad']); ?>" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form action="abmEspecialidades.php" method="post">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalModifLabel<?php echo ($fila['id_especialidad']); ?>">Modificar
                                Especialidad <?php echo ($fila['id_especialidad']); ?></h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group col-md-6">
                                <label for="inputNombre">Nombre de Especialidad <span class="data-required">*</span></label>
                                <input name="inputNombre" type="text" class="form-control" id="inputModifNombre<?php echo ($fila['id_especialidad']); ?>"
                                    value="<?php echo ($fila['descripcion'])?> " required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                            <input name="inputIDespecialidad" type="hidden" class="form-control"
                                id="inputIDModifespecialidad<?php echo ($fila['id_especialidad']); ?>" value="<?php echo ($fila['id_especialidad']); ?>">
                            <input name="page" type="hidden" class="form-control"
                                id="pageModif<?php echo ($fila['id_especialidad']); ?>" value="<?php echo ($current_page); ?>">      
                            <button type="submit" name="actionType" value="modificarEspecialidad"
                                class="btn btn-primary">Guardar cambios</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Modal Baja -->
        <div class="modal fade" id="modalbaja<?php echo ($fila['id_especialidad']); ?>" tabindex="-1" role="dialog"
            aria-labelledby="modalDeleteLabel<?php echo ($fila['id_especialidad']); ?>" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalDeleteLabel<?php echo ($fila['id_especialidad']); ?>">Baja de
                            Especialidad <?php echo ($fila['id_especialidad']); ?></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p id="modalLabel<?php echo ($fila['id_especialidad']); ?>">Está a punto de eliminar
                            esta especialidad <?php echo ($fila['id_especialidad']); ?></p>
                        <p>¿Esta seguro de querer hacerlo?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <form action="abmEspecialidades.php" method="post">
                            <input name="inputIDespecialidad" type="hidden" class="form-control"
                                id="inputIDespecialidad<?php echo ($fila['id_especialidad']); ?>" value="<?php echo ($fila['id_especialidad']); ?>">
                            <input name="page" type="hidden" class="form-control"
                                id="page<?php echo ($fila['id_especialidad']); ?>" value="<?php echo ($current_page); ?>">      
                            <button type="submit" name="actionType" value="eliminarEspecialidad"
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
    }?>"><a class="page-link" href="<?php echo('abmEspecialidades.php?page='.$page)?>"><?php echo($page)?></a></li>
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