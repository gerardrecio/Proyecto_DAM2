
<?php
    require('php/functions.php');
    session_start();

    if ($_SESSION['email'] == '')
    {
        header('Location: http://post-ticket.es');
    }
?>

<!doctype html>
<html lang="es">
 
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="assets/vendor/bootstrap/css/bootstrap.min.css">
    <link href="assets/vendor/fonts/circular-std/style.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/libs/css/style.css">
    <link rel="stylesheet" href="assets/vendor/fonts/fontawesome/css/fontawesome-all.css">
    <link rel="stylesheet" href="assets/vendor/charts/chartist-bundle/chartist.css">
    <link rel="stylesheet" href="assets/vendor/charts/morris-bundle/morris.css">
    <link rel="stylesheet" href="assets/vendor/fonts/material-design-iconic-font/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="assets/vendor/charts/c3charts/c3.css">
    <link rel="stylesheet" href="assets/vendor/charts/c3charts/colors.css">
    <link rel="stylesheet" href="assets/vendor/fonts/flag-icon-css/flag-icon.min.css">
    <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
    <script src="js/main_tasks_shared.js"></script>
    <title>Post-Ticket - Inicio</title>
</head>

<body>
    <!-- ============================================================== -->
    <!-- main wrapper -->
    <!-- ============================================================== -->
    <div class="dashboard-main-wrapper">
        <!-- ============================================================== -->
        <!-- navbar -->
        <!-- ============================================================== -->
        <div class="dashboard-header">
            <nav class="navbar navbar-expand-lg bg-white fixed-top">
                <a class="navbar-brand" href="index.php">POST-TICKET</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
            </nav>
        </div>


        <div class="nav-left-sidebar sidebar-dark">
            <div class="menu-list">
                <nav class="navbar navbar-expand-lg navbar-light">
                    <a class="d-xl-none d-lg-none" href="#">Dashboard</a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav flex-column">
                            <li class="nav-divider">
                                Menu
                            </li>
							
							<li class="nav-item">
								<a class="nav-link xcrear_taulell" href="#" aria-expanded="false" data-target="#submenu-9" aria-controls="submenu-9"><i class="fas fa-fw fa-file"></i>Crear Taulell <span class="badge badge-success">9</span></a>
							</li>
                            <li class="nav-item ">
                                <a class="nav-link" href="#" data-toggle="collapse" aria-expanded="false" data-target="#submenu-1" aria-controls="submenu-1"><i class="fas fa-fw fa-file"></i>Taulells <span class="badge badge-success">6</span></a>
                                <div id="submenu-1" class="collapse submenu">
                                    <ul class="nav flex-column">
										<li class="nav-item">
                                            <a class="nav-link" href="index.php">Inici</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link xexpand_propis" href="#" data-toggle="collapse" aria-expanded="false" data-target="#submenu-1-2" aria-controls="submenu-1-2">Taulells Propis</a>
                                            <div id="submenu-1-2" class="collapse submenu">
                                                <ul class="nav flex-column">
                                                <?php
                                                    create_table_propierty($_SESSION['email']);
                                                ?>
                                                </ul>
                                            </div>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="#" data-toggle="collapse" aria-expanded="false" data-target="#submenu-1-1" aria-controls="submenu-1-1">Taulells Compartits</a>
                                            <div id="submenu-1-1" class="collapse submenu">
                                                <ul class="nav flex-column">
                                                    <?php
                                                        create_table_shared_new($_SESSION['email']);
                                                    ?>
                                                </ul>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </li>
 
							<li class="nav-item">
                                <a class="nav-link" href="#" data-toggle="collapse" aria-expanded="false" data-target="#submenu-5" aria-controls="submenu-5"><i class="fas fa-fw fa-table"></i>Configurar Taulells</a>
                                <div id="submenu-5" class="collapse submenu">
                                    <ul class="nav flex-column">
                                        <?php
                                            create_conf_propierty($_SESSION['email']);
                                        ?>
                                    </ul>
                                </div>
                            </li>
							
                            <li class="nav-divider">
                                Opcions
                            </li>

							<li class="nav-item">
                                <a class="nav-link" href="#" data-toggle="collapse" aria-expanded="false" data-target="#submenu-6" aria-controls="submenu-6"><i class="fa fa-fw fa-user-circle"></i> Perfil </a>
                                <div id="submenu-6" class="collapse submenu">
                                    <ul class="nav flex-column">
                                        <li class="nav-item">
                                            <a class="nav-link" href="account.php">Compte</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="php/logout.php">Tancar Sessió</a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                        </ul>
                    </div>
                </nav>
            </div>
        </div>
 
        <div class="dashboard-wrapper">
            <div class="dashboard-ecommerce">
                <div class="container-fluid dashboard-content ">
                    <!-- ============================================================== -->
                    <!-- pageheader  -->
                    <!-- ============================================================== -->
                    <div class="row">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="page-header">
                                <h2 class="pageheader-title">Taulells Compartits</h2>
                                <p class="pageheader-text">Nulla euismod urna eros, sit amet scelerisque torton lectus vel mauris facilisis faucibus at enim quis massa lobortis rutrum.</p>
                                <div class="page-breadcrumb">
                                    <nav aria-label="breadcrumb">
                                        <ol class="breadcrumb">
                                            <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">Taulells</a></li>
                                            <li class="breadcrumb-item active" aria-current="page"><?php
                                                echo obtenir_nom_taulell_GET();
                                            ?></li>
                                        </ol>
                                    </nav>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- ============================================================== -->
                    <!-- end pageheader  -->
                    <!-- ============================================================== -->
                    <div class="ecommerce-widget">
                        <div class="card">
                            <h5 class="card-header">
                                <div class="col-xl-3 float-left mt-1">
                                    <span class="xnom_tasca"></span><br>
                                    <span class="xnom_creador"></span><br>
                                </div>
                                <div class="col-xl-3 float-right">
                                    <span class="xasignat_task">Assignat: </span>
                                    <select class="form-control xassignat_form"></select>
                                </div>
                                <div class="col-xl-3 float-right">
                                    <span class="xestat_task">Estat: </span>
                                    <select class="form-control xestat_form"></select>
                                </div>
                                <div class="col-xl-3 float-right">
                                    <span class="xcategoria_task">Categoria: </span>
                                    <select class="form-control xcategoria_form"></select>
                                </div>
                            </h5>
                            <div class="card-body">

                                <div class="col-xl-12">
                                    <p class="card-text text-justify xmissatge_inicial"></p>
                                </div>

                                <div class="xrebre_missatges">
                                </div>

                                <div class="col-xl-2 input-group input-group-sm mb-3 mt-5">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="inputGroup-sizing-sm">Data Limit: </span>
                                    </div>
                                    <input type="text" class="form-control xdata_limit" aria-label="Small" aria-describedby="inputGroup-sizing-sm" disabled>
                                </div>
                                
                                <div class="col-xl">
                                    <button type="button" class="btn btn-primary xcanviar_data">Canviar Data</button>
                                </div>

                                <div class="col-xl-12 mt-3">
                                    <textarea class="form-control xtextarea_form" id="exampleFormControlTextarea1" rows="6"></textarea>
                                </div>

                                <div class="col-xl mt-4">
                                    <button type="button" class="btn btn-primary xenviar_boto">Enviar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- ============================================================== -->
            <!-- footer -->
            <!-- ============================================================== -->
            <div class="footer">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                             Copyright © 2018 Concept. All rights reserved. Dashboard by <a href="https://colorlib.com/wp/">Colorlib</a>.
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                            <div class="text-md-right footer-links d-none d-sm-block">
                                <a href="javascript: void(0);">About</a>
                                <a href="javascript: void(0);">Support</a>
                                <a href="javascript: void(0);">Contact Us</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- ============================================================== -->
            <!-- end footer -->
            <!-- ============================================================== -->
        </div>
        <!-- ============================================================== -->
        <!-- end wrapper  -->
        <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- end main wrapper  -->
    <!-- ============================================================== -->
    <!-- Optional JavaScript -->
    <!-- jquery 3.3.1 -->
    <script src="assets/vendor/jquery/jquery-3.3.1.min.js"></script>
    <!-- bootstap bundle js -->
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.js"></script>
    <!-- slimscroll js -->
    <script src="assets/vendor/slimscroll/jquery.slimscroll.js"></script>
    <!-- main js -->
    <script src="assets/libs/js/main-js.js"></script>
    <!-- chart chartist js -->
    <script src="assets/vendor/charts/chartist-bundle/chartist.min.js"></script>
    <!-- sparkline js -->
    <script src="assets/vendor/charts/sparkline/jquery.sparkline.js"></script>
    <!-- morris js -->
    <script src="assets/vendor/charts/morris-bundle/raphael.min.js"></script>
    <script src="assets/vendor/charts/morris-bundle/morris.js"></script>
    <!-- chart c3 js -->
    <script src="assets/vendor/charts/c3charts/c3.min.js"></script>
    <script src="assets/vendor/charts/c3charts/d3-5.4.0.min.js"></script>
    <script src="assets/vendor/charts/c3charts/C3chartjs.js"></script>
    <script src="assets/libs/js/dashboard-ecommerce.js"></script>
</body>
 
</html>
