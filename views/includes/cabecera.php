<?php

if (session_status() === PHP_SESSION_ACTIVE) {
    //echo "La sesión está activa.";
    $usuario            = $_SESSION['usuario'];
    $id_usuario         = $_SESSION['user_id'];
    $rol                = $_SESSION['rol_usuario'];

    if (empty($usuario) && empty($id_usuario)) {
        // Redireccionar a la página "nueva_pagina.php"
        header("Location: http://localhost/visitantes/index.php?page=inicioUsuario");
        exit; // Asegúrate de terminar la ejecución del código después de la redirección
    }
} else {
    //echo "La sesión no está activa.";
    session_start();
    $usuario            = $_SESSION['usuario'];
    $id_usuario         = $_SESSION['user_id'];
    $rol           = $_SESSION['rol_usuario'];

    if (empty($usuario) && empty($id_usuario)) {
        // Redireccionar a la página "nueva_pagina.php"
        header("Location: http://localhost/visitantes/index.php?page=inicioUsuario");
        exit; // Asegúrate de terminar la ejecución del código después de la redirección
    }
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Visitantes</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="libs/vendor/fontawesome/css/all.css">
    <link rel="stylesheet" href="libs/css/sb-admin-2.min.css">
    <link rel="stylesheet" href="libs/css/estilos.css">
    <link href="libs/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link rel="stylesheet" href="libs/css/sweetalert2.min.css">
    <link rel="shortcut icon" href="libs/img/favicon.ico" type="image/x-icon">
    <script src="libs/js/sweetalert2.all.min.js"></script>
</head>

<body>


    <!-- Loader -->
    <div class="cont-loader" id="cont-loader">
        <div class="custom-loader"></div>
    </div>

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?= SERVERURL ?>index.php?page=inicio">
                <div class="sidebar-brand-icon ">

                    <img src="libs/img/cultura3.png" alt="" style="width: 114%;
                    margin-top: 46px;">

                </div>
                <div class="sidebar-brand-text mx-3"> <sup></sup></div>
            </a>



            <?php

            if ($rol == 3) {
            ?>
                <!-- Nav Item - Dashboard -->
                <li class="nav-item active">
                    <a class="nav-link" href="<?= SERVERURL ?>index.php?page=inicio">
                        <i class="fas fa-fw fa-tachometer-alt"></i>
                        <span>Panel</span></a>
                </li>
                <!-- Divider -->
                <hr class="sidebar-divider">
                <!-- Heading -->
                <div class="sidebar-heading">Modulo</div>
                <!-- Visitantes -->
                <li class="nav-item">
                    <a class="nav-link" href="<?= SERVERURL ?>index.php?page=inicioVisitantes">
                        <i class="fas fa-users"></i>
                        <span>Visitantes</span></a>
                </li>
            <?php
            } else {
            ?>
                <!-- Nav Item - Dashboard -->
                <li class="nav-item active">
                    <a class="nav-link" href="<?= SERVERURL ?>index.php?page=inicio">
                        <i class="fas fa-fw fa-tachometer-alt"></i>
                        <span>Panel</span></a>
                </li>
                <!-- Divider -->
                <hr class="sidebar-divider">
                <!-- Heading -->
                <div class="sidebar-heading">Modulos </div>

                <!-- Visitantes -->
                <li class="nav-item">
                    <a class="nav-link" href="<?= SERVERURL ?>index.php?page=inicioVisitantes">
                        <i class="fas fa-users"></i>
                        <span>Visitantes</span></a>
                </li>

                <!-- Departamentos -->
                <li class="nav-item">
                    <a class="nav-link" href="<?= SERVERURL ?>index.php?page=inicioDepartamentos">
                        <i class="fas fa-building"></i>
                        <span>Departamentos</span></a>
                </li>



                <!-- Personas no deseadas -->
                <li class="nav-item">
                    <a class="nav-link" href="<?= SERVERURL ?>index.php?page=inicioPersonal">
                        <i class="fas fa-user-friends"></i>
                        <span>Personal no Autorizado</span></a>
                </li>




                <!-- Divider -->
                <hr class="sidebar-divider d-none d-md-block">

                <!-- Heading -->
                <div class="sidebar-heading">Configuración</div>

                <!-- Usuarios -->
                <li class="nav-item">
                    <a class="nav-link" href="<?= SERVERURL ?>index.php?page=ModuloUsuario">
                        <i class="fas fa-user"></i>
                        <span>Usuarios</span></a>
                </li>

                <!-- Roles -->
                <li class="nav-item">
                    <a class="nav-link" href="<?= SERVERURL ?>index.php?page=inicioRoles">
                        <i class="fas fa-lock"></i>
                        <span>Roles</span></a>
                </li>


                <!-- Divider -->
                <hr class="sidebar-divider d-none d-md-block">

                <!-- Sidebar Toggler (Sidebar) -->
                <div class="text-center d-none d-md-inline">
                    <button class="rounded-circle border-0" id="sidebarToggle"></button>
                </div>
            <?php
            }


            ?>





        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <!-- Topbar Search -->
                    <form class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                        <div class="input-group">

                            <div class="input-group-append">


                                </button>
                            </div>
                        </div>
                    </form>

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <!-- Nav Item - Search Dropdown (Visible Only XS) -->
                        <li class="nav-item dropdown no-arrow d-sm-none">
                            <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-search fa-fw"></i>
                            </a>

                            <div class="topbar-divider d-none d-sm-block"></div>

                            <!-- Nav Item - User Information -->


                        <li class="nav-item dropdown no-arrow">

                            <a style="display: flex;
        justify-content: flex-end;" class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

                                <!-- <div sti>  <img src="libs/img/cintillo.png" alt=""></div> -->
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?php echo $usuario ?></span>
                                <img style="width: 10%;" class="libs/img-profile rounded-circle" src="libs/img/undraw_profile.svg">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">


                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="<?= SERVERURL ?>index.php?page=logoutUsuario">

                                    Cerrar Sesión
                                </a>
                            </div>
                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->

                <!-- Aquí va el contenido principal -->

            </div>
            <!-- End of Main Content -->