<?php session_start(); 
//validacion del lado del servidor
function validarDatos($vLegajo,$vNombre,$vMail,&$vMensaje) {
 if(empty($vLegajo)|| empty($vNombre) || empty($vMail))
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
 else if(!filter_var($vMail,FILTER_VALIDATE_EMAIL))
 {
    $vTipoMensaje = "danger";
    $vMensaje = "El email ingresado es invalido";
    return false;
 }
 else if(!is_numeric($vLegajo))
 {
    $vTipoMensaje = "danger";
    $vMensaje = "Solo se deben usar numeros en el legajo";
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

    function buscarEspecialidadAlumno($array, $valor1, $valor2) {
        foreach ($array as $registro) {
            if ($registro['id_especialidad'] == $valor1 && $registro['id_alumno'] == $valor2) {
                return true;
            }
        }
        return false;
    }

    // Se guardan los cambios de alta y modificación
    if (!empty($_POST ['actionType']) && ($_POST ['actionType']=="altaAlumno" || $_POST ['actionType']=="modificarAlumno")) {
        if ($_POST ['actionType']=="altaAlumno") {
            $vProcedure = "insertar_alumno";
            $vCheckBox = "especialidadesAlta";
            $vMensaje = "Se ha creado el alumno";
        }
        else {
            $vProcedure = "modificar_alumno";
            $vCheckBox = "especialidadesModif";
            $vMensaje = "Se ha modificado el alumno";
        }
        
        $vLegajo = trim($_POST["inputLegajo"]);
        $vNombre = trim($_POST["inputNombre"]);
        $vMail= trim($_POST["inputMail"]);
        $vUser= $_POST["selectUser"];
        $vEspecialidades = ';';
        if(!empty($_POST[$vCheckBox])) {
            foreach($_POST[$vCheckBox] as $check) {
                $vEspecialidades .= $check.';';
            }
        }
        if (validarDatos($vLegajo,$vNombre,$vMail,$vMensaje)){
            $link->begin_transaction();
            try {
                // Llamar al procedimiento almacenado
                $result = $link->query("CALL $vProcedure($vLegajo,'$vNombre','$vMail','$vUser','$vEspecialidades');");
            
                // Verificar si ocurrió algún error durante la ejecución
                if (!$result) {
                    throw new Exception($link->error);
                }
            
                // Confirmar la transacción
                $link->commit();
                $vTipoMensaje = "success";
            } catch (Exception $e) {
                // Revertir la transacción en caso de error
                $link->rollback();
                echo "Error durante la ejecución del procedimiento almacenado: " . $e->getMessage();
                $vTipoMensaje = "danger";
                $vMensaje = "Ha ocurrido un error, intente nuevamente";
            }
        }
    }
    // Se guardan los cambios de eliminar
    if (!empty($_POST ['actionType']) && !empty($_POST["inputLegajoAlumno"]) && $_POST ['actionType']=="eliminarAlumno") {
        $vLegajo = $_POST["inputLegajoAlumno"];
        $vSql = "DELETE FROM alumnos a WHERE a.legajo = '$vLegajo'";
        if(mysqli_query($link, $vSql)) {
            $vTipoMensaje = "success";
            $vMensaje = "Se ha eliminado el alumno";
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
					                        WHERE u.id_usuario = p.id_usuario)
                        AND u.rol=1 ;";

    $vUsers = mysqli_query($link, $vSqlUser);
    $users = mysqli_fetch_all($vUsers,MYSQLI_ASSOC);

    $vSqlEspecialidades = "SELECT * FROM especialidades;";

    $vEspecialidades = mysqli_query($link, $vSqlEspecialidades);
    $especialidades = mysqli_fetch_all($vEspecialidades,MYSQLI_ASSOC);

    $vSqlEspecialidades = "SELECT * FROM especialidades;";

    $vEspecialidades = mysqli_query($link, $vSqlEspecialidades);
    $especialidades = mysqli_fetch_all($vEspecialidades,MYSQLI_ASSOC);

    $vSqlEspecialidadesAlumnos = "SELECT * FROM especialidades_alumnos;";

    $vEspecialidadesAlumnos = mysqli_query($link, $vSqlEspecialidadesAlumnos);
    $especialidadesAlumnos = mysqli_fetch_all($vEspecialidadesAlumnos,MYSQLI_ASSOC);

    $vSql = "SELECT a.*, u.nombre_usuario, u.dni
                    FROM alumnos a left join usuarios u 
                    on a.id_usuario = u.id_usuario";

    if (!empty($_POST ['contiene'])) {
        $vSql .= " WHERE a.nombre_apellido LIKE '%$vContiene%' OR a.legajo LIKE '%$vContiene%'";
    }

    $vResultado = mysqli_query($link, $vSql);
    ?>

        <div class="container">
        <h1 class="content-center">Gestión de Alumnos</h1>
        <form class="content-center" action="abmAlumnos.php" method="POST" name="FiltrarConsultas">
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
         <!-- Paginacion -->
         <?php $results_per_page = 5;
        $data = mysqli_fetch_all($vResultado, MYSQLI_ASSOC);
        $total_pages = ceil(count($data) / $results_per_page);

        if (isset($_GET['page']) && is_numeric($_GET['page'])) {
            $current_page = (int) $_GET['page'];
        } 
        else if (isset($_POST['page']) && is_numeric($_POST['page'])) {
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
                    <th><b>Legajo Alumno</b></td>
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
            <tbody>
            <?php
    foreach ($data_page as $fila)
    {?>
            <tr>
                <td><?php echo ($fila['legajo']); ?></td>
                <td><?php echo ($fila['nombre_apellido']); ?></td>
                <td><?php echo ($fila['dni']); ?></td>
                <td><?php echo ($fila['mail']); ?></td>
                <td><?php echo ($fila['nombre_usuario']); ?></td>
                <td>
                    <a title="Editar" class="nav-item" href="#modalModif<?php echo ($fila['legajo']);?>" data-toggle="modal"
                        data-target="#modalModif<?php echo ($fila['legajo']); ?>" style="float:right;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor"
                            class="bi bi-pencil-fill" viewBox="0 0 16 16">
                            <path
                                d="M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708l-3-3zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207l6.5-6.5zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.499.499 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11l.178-.178z" />
                        </svg>
                    </a>
                </td>
                <td>
                    <a title="Eliminar" class="nav-item" href="#modalbaja<?php echo ($fila['legajo']);?>" data-toggle="modal"
                        data-target="#modalbaja<?php echo ($fila['legajo']); ?>" style="float:right;">
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
                                <h5 class="modal-title" id="modalLabel<?php echo ($fila['legajo']); ?>">Alta de Alumno</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form action="abmAlumnos.php" method="post">
                                <div class="form-group col-md-6">
                                        <label for="inputLegajo">Legajo</label>
                                        <input name="inputLegajo" type="text" class="form-control" id="inputLegajo" required/>
                                    </div>
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
                                        <option value="">Sin asignar</option>
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
                                    <div name="checkEspecialidad" id="checkEspecialidad" class="form-check col-md-6">
                                        <label for="checkEspecialidad">Especialidades</label>
                                            <?php 
                                            foreach($especialidades as $especialidad)
                                            {   
                                                ?>
                                                <div>
                                                <label class="form-check-label">
                                                    <input class="form-check-input" type="checkbox" id="especialidadesAlta[]" name="especialidadesAlta[]" value="<?php echo ($especialidad['id_especialidad'])?>">
                                                    <?php echo ($especialidad['descripcion'])?>
                                                </label>
                                                </div>
                                                <?php
                                            }
                                            ?>
                                    </div>
                            </div>
                            <div class="modal-footer">
                                <input name="page" type="hidden" class="form-control"
                                    id="page" value="<?php echo ($current_page); ?>">  
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                <button type="submit" name="actionType" value="altaAlumno" class="btn btn-success">Crear alumno</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>


                <!-- Modal Modificacion -->
                <div class="modal fade" id="modalModif<?php echo ($fila['legajo']); ?>" tabindex="-1" role="dialog"
                    aria-labelledby="exampleMlabel<?php echo ($fila['legajo']); ?>" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="modalLabel<?php echo ($fila['legajo']); ?>">Modificar
                                    Alumno <?php echo ($fila['legajo']); ?></h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form action="abmAlumnos.php" method="post">
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
                                        <option value="">Sin asignar</option>
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
                                    <div name="checkEspecialidad" id="checkEspecialidad" class="form-check col-md-6">
                                        <label for="checkEspecialidad">Especialidades</label>
                                            <?php 
                                            foreach($especialidades as $especialidad)
                                            {   
                                                if (buscarEspecialidadAlumno($especialidadesAlumnos, $especialidad['id_especialidad'], $fila['legajo'])) {
                                                ?>
                                                    <div>
                                                    <label class="form-check-label">
                                                        <input class="form-check-input" type="checkbox" id="especialidadesModif[]" name="especialidadesModif[]" value="<?php echo ($especialidad['id_especialidad'])?>" checked>
                                                        <?php echo ($especialidad['descripcion'])?>
                                                    </label>
                                                    </div>
                                                <?php        
                                                }
                                                else {
                                                ?>
                                                    <div>
                                                    <label class="form-check-label">
                                                        <input class="form-check-input" type="checkbox" id="especialidadesModif[]" name="especialidadesModif[]" value="<?php echo ($especialidad['id_especialidad'])?>" >
                                                        <?php echo ($especialidad['descripcion'])?>
                                                    </label>
                                                    </div>
                                                <?php
                                                }
                                            }
                                            ?>
                                        </fieldset>
                                    </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                <input name="inputLegajo" type="hidden" class="form-control"
                                    id="inputLegajo" value="<?php echo ($fila['legajo']); ?>">
                                <input name="page" type="hidden" class="form-control"
                                    id="page" value="<?php echo ($current_page); ?>">    
                                <button type="submit" name="actionType" value="modificarAlumno"
                                    class="btn btn-primary">Guardar cambios</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal Baja -->
                <div class="modal fade" id="modalbaja<?php echo ($fila['legajo']); ?>" tabindex="-1" role="dialog"
                    aria-labelledby="exampleModalLabel<?php echo ($fila['legajo']); ?>" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="modalLabel<?php echo ($fila['legajo']); ?>">Baja de
                                    Alumno <?php echo ($fila['legajo']); ?></h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <p id="modalLabel<?php echo ($fila['legajo']); ?>">Está a punto de eliminar
                                    el alumno <?php echo ($fila['legajo']); ?></p>
                                <p>¿Esta seguro de querer hacerlo?</p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                <form action="abmAlumnos.php" method="post">
                                    <input name="inputLegajoAlumno" type="hidden" class="form-control"
                                        id="inputLegajoAlumno" value="<?php echo ($fila['legajo']); ?>">
                                    <input name="page" type="hidden" class="form-control"
                                        id="page" value="<?php echo ($current_page); ?>">      
                                    <button type="submit" name="actionType" value="eliminarAlumno"
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
    mysqli_free_result($vUsers);
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
    }?>"><a class="page-link" href="<?php echo('abmAlumnos.php?page='.$page)?>"><?php echo($page)?></a></li>
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