
    <div class="wrapper">
        <!-- Sidebar  -->
        <nav id="sidebar">
            <div class="sidebar-header">
                <h3>Consultas UTN</h3>
            </div>
    
            <ul class="list-unstyled components">
                <li>
                    <a href="#">Inicio</a>
                </li>
                <li class="active">
                    <a href="#homeSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Consultas</a>
                    <ul class="collapse list-unstyled" id="homeSubmenu">
                        <li>
                            <a href="#">Inscripción a consultas</a>
                        </li>
                        <li>
                            <a href="#">Mis inscripciones</a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="#pageSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Perfil</a>
                    <ul class="collapse list-unstyled" id="pageSubmenu">
                        <li>
                            <a href="#">Preferencias</a>
                        </li>
                        <li>
                            <a href="#">Editar perfil</a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a class="nav-item" href="#modalCalendario" data-toggle="modal" data-target="#modalCalendario" style="float:right;">
                        Calendario Academico
                    </a>
                </li>
            </ul>

            <ul class="list-unstyled CTAs align-items-end">
                <li>
                    <form action="login.php" method="post">
                    <button type="submit" name="actionType" value="logout">
                            Cerrar sesión
                        </button>
                    </form>
                </li>
            </ul>
        </nav>
        <div id="content">
    
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <div class="container-fluid">
    
                    <button type="button" id="sidebarCollapse" class="btn btn-info">
                        <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-list" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M2.5 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5z"/>
                        </svg>
                    </button>
                    <button class="btn btn-dark d-inline-block d-lg-none ml-auto" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <i class="fas fa-align-justify"></i>
                    </button> <!-- este es el boton negro que aparece cuando lo ponemos modo celu  -->
                    
                    <div class="content-center" style="max-width: fit-content;">
                        <a href="index.php">
                            <img src="https://caimasegall.com.ar/wp-content/uploads/2020/08/logo-UTN-1.png" alt="" style="max-inline-size: 15%;">
                        </a>
                    </div>

                    <a class="nav-item" href="#">
                        <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-bell-fill" viewBox="0 0 16 16">
                            <path d="M8 16a2 2 0 0 0 2-2H6a2 2 0 0 0 2 2zm.995-14.901a1 1 0 1 0-1.99 0A5.002 5.002 0 0 0 3 6c0 1.098-.5 6-2 7h14c-1.5-1-2-5.902-2-7 0-2.42-1.72-4.44-4.005-4.901z"/>
                        </svg>
                    </a>
                    <div class="nav-item dropdown">
                        <a class="nav-item nav-link w-100 dropdown-toggle mr-md-2" href="#" id="bd-versions" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-person-circle" viewBox="0 0 16 16">
                                <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z"/>
                                <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1z"/>
                            </svg>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="bd-versions">
                          <a class="dropdown-item" href="https://v4-alpha.getbootstrap.com/">Perfil</a>
                          <a class="dropdown-item" href="https://getbootstrap.com/docs/3.3/">Preferencias</a>
                          <form action="login.php" method="post">
                            <button type="submit" name="actionType" value="logout">
                                Cerrar sesión
                            </button>
                          </form>
                        </div>
                    </div>

                </div>
            </nav>

            <!-- Modal Calendario -->
            <div class="modal fade" id="modalCalendario" tabindex="-1" role="dialog"
                    aria-labelledby="exampleAlabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="modalLabel<?php echo ($fila['id_profesor']); ?>">Calendario Academico</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <img src="images/Calendario2022.jpg" style="width: 100%; height: 100%"> 
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

            <div class="container-fluid">
            <?php include("mensaje.php"); ?>
            <div class="content-center">