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
                        <a href="#homeSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Edicion de datos</a>
                        <ul class="collapse list-unstyled" id="homeSubmenu">
                            <li>
                                <a href="abmAlumnos.php">Alumnos</a>
                            </li>
                            <li>
                                <a href="abmProfesores.php">Profesores</a>
                            </li>
                            <li>
                                <a href="abmUsuarios.php">Usuarios</a>
                            </li>
                            <li>
                                <a href="abmEspecialidades.php">Especialidades</a>
                            </li>
                            <li>
                                <a href="abmMaterias.php">Materias</a>
                            </li>
                            <li>
                                <a href="#">Dias de consulta</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                    <a class="nav-item" href="listadocentesdia.php" >
                            Planilla: docentes-consulta
                        </a>
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
                                <img src="https://caimasegall.com.ar/wp-content/uploads/2020/08/logo-UTN-1.png" alt="" style="max-inline-size: 15%;">
                            </a>
                        </div>

                        <div class="nav-item dropdown">
                            <a class="nav-item nav-link w-100 dropdown-toggle mr-md-2" href="#" title="Perfil" id="bd-versions" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-person-circle" viewBox="0 0 16 16">
                                    <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z"/>
                                    <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1z"/>
                                </svg>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="bd-versions">
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