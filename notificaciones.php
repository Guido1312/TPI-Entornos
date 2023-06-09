<div class="nav-item dropdown">
    <a class="nav-item nav-link w-100 dropdown-toggle mr-md-2" href="#" title="Notificaciones" id="bd-versions" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-bell-fill" viewBox="0 0 16 16">
            <path d="M8 16a2 2 0 0 0 2-2H6a2 2 0 0 0 2 2zm.995-14.901a1 1 0 1 0-1.99 0A5.002 5.002 0 0 0 3 6c0 1.098-.5 6-2 7h14c-1.5-1-2-5.902-2-7 0-2.42-1.72-4.44-4.005-4.901z"/>
            <?php
            $vUserNotif = $_SESSION['usuario'];
            if (!empty($_POST ['actionType']) && ($_POST ['actionType']=="leer") && !empty($_POST ['idnotificacion'])) {
                $vIdNotificacion = $_POST ['idnotificacion'];
                $vSql = "UPDATE notificaciones SET leida = 1
                    WHERE id_notificacion = $vIdNotificacion
                    and id_usuario = $vUserNotif";
                if(!mysqli_query($link, $vSql)) {
                    $vTipoMensaje = "danger";
                    $vMensaje = "Ha ocurrido un error al marcar la notificacion, intente nuevamente";
                }
            }
            
            $vSql = "SELECT * from notificaciones n
                        where n.id_usuario = '$vUserNotif'
                        and leida = 0
                        order by id_notificacion desc";
            $vResultado = mysqli_query($link, $vSql);
            if (mysqli_num_rows($vResultado) > 0) {
            ?>
                <circle cx="13" cy="4" r="3" fill="red" />
            <?php
            }
            ?>
        </svg>
    </a>
    <div class="dropdown-menu dropdown-notif" aria-labelledby="bd-versions">
        <?php
        if (mysqli_num_rows($vResultado) == 0) {
            ?>
            <div class="dropdown-item" style="align-items: center;"> 
                <p>No hay notificaciones</p> 
            </div>
            <?php
        }
        else {
            while ($fila = mysqli_fetch_array($vResultado))
            {
            ?> 
            <form action="<?php echo ( $_SERVER['REQUEST_URI']) ?>" method="post">     
            <div class="dropdown-item" style="align-items: center;"> 
                <div class="row">
                    <div class="col-10">
                        <h6><?php echo ($fila['titulo']) ?></h6>
                    </div>
                    <div class="col-2 eye-icon">
                        <button type="submit" class="nav-item" title="Marcar como leida" name="actionType" value="leer" style="background-color: transparent; border: none;">
                            <input type="hidden" name="idnotificacion" value="<?php echo ($fila['id_notificacion']) ?>">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye-fill" viewBox="0 0 16 16">
                                <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0z"/>
                                <path d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8zm8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7z"/>
                            </svg>
                        </button>
                    </div>
                </div>
                <div class="row" style="white-space: normal; overflow-wrap: normal;">
                    <div class="col-12">
                        <p><?php echo ($fila['texto']) ?></p>
                    </div>
                </div>
            </div>          
                </form>                             
            <?php
            }
        }
        ?>
    </div>
</div>