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
    if (!isset($_POST['id_profesor'])) 
    {
        header("location:abmProfesores.php");
    }

    include("conexion.inc");
    $vIdProfesor = $_POST['id_profesor'];

    try {
    $vSqlProfesor = "SELECT * FROM profesores where id_profesor = $vIdProfesor";
    $vProfesor = mysqli_query($link, $vSqlProfesor);
    while ($fila = mysqli_fetch_array($vProfesor))
    {
        $nombreProfesor = $fila['nombre_apellido'];
    }
    if (!isset($nombreProfesor)) 
    {
        header("location:abmProfesores.php");
    }

    // Se guardan los cambios de alta
    if (!empty($_POST ['actionType']) && $_POST ['actionType']=="altaConsulta") {
        $vMateria = $_POST["selectMateria"];
        $vDia = $_POST["selectDia"];
        $vHora = $_POST["inputHora"];
        $vSql = "INSERT INTO profesor_consulta (id_profesor, id_dia_consulta, hora, id_materia)
                Values ($vIdProfesor, $vDia, '$vHora', $vMateria)";
        if(mysqli_query($link, $vSql)) {
            $vTipoMensaje = "success";
            $vMensaje = "Se agregó la consulta";
        }
        else{
            $vTipoMensaje = "danger";
            $vMensaje = "Ha ocurrido un error, intente nuevamente";
        }
    }
    // Se guardan los cambios de eliminar
    if (!empty($_POST ['actionType']) && !empty($_POST["inputIDconsulta"]) && $_POST ['actionType']=="eliminarConsulta") {
        $vIDconsulta= $_POST["inputIDconsulta"];
        $vSql = "DELETE FROM profesor_consulta WHERE id_profesor_consulta = '$vIDconsulta'";
        if(mysqli_query($link, $vSql)) {
            $vTipoMensaje = "success";
            $vMensaje = "Se ha eliminado la consulta";
        }
        else{
            $vTipoMensaje = "danger";
            $vMensaje = "Ha ocurrido un error, intente nuevamente";
        }
    }
    } catch (mysqli_sql_exception $e) {
        $nombreProfesor = '';
        $vTipoMensaje = "danger";
        $vMensaje = "Error al ejecutar la operación en la base de datos.";
    }


    include("headerAdmin.php");

    try {
    $vSqlDias = "SELECT * FROM dias_consulta";
    $vDias = mysqli_query($link, $vSqlDias);
    $dias = mysqli_fetch_all($vDias,MYSQLI_ASSOC);

    $vSqlMaterias = "SELECT m.*, e.descripcion FROM materias m
                     inner join especialidades e on m.id_especialidad = e.id_especialidad
                     inner join materias_profesor mp on m.id_materia = mp.id_materia
                     and mp.id_profesor = $vIdProfesor";
    $vMaterias = mysqli_query($link, $vSqlMaterias);
    $materias = mysqli_fetch_all($vMaterias,MYSQLI_ASSOC);

    $vSql = "SELECT * FROM profesor_consulta pc 
            inner join materias m on m.id_materia = pc.id_materia
            inner join especialidades e on m.id_especialidad = e.id_especialidad
            inner join dias_consulta dc on dc.id_dia_consulta = pc.id_dia_consulta
            where pc.id_profesor = $vIdProfesor";
    $vResultado = mysqli_query($link, $vSql);
    $data_page = mysqli_fetch_all($vResultado,MYSQLI_ASSOC);
    $numrows = mysqli_num_rows($vResultado);
    } catch (mysqli_sql_exception $e) {
        $total_pages = 0;
        $numrows = 0;
        $data_page = [];
        $vTipoMensaje = "danger";
        $vMensaje = "Problemas de conexión a la base de datos.";
    }

    ?>


    <div class="container">
        <h1 class="content-center">Consultas de <?php echo ($nombreProfesor) ?></h1>
    </div>
        <div class="table-responsive">
        <table class="table">
            <thead style="background-color: #077b83; color: #ffff ;">
            <tr>
                    <th><b>Materia</b></th>
                    <th><b>Día</b></th>
                    <th><b>Hora</b></th>
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

    <?php
    
    if ($numrows==0)
    {
        ?>
        <tr>
            <td colspan="4" style="text-align: center;">
                Aún no se registraron consultas para este profesor
            </td>
        </tr>
        <?php
    }
    else
    { 
    foreach ($data_page as $fila)
    {?>
            <tr>
                <td><?php echo ($fila['nombre_materia'].' - '.$fila['descripcion']); ?></td>
                <td><?php echo ($fila['dia']); ?></td>
                <td><?php echo ($fila['hora']); ?></td>
                <td>
                    <a title="Eliminar" class="nav-item" href="#modalbaja<?php echo ($fila['id_profesor_consulta']);?>" data-toggle="modal"
                        data-target="#modalbaja<?php echo ($fila['id_profesor_consulta']); ?>" style="float:right;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor"
                            class="bi bi-trash-fill" viewBox="0 0 16 16">
                            <path
                                d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0z" />
                        </svg>
                    </a>
                </td>
            </tr>
            <?php
    }
    }
    ?>
        </table>
    </div>

    <?php
    foreach ($data_page as $fila)
    {?>
        <!-- Modal Baja -->
        <div class="modal fade" id="modalbaja<?php echo ($fila['id_profesor_consulta']); ?>" tabindex="-1" role="dialog"
            aria-labelledby="modalDeleteLabel<?php echo ($fila['id_profesor_consulta']); ?>" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalDeleteLabel<?php echo ($fila['id_profesor_consulta']); ?>">Baja de
                            Consulta <?php echo ($fila['id_materia']); ?></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Está a punto de eliminar esta consulta</p>
                        <p>¿Esta seguro de querer hacerlo?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <form action="abmConsultas.php" method="post">
                            <input name="inputIDconsulta" type="text" class="form-control" style="display:none"
                                id="inputIDconsulta<?php echo ($fila['id_profesor_consulta']); ?>" value="<?php echo ($fila['id_profesor_consulta']); ?>">
                            <input name="id_profesor" type="text" class="form-control" style="display:none"
                                id="id_profesor<?php echo ($fila['id_profesor_consulta']); ?>" value="<?php echo ($vIdProfesor); ?>">     
                            <button type="submit" name="actionType" value="eliminarConsulta"
                                class="btn btn-danger">Eliminar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    <?php
    }
    if (isset($vResultado)) {
    // Liberar conjunto de resultados
    mysqli_free_result($vResultado);
    mysqli_free_result($vMaterias);
    mysqli_free_result($vDias);
    // Cerrar la conexion
    mysqli_close($link);
    }
    ?>

    <!-- Modal Alta -->
    <div class="modal fade" id="modalAlta" tabindex="-1" role="dialog"
        aria-labelledby="modalLabelAlta" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="abmConsultas.php" method="post">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalLabelAlta">Alta de consulta</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                            <div class="form-group col-12">
                            <label for="selectMateria">Materia <span class="data-required">*</span></label>
                                <select class="select-materias" name="selectMateria" id="selectMateria" required>
                                    <?php 
                            foreach($materias as $materia)
                            {   
                                ?>
                                    <option value=<?php echo ($materia['id_materia'])?>>
                                        <?php echo ($materia['nombre_materia'].' - '.$materia['descripcion'])?></option>
                                    <?php
                            }
                            ?>
                                </select>
                            </div>

                            <div class="form-group col-4">
                            <label for="selectDia">Día <span class="data-required">*</span></label>
                                <select name="selectDia" id="selectDia" required>
                                    <?php 
                            foreach($dias as $dia)
                            {   
                                ?>
                                    <option value=<?php echo ($dia['id_dia_consulta'])?>>
                                        <?php echo ($dia['dia'])?></option>
                                    <?php
                            }
                            ?>
                                </select>
                            </div>

                            <div class="form-group col-4">
                                <label for="inputHora">Hora <span class="data-required">*</span></label>
                                <input name="inputHora" type="time" class="form-control" id="inputHora" required/>
                            </div>
                    </div>
                    <div class="modal-footer">
                        <input name="id_profesor" type="text" class="form-control" style="display:none"
                                        id="id_profesor" value="<?php echo ($vIdProfesor); ?>">    
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <button type="submit" name="actionType" value="altaConsulta" class="btn btn-success">Crear consulta</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

        <p>&nbsp;</p>
        <?php
    include("footer.html");
}
else {
    header("location:login.php");
}?>
</body>