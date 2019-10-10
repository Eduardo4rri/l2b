<?php

    ob_start();
    session_start();
    $token = uniqid();
    require_once '../sistema/header.php';
    $rol = $_SESSION['usuario_rol'];
    if (!($rol == 'distribuidor'))
    {
        header('Location: ' . PRO_URL_403);
    }

?>
<!-- DataTables -->
<link href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css" rel="stylesheet" />
<link href="https://cdn.datatables.net/select/1.3.0/css/select.dataTables.min.css" rel="stylesheet" />

<!-- Data Tables Buttons -->
<link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/select/1.3.0/css/select.dataTables.min.css" rel="stylesheet"/>
<link href="https://cdn.datatables.net/fixedheader/3.1.5/css/fixedHeader.bootstrap4.min.css" rel="stylesheet"/>

<!-- Select Picker -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/css/bootstrap-select.min.css">

<!-- Custom fonts for this template-->
<link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

<!-- Custom styles for this template-->
<link href="../sistema/vendor/chart/css/sb-admin-2.min.css" rel="stylesheet">

<!-- Date Picker CSS -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/css/bootstrap-datepicker.min.css" rel="stylesheet" />

<!-- jVectorMap -->
<link href="../sistema/vendor/jvectormap/jquery-jvectormap-2.0.3.css" rel="stylesheet" media="screen" />

<style type="text/css">
    /* Estilos para el id de descarga PDF, color, cursor y decoracion  */
    #descargaPDF {
        color: blue;
        cursor: pointer;
        text-decoration: underline;
    }

    .map-container {
        height: 300px;
    }

    .jvmap-smart {
        width: 100%;
        height: 100%;
    }

    .map-container:after,
    .clearfix {
        display: block;
        content: '';
        clear: both;
    }

    .checks-seleccion {
        display: flex;
        justify-content: center;
        font-size: 15px;
    }

    .checks-seleccion .checks {
        position: relative;
        float: left;
        margin: 15px 35px 5px 35px;
    }

    .shadow-seleccion {
        margin-left: 10px;
        margin-bottom: 5px;
        width: 97%;
    }

    .car-py-grafica-barras {
        padding: 16px;
    }
 
 /* ------@medias queries------
  Se ponen los estilos para los screen y para
  el tamaño de la pantalla
 */
    @media only screen and (min-width: 576px) {
        .map-container {
            height: 350px;
        }
    }

    @media only screen and (min-width: 768px) {
        .map-container {
            height: 400px;
        }
        
    }

    @media only screen and (min-width: 992px) {
        .map-container {
            height: 500px;
        }
    }

    @media only screen and (min-width: 1200px) {
        .map-container {
            height: 600px;
        }
    }
    
    @media(max-width: 1070px) and (min-width:768px){
        .grafica-barras-ventas,
        .grafica-circular-ventas{
           -webkit-box-flex: 0;
          flex: 0 0 100%;
          max-width: 100%;
          position: relative;
          width: 100%;
          padding-right: .75rem;
           padding-left: .75rem;
         
        }
        .grafica-circular-ventas{
         margin-top:20px;
        }
        
    }
</style>

<!--
<br>
<div class="text-center" id="pagina-mensaje"><br>
	<h2><i class="fas fa-user"></i> ¡Bienvenido! Como coordinador podrás gestionar todo lo relacionado con la distribución de materiales para los alumnos de tu institución en la zona/subzona/escuela que te ha sido asignada.</h2>
</div>
-->

<div class="alert alert-success alert-dismissible fade show" role="alert">
    <strong><i class="fas fa-school"></i> Mis Escuelas</strong>
    <br>
    En esta página podrás asignar un distribuidor a todas las escuelas que te han sido asignadas. Sigue las sencillas instrucciones de cada sección para realizar dicha tarea.
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>

<div class="alert alert-warning alert-dismissible fade show" role="alert">
    <strong><i class="fas fa-school"></i> Fecha límite de asignación de distribuidor</strong>
    <br>
    Viernes 21 de Junio del 2019.
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>

<div class="row">
    <div class="col-xl-12 col-md-12 mb-4">
        <div class="card shadow">
            <div class="card-header"><i class="fas fa-school"></i> <strong>1. Selección de escuelas</strong></div>
            <div class="card-body">
                <label><i class="fas fa-info-circle"></i> Utiliza el mapa para seleccionar escuelas por <strong>estado</strong>, o realiza una selección manual por <strong>zona</strong> y <strong>estado</strong> utilizando las selecciones desplegables.</label>
                <br>
                <hr>
                <div class="row">
                    <div class="col-xs-4 col-md-4 h-100">
                        <div class="row">
                            <div class="col-xs-12 col-md-12">
                                <div class="form-group">
                                    <label><i class="fas fa-map"></i> <strong>Selección por mapa</strong></label>
                                    <div class="map-container">
                                        <div id="vmap" class="jvmap-smart"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br>
                    </div>
                    <div class="col-xs-8 col-md-8 h-100">
                        <div class="row">
                            <div class="col-xs-6 col-md-6">
                                <div class="form-group">
                                    <label><i class="fas fa-mountain"></i> <strong>Selección por zona</strong></label>
                                    <select name="zona-select" id="zona-select" class="form-control"></select>
                                </div>
                            </div>
                            <div class="col-xs-6 col-md-6">
                                <div class="form-group">
                                    <label><i class="fas fa-map-signs"></i> <strong>Selección por estado</strong></label>
                                    <select name="subzona-select" id="subzona-select" class="form-control"></select>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-xs-4 col-md-4 mb-3">
                                <div class="card border-left-primary shadow h-100 py-2">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Earnings (Monthly)</div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800">$40,000</div>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-calendar fa-2x text-gray-300"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-4 col-md-4 mb-3">
                                <div class="card border-left-primary shadow h-100 py-2">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Earnings (Monthly)</div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800">$40,000</div>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-calendar fa-2x text-gray-300"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-4 col-md-4 mb-3">
                                <div class="card border-left-primary shadow h-100 py-2">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Earnings (Monthly)</div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800">$40,000</div>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-calendar fa-2x text-gray-300"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="card shadow h-100 shadow-seleccion">
                                <div class="card-header">
                                    <h6 class="m-0 font-weight-bold text-primary">Selecciona el material</h6>
                                </div>
                                <div class="checks-seleccion">
                                    <div class="checks">
                                        <input type="checkbox" class="checkbox" id="graficas-materiales-AJ" checked />
                                        <label class="etiqueta-checks">American Jetstream</label>
                                    </div>
                                    <div class="checks">
                                        <input type="checkbox" class="checkbox" id="graficas-materiales-J" checked />
                                        <label>Jetstream</label>
                                    </div>
                                    <div class="checks">
                                        <input type="checkbox" class="checkbox" id="graficas-materiales-FR" checked />
                                        <label>For Real</label>
                                    </div>
                                    <div class="checks">
                                        <input type="checkbox" class="checkbox" id="graficas-materiales-FRP" checked />
                                        <label>For Real +</label>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <!-- Bar Chart -->
                            <div class="col-md-8 grafica-barras-ventas  h-100 ">
                                <div class="card shadow h-90 mb-8 ">
                                    <div class="card-header py-7 car-py-grafica-barras">
                                        <h6 class="m-0 font-weight-bold text-primary">Estadistica Mensual de Ventas</h6>
                                    </div>
                                    <div class="chart-bar" style="width:100% !important;">
                                        <canvas id="myBarChart" style="width:100% !important;"></canvas>
                                    </div>
                                </div>
                            </div>
                            <!-- Donut Chart -->
                            <div class="col-md-4 grafica-circular-ventas">
                                <div class="card shadow  h-55 mb-4">
                                    <div class="card-header py-3">
                                        <h6 class="m-0 font-weight-bold text-primary">Donut Chart</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="chart-pie pt-4">
                                            <canvas id="myPieChart"></canvas>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xl-12 col-md-12 mb-4">
        <div class="card shadow h-100">
            <div class="card-header"><i class="fas fa-school"></i> <strong>2. Selección tu pedido</strong></div>
            <div class="card-body">
                <div class="row">
                    <div class="col-xs-12 col-md-12">
                        <table id="tabla-pedidos" class="table table-striped table-bordered nowrap" style="width:100%">
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php

    require_once '../sistema/footer.php';

?>

<!-- jVectorMap -->
<script src="../sistema/vendor/jvectormap/jquery-jvectormap-2.0.3.min.js"></script>
<script type="text/javascript" src="scripts/mapa_mx_en.js"></script>

<!-- Select Picker -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/js/bootstrap-select.min.js"></script>

<!-- Date Picker -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/js/bootstrap-datepicker.min.js"></script>

<!-- Data Tables -->
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.3/js/responsive.bootstrap4.min.js"></script>
<script src="https://cdn.datatables.net/select/1.3.0/js/dataTables.select.min.js"></script>

<!-- Page level plugins -->
<script src="../sistema/vendor/chart/js/Chart.min.js"></script>

<!-- Charts 
<script src="../sistema/vendor/chart/js/chart-bar-demo.js"></script>
<script src="../sistema/vendor/chart/js/chart-pie-demo.js"></script>-->


<!-- Página -->
<script type="text/javascript" src="scripts/dashboard.js"></script>

<?php

    ob_end_flush();

?>