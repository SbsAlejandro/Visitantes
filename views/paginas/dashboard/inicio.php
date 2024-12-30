<?php

require_once 'controllers/VisitanteController.php';
$objeto                         = new VisitanteController();
$total_visitantes_hoy           = $objeto->visitantesDeHoy();
$total_visitantes_ayer          = $objeto->visitantesDeAyer();
$total_visitantes_siete_dias    = $objeto->visitantesSieteDias();
$total_visitantes               = $objeto->visitantesTotal();


if (session_status() === PHP_SESSION_ACTIVE) {
    //echo "La sesión está activa.";
    $usuario            = $_SESSION['usuario'];
    $id_usuario         = $_SESSION['user_id'];
    $rol                = $_SESSION['rol_usuario'];
} else {
    //echo "La sesión no está activa.";
    session_start();
    $usuario            = $_SESSION['usuario'];
    $id_usuario         = $_SESSION['user_id'];
    $rol           = $_SESSION['rol_usuario'];
}


?>
<!-- Begin Page Content -->
<div class="container-fluid">


    <!-- Content Row -->
    <div class="row">

        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                VISITANTES DE (HOY)</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <?php
                                foreach ($total_visitantes_hoy as $total_visitantes_hoy) {
                                    echo $visitantes_hoy = $total_visitantes_hoy['total_visitantes_hoy'];
                                }
                                ?>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                VISITANTES DE (AYER)</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <?php
                                foreach ($total_visitantes_ayer as $total_visitantes_ayer) {
                                    echo $visitantes_ayer = $total_visitantes_ayer['total_visitantes_ayer'];
                                }
                                ?>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">VISITANTES DE LOS (7 DIAS)
                            </div>
                            <div class="row no-gutters align-items-center">
                                <div class="col-auto">
                                    <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">
                                        <?php
                                        foreach ($total_visitantes_siete_dias as $total_visitantes_siete_dias) {
                                            echo $visitantes_siete_dias = $total_visitantes_siete_dias['total_visitantes_ultimos_7_dias'];
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pending Requests Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                TOTAL DE VISITANTES</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <?php
                                foreach ($total_visitantes as $total_visitantes) {
                                    echo $total = $total_visitantes['total_visitantes'];
                                }
                                ?>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php


        ?>

    </div>



</div>
<!-- /.container-fluid -->

<?php

?>