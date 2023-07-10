<div class="wrapper">
        <!-- Sidebar  -->
        <nav id="sidebar">
            <div class="sidebar-header">
                <h3>Consultas UTN</h3>
            </div>
    
            <ul class="list-unstyled components">
                <li>
                    <a href="index.php">Inicio</a>
                </li>
                <li>
                    <a href="#homeSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Consultas</a>
                    <ul class="collapse list-unstyled" id="homeSubmenu">
                        <li>
                            <a href="inscribir.php">Inscripción a consultas</a>
                        </li>
                        <li>
                            <a href="misinscripciones.php">Mis inscripciones</a>
                        </li>
                    </ul>
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
                    <a class="nav-item" href="#modalCalendario" data-toggle="modal" data-target="#modalCalendario">
                        Calendario Academico
                    </a>
                </li>
            </ul>

            <div class="col d-flex justify-content-center">
                <ul class="list-unstyled CTAs align-items-end">
                <li>
                        <form action="login.php" method="post">
                                    <input type="hidden" name="idconsulta" value="logout">
                                    <button type="submit" class="btn btn-light" name="actionType" value="logout" >
                                        Cerrar sesión
                                    </button>
                                </form>
                        </li>
                </ul>
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

                    <?php include("notificaciones.php"); ?>

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
                                <button type="submit" class="dropdown-item" name="actionType" value="logout" >
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
                        ?>
                    </div>
            <?php include("mensaje.php"); ?>
            <div class="content-center">