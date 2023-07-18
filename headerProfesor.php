<div class="wrapper">
            <!-- Sidebar  -->
            <nav id="sidebar">
                <div class="sidebar-header">
                    <h3>Consultas UTN</h3>
                </div>
        
                <ul class="list-unstyled components">
                    <li class="active">
                        <a href="index.php">Inicio</a>
                    </li>
                    <li>
                            <li>
                                <a href="consultasProfesor.php">Administrar consultas</a>
                            </li>
                    </li>
                    <li>
                        <a href="#pageSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Perfil</a>
                        <ul class="collapse list-unstyled" id="pageSubmenu">
                            <li>
                                <a href="proximamente.html">Preferencias</a>
                            </li>
                            <li>
                                <a href="perfil.php">Perfil</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a class="nav-item" href="#modalCalendario" data-toggle="modal" data-target="#modalCalendario" >
                            Calendario Academico
                        </a>
                    </li>
                </ul>

                <div class="col d-flex justify-content-center">
                <ul class="list-unstyled CTAs align-items-end">
                    <li>
                    <form action="login.php" method="post">
                                <input type="hidden" name="idconsulta" value="logout">
                                <button type="submit" class="btn btn-light" name="actionType" value="logout">
                                    Cerrar sesión
                                </button>
                            </form>
                    </li>
                </ul>
                </div>

                <div class="col d-flex justify-content-center ayuda" >
                    <a href="ayuda.php">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-question-circle" viewBox="0 0 16 16">
                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                        <path d="M5.255 5.786a.237.237 0 0 0 .241.247h.825c.138 0 .248-.113.266-.25.09-.656.54-1.134 1.342-1.134.686 0 1.314.343 1.314 1.168 0 .635-.374.927-.965 1.371-.673.489-1.206 1.06-1.168 1.987l.003.217a.25.25 0 0 0 .25.246h.811a.25.25 0 0 0 .25-.25v-.105c0-.718.273-.927 1.01-1.486.609-.463 1.244-.977 1.244-2.056 0-1.511-1.276-2.241-2.673-2.241-1.267 0-2.655.59-2.75 2.286zm1.557 5.763c0 .533.425.927 1.01.927.609 0 1.028-.394 1.028-.927 0-.552-.42-.94-1.029-.94-.584 0-1.009.388-1.009.94z"/>
                        </svg>
                        Ayuda
                    </a>
                </div>
            </nav>
        
            <!-- Page Content  -->
            <div id="content">
        
                <nav class="navbar navbar-expand-lg navbar-light bg-light">
                    <div class="container-fluid">
        
                        <button type="button" title="Cerrar o abrir barra laterar"  id="sidebarCollapse" class="btn btn-info">
                            <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-list" viewBox="0 0 16 16">
                                <path fill-rule="evenodd" d="M2.5 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5z"/>
                            </svg>
                        </button>
                        
                        <div class="container" style="max-width: fit-content;">
                            <a class="content-center" href="index.php" title="Ir al incio">
                                <img src="images/iconLogoUTN.png" alt="" style="max-inline-size: 15%;">
                            </a>
                        </div>

                        <?php
                        try {
                        include("notificaciones.php"); 
                        } catch (mysqli_sql_exception $e) {
                            $vTipoMensaje = "danger";
                            $vMensaje = "Problemas de conexión a la base de datos";
                        }
                        ?>

                        <div class="nav-item dropdown">
                            <a class="nav-item nav-link w-100 dropdown-toggle mr-md-2" href="#" title="Perfil" id="bd-versions" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-person-circle" viewBox="0 0 16 16">
                                    <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z"/>
                                    <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1z"/>
                                </svg>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="bd-versions">
                            <a class="dropdown-item" href="perfil.php">Perfil</a>
                            <a class="dropdown-item" href="proximamente.html">Preferencias</a>
                            <form action="login.php" method="post">
                                <input type="hidden" name="idconsulta" value="logout">
                                <button type="submit" class="dropdown-item" name="actionType" value="logout">
                                    Cerrar sesión
                                </button>
                            </form>
                            </div>
                        </div>

                    </div>
                </nav>

            <!-- Modal Calendario -->
            <div class="modal fade" id="modalCalendario" tabindex="-1" role="dialog"
                aria-labelledby="modalLabelCalendario" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalLabelCalendario">Calendario Academico</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <img src="images/Calendario2022.jpg" style="width: 100%; height: 100%" alt='Calendario Académico'> 
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="container-fluid">
                    <div>
                    <?php
                        try {
                        $vRol = $_SESSION['rol'];

                        $vUrlActual = $_SERVER['REQUEST_URI'];
                        $vSql = "SELECT *, 0 orden from mapa_sitio m
                                    where m.id_rol_usuario = '$vRol'
                                    and instr('$vUrlActual',m.path)!=0
                                    union
                                SELECT ma.*,msp.orden from mapa_sitio m, mapa_sitio_previos msp, mapa_sitio ma
                                where m.id_rol_usuario = '$vRol'
                                and instr('$vUrlActual',m.path)!=0
                                and m.idmapa_sitio=msp.idmapa_sitio
                                and msp.idmapa_sitio_anterior=ma.idmapa_sitio
                                order by orden desc";
                        $vResultado = mysqli_query($link, $vSql);
                        while ($fila = mysqli_fetch_array($vResultado))
                        {
                            if ($fila['orden'] == 0){
                                ?> 
                                <a href="#" ><?php echo (' > '.$fila['descripcion']) ?> </a>
                                <?php
                            }
                            else {
                                ?> 
                                <a href="<?php echo ($fila['path']) ?>" ><?php echo (' > '.$fila['descripcion']) ?> </a>
                                <?php
                            }
                        }
                        } catch (mysqli_sql_exception $e) {
                            $vTipoMensaje = "danger";
                            $vMensaje = "Problemas de conexión a la base de datos";
                        }
                        ?>
                    </div>
            <?php include("mensaje.php"); ?>
            <div class="content-center">