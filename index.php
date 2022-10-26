<!DOCTYPE html>
<html lang="es">
<?php session_start(); ?>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-
    ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-
    q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-
    UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-
    JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <title>TPI</title>
    <link rel="stylesheet" type="text/css" href="styles.css" />
</head>
<body>
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
                            <a href="misinscripciones.php">Mis inscripciones</a>
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
                    <a href="#">Calendario académico</a>
                </li>
            </ul>

            <ul class="list-unstyled CTAs align-items-end">
                <li>
                    <a href="https://bootstrapious.com/tutorial/files/sidebar.zip" class="download">Cerrar sesión</a>
                </li>
            </ul>
        </nav>
    
        <!-- Page Content  -->
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
                    </button>
                    
                    <div class="content-center" style="max-width: fit-content;">
                        <img src="https://caimasegall.com.ar/wp-content/uploads/2020/08/logo-UTN-1.png" alt="" style="max-inline-size: 15%;">
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
                            <button type="submit" name="actionType" value="logout" class="download">
                                Cerrar sesión
                            </button>
                        </form>
                        </div>
                    </div>

                </div>
            </nav>

            <div class="container content-center">
                <div class="row">
                    <h2>Bienvenido <?php echo $_SESSION['usuario']; ?></h2>
                </div>

                <div class="row card-deck">
                    <div class="card">
                        <img src="images/iconList.png" class="card-img-top" alt="Habitat: sabana">
                        <div class="card-body content-center">
                          <h5 class="card-title">Inscribirse de consultas</h5> 
                          <a href="inscribir.php" class="stretched-link"></a>
                        </div>
                    </div>
                    <div class="card" href="https://es.wikipedia.org/wiki/Sabana" >
                        <img src="images/iconMyInscriptions.png" class="card-img-top" alt="Habitat: sabana">
                        <div class="card-body content-center">
                          <h5 class="card-title">Mis inscripciones</h5> 
                          <a href="misinscripciones.php" class="stretched-link"></a>
                        </div>
                    </div>
                    <div class="card">
                        <img src="images/iconCalendar.png" class="card-img-top" alt="Habitat: sabana">
                        <div class="card-body content-center">
                          <h5 class="card-title">Calendario académico</h5> 
                          <a href="https://es.wikipedia.org/wiki/Desierto" class="stretched-link"></a>
                        </div>
                    </div>
                </div>
            </div>
    
        </div>
    </div>

    <footer class="bg-light text-center text-lg-start">
        <!-- Copyright -->
        <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.2);">
          © 2020 Copyright:
          <a class="text-dark" href="https://mdbootstrap.com/">lcano.com</a>
        </div>
        <!-- Copyright -->
    </footer>

    <script>
        $(document).ready(function () {
            $('#sidebarCollapse').on('click', function () {
                $('#sidebar').toggleClass('active');
            });
        });
    </script>
</body>