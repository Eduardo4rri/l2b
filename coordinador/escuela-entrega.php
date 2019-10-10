<?php

    session_start();
    ob_start();
    $token = uniqid();
    require_once '../sistema/header.php';

?>

<style type="text/css">
    #descargaPDF {
        color: blue;
        cursor: pointer;
        text-decoration: underline;
    }

    .btn-success {
        background-color: #33cc99;
        border-color: #33cc99;
    }

    .titulo-indicadores {
        font-size: 10px;
        color: #4e73df !important;
    }

    .text-gray-800 {
        color: #5a5c69;
    }
</style>

<div class="modal fade" id="importar-excel-modal" tabindex="-1" role="dialog" aria-labelledby="importar-excel-modal-label" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header modal-vegdi">
                <h5 class="modal-title"><i class="fas fa-file-upload"></i> Importar Excel</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="card card-body">
                    <div class="row">
                        <div class="col-md-12 mb-12 mb-3">
                            <input type="file" id="archivo-subir" name="archivo-subir">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div style="width: 100%;">
                    <button type="button" class="btn btn-secondary btn-block" data-dismiss="modal"><i class="fas fa-times"></i> Cancelar</button>
                    <button type="button" class="btn btn-primary btn-block" id="usuario-cargar-clave" onclick="importarExcel()"><i class="fas fa-check"></i> Cargar</button>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="importar-excel-continuar-modal" tabindex="-1" role="dialog" aria-labelledby="importar-excel-modal-label" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header modal-vegdi">
                <h5 class="modal-title"><i class="fas fa-check"></i> Confirmar actualización de entregas</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="card card-body">
                    <div class="row">
                        <div class="col-md-12 mb-12 mb-3" id="archivo-actualizar">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div style="width: 100%;">
                    <button type="button" class="btn btn-secondary btn-block" data-dismiss="modal"><i class="fas fa-times"></i> Cancelar</button>
                    <button type="button" class="btn btn-primary btn-block" id="usuario-cargar-clave-2" onclick="confirmarExcel()"><i class="fas fa-check"></i> Confirmar y actualizar registros de entregas</button>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="seleccionar-libro-entregar-modal" tabindex="-1" role="dialog" aria-labelledby="seleccionar-libro-entregar-modal-label" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header modal-vegdi">
                <h5 class="modal-title"><i class="fas fa-check"></i> Confirmar entrega de libro</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="card card-body">
                    <div class="row">
                        <div class="col-md-12 mb-12 mb-3" id="seleccionar-libro-entregar">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div style="width: 100%;">
                    <button type="button" class="btn btn-secondary btn-block" data-dismiss="modal"><i class="fas fa-times"></i> Cancelar</button>
                    <button type="button" class="btn btn-primary btn-block" id="seleccionar-entrega-cambio-libro" onclick="confirmarCambioLibroEntrega();"><i class="fas fa-check"></i> Confirmar entrega de libro</button>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="alert blue-alert" role="alert">
    <strong>¡Bienvenido a <i class="fas fa-dolly-flatbed"></i> Mis Entregas!</strong><br><br>
    En está página podrás:<br>
    • Revisar el estatus de las entregas de compras a los alumnos de una escuela en un curso en particular<br>
    • Exportar a Excel dichos estatus<br>
    • Importar de Excel dichos estatus y actualizarlos<br>
</div>

<div class="row">
    <div class="col-xl-12 col-md-12 mb-3">
        <div class="card shadow h-100">
            <div class="card-header"><i class="fas fa-school"></i> <strong> Lista de compras y entregas</strong></div>
            <div class="card-body">
                <div class="row">
                    <div class="col-xs-12 col-md-12 mb-3">
                        <i class="fas fa-info-circle"></i> <strong>Instrucciones para actualizar los estatus de las entregas mediante EXCEL</strong><br><br>
                        <strong>1 • </strong> Asegurate que no haya compras con <strong>NIVEL POR ASIGNAR</strong>.<br>
                        <strong>2 • </strong> Exporta el archivo en <strong>EXCEL</strong>, éste incluirá los mismos datos que ves en la lista de entregas (puedes aplicar los filtros que desees).<br>
                        <strong>3 • </strong> Utiliza este archivo durante la entrega de los libros, pide al alumno una identificación y el comprobante de su pago, luego marca la columna de <strong>Estatus de Entrega</strong> con la palabra <strong>ENTREGADO</strong>.<br>
                        <strong>4 • </strong> Importa el archivo para actualizar los estatus de las entregas, el sistema realizará una validación de los datos y actualizará únicamente las entregas nuevas, de haber errores o advertencias en los datos importados, el sistema te notificará de los mismos para que puedan ser corregidos.<br>
                        <strong>5 • </strong> Recuerda que el archivo a importar debe contener <strong> TODAS LAS COLUMNAS, SIN IMPORTAR EL ORDEN</strong> que el archivo exportado en el primer paso, y sólo los registros de entregas con la palabra de <strong>ENTREGADO</strong> en la columna <strong>Estatus de Entrega</strong> serán actualizados.<br>
                        <strong>6 • </strong> Puedes realizar este proceso las veces que sean necesarias hasta haber realizado todas las entregas <strong><i class="fas fa-smile-wink"></i></strong><br>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-xs-12 col-md-12 mb-3">
                        <i class="fas fa-info-circle"></i> <strong>Instrucciones para actualizar los estatus de las entregas mediante SISTEMA EN LÍNEA</strong><br><br>
                        <strong>1 • </strong> Pide al alumno una identificación y el comprobante de su pago, puedes buscar al alumno mediante su <strong>MATRÍCULA</strong> en la lista y a continuación da click en el botón <strong>ENTREGAR LIBRO</strong>.<br>
                        <strong>2 • </strong> Confirma el libro a entregar, si el alumno aún tiene el libro <strong>NIVEL POR ASIGNAR</strong>, asegurate de cambiar el libro a entregar en las opciones desplegables por el nivel indicado para el alumno.<br>
                    </div>
                </div>
                <br>
                <div class="row justify-content-center">
                    <div class="col-xs-12 col-md-12 mb-3">
                        <div class="card shadow">
                            <div class="card-header"><i class="fas fa-school"></i> <strong> Escuela y Curso</strong></div>
                            <div class="card-body text-center">
                                <p id="escuela-nombre"></p>
                                <hr>
                                <p id="curso-nombre"></p>
                            </div>
                        </div>
                    </div>
                </div>
                <br>
                <div class="row justify-content-center">
                    <div class="col-xs-12 col-md-12 mb-3">
                        <div class="card shadow">
                            <div class="card-header"><i class="fas fa-filter"></i> <strong> Selecciona un estatus de compra o entrega</strong></div>
                            <div class="card-body">
                                <div class="row  no-gutters align-items-center justify-content-center">
                                    <div class=" col-md-2 form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="filtros-todos" id="filtros-todos" value="" checked>
                                        <label class="form-check-label" for="filtros-todos">Mostrar Todas</label>
                                    </div>
                                    <div class="col-md-2 form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="filtros-todos" id="filtros-pagadas" value="">
                                        <label class="form-check-label" for="filtros-pagadas">Mostrar Pagadas</label>
                                    </div>
                                    <div class="col-md-2 form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="filtros-todos" id="filtros-pendientes" value="">
                                        <label class="form-check-label" for="filtros-pendientes">Mostrar Por Pagar</label>
                                    </div>
                                    <div class="col-md-2 form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="filtros-todos" id="filtros-entregadas" value="">
                                        <label class="form-check-label" for="filtros-entregadas">Mostrar Entregadas</label>
                                    </div>
                                    <div class="col-md-2 form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="filtros-todos" id="filtros-no-entregadas" value="">
                                        <label class="form-check-label" for="filtros-no-entregadas">Mostrar Sin Entregar</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <br>
                <div class="row justify-content-center">
                    <div class="col-xs-12 col-md-12 mb-3">
                        <div class="card shadow">
                            <div class="card-header"><i class="fas fa-filter"></i> <strong>Selecciona un nivel</strong></div>
                            <div class="card-body">
                                <div class="row  no-gutters align-items-center justify-content-center">
                                    <div class="pr-4 pl-4 form-check form-check-inline">
                                        <input class="form-check-input" type="radio" id="filtro-todos-niveles" name="filtros-niveles" value="" checked>
                                        <label class="form-check-label" for="filtro-todos-niveles">Todos</label>
                                    </div>
                                    <div class="pr-4 pl-4 form-check form-check-inline">
                                        <input class="form-check-input" type="radio" id="filtro-american-jestream-beginner" name="filtros-niveles" value="">
                                        <label class="form-check-label" for="filtro-american-jestream-beginner">Beginner</label>
                                    </div>
                                    <div class="pr-4 pl-4 form-check form-check-inline">
                                        <input class="form-check-input" type="radio" id="filtro-american-jestream-elementary" name="filtros-niveles" value="">
                                        <label class="form-check-label" for="filtro-american-jestream-elementary">Elementary</label>
                                    </div>
                                    <div class="pr-4 pl-4 form-check form-check-inline">
                                        <input class="form-check-input" type="radio" id="filtro-american-jestream-pre-intermediate" name="filtros-niveles" value="">
                                        <label class="form-check-label" for="filtro-american-jestream-pre-intermediate">Pre-Intermediate</label>
                                    </div>
                                    <div class="pr-4 pl-4 form-check form-check-inline">
                                        <input class="form-check-input" type="radio" id="filtro-american-jestream-intermediate" name="filtros-niveles" value="">
                                        <label class="form-check-label" for="filtro-american-jestream-intermediate">Intermediate</label>
                                    </div>
                                    <div class="pr-4 pl-4 form-check form-check-inline">
                                        <input class="form-check-input" type="radio" id="filtro-american-jestream-upper-intermediate" name="filtros-niveles" value="">
                                        <label class="form-check-label" for="filtro-american-jestream-upper-intermediate">Upper-Intermediate</label>
                                    </div>
                                    <div class="pr-4 pl-4 form-check form-check-inline">
                                        <input class="form-check-input" type="radio" id="filtro-american-jestream-advanced" name="filtros-niveles" value="">
                                        <label class="form-check-label" for="filtro-american-jestream-advanced">Advanced</label>
                                    </div>
                                    <div class=" pr-4 pl-4 form-check form-check-inline">
                                        <input class="form-check-input" type="radio" id="filtro-sin-asignar" name="filtros-niveles" value="">
                                        <label class="form-check-label" for="filtro-sin-asignar">Por Asignar</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <br>
                <div class="row justify-content-center">
                    <div class="col-xl-12 col-md-12 mb-3">
                        <div class="card shadow h-100">
                            <div class="card-header"><i class="fa fa-info-circle"></i><strong> Estatus general de compras y entregas</strong></div>
                            <div class="card-body">
                                <div class="row justify-content-md-center">
                                    <div class=" col-md-2 col-xs-12 col-lg-2 mb-4">
                                        <div class="card shadow h-100 py-2" style="border-left:5px solid #536b97;">
                                            <div class="card-body">
                                                <div class="row no-gutters align-items-center">
                                                    <div class="col mr-2">
                                                        <div class="text-xs text-primary text-uppercase mb-1 titulo-indicadores"><strong>Libros Solicitados</strong></div>
                                                        <div class="h5 mb-0 font-weight-bold text-gray-800" style="font-size: 2em;" id="entregas-solicitados">0</div>
                                                    </div>
                                                    <div class="col-auto">
                                                        <i class="fas fa-truck-loading fa-3x text-gray-300"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class=" col-md-2 col-xs-12 col-lg-2 mb-4">
                                        <div class="card shadow h-100 py-2" style="border-left:5px solid #536b97;">
                                            <div class="card-body">
                                                <div class="row no-gutters align-items-center">
                                                    <div class="col mr-2">
                                                        <div class="text-xs text-primary text-uppercase mb-1 titulo-indicadores"><strong>Total Pedidos</strong></div>
                                                        <div class="h5 mb-0 font-weight-bold text-gray-800" style="font-size: 2em;" id="entregas-totales">0</div>
                                                    </div>
                                                    <div class="col-auto">
                                                        <i class="fas fa-list fa-3x text-gray-300"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-2 col-xs-12 col-lg-2 mb-4">
                                        <div class="card shadow h-100 py-2" style="border-left:5px solid #536b97;">
                                            <div class="card-body">
                                                <div class="row no-gutters align-items-center">
                                                    <div class="col mr-2">
                                                        <div class="text-xs  text-primary text-uppercase mb-1 titulo-indicadores"><strong>Total Pedidos Pagados</strong></div>
                                                        <div class="h5 mb-0 font-weight-bold text-gray-800" style="font-size: 2em;" id="entregas-pagadas">0</div>
                                                    </div>
                                                    <div class="col-auto">
                                                        <i class="fas fa-wallet fa-3x text-gray-300"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-2 col-xs-12 col-lg-2 mb-4">
                                        <div class="card shadow h-100 py-2" style="border-left:5px solid #536b97;">
                                            <div class="card-body">
                                                <div class="row no-gutters align-items-center">
                                                    <div class="col mr-2">
                                                        <div class="text-xs text-primary text-uppercase mb-1 titulo-indicadores"><strong>Compras Entregadas</strong></div>
                                                        <div class="h5 mb-0 font-weight-bold text-gray-800" style="font-size: 2em;" id="entregas-entregadas">0</div>
                                                    </div>
                                                    <div class="col-auto">
                                                        <i class="fas fa-check fa-3x text-gray-300"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-2 col-xs-12 col-lg-2 mb-4">
                                        <div class="card shadow h-100 py-2" style="border-left:5px solid #536b97;">
                                            <div class="card-body">
                                                <div class="row no-gutters align-items-center">
                                                    <div class="col mr-2">
                                                        <div class="text-xs text-primary text-uppercase mb-1 titulo-indicadores"><strong>Pedidos con Nivel Por Asignar</strong></div>
                                                        <div class="h5 mb-0 font-weight-bold text-gray-800" style="font-size: 2em;" id="entregas-nivel-por-asignar">0</div>
                                                    </div>
                                                    <div class="col-auto">
                                                        <i class="fas fa-question-circle fa-3x text-gray-300"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row justify-content-md-center">
                                    <div class="col-md-2 col-xs-12 col-lg-2 mb-4">
                                        <div class="card shadow h-100 py-2" style="border-left:5px solid #536b97;">
                                            <div class="card-body">
                                                <div class="row no-gutters align-items-center">
                                                    <div class="col mr-2">
                                                        <div class="text-xs text-primary text-uppercase mb-1 titulo-indicadores"><strong>Pagados con Nivel Por Asignar</strong></div>
                                                        <div class="h5 mb-0 font-weight-bold text-gray-800" style="font-size: 2em;" id="entregas-pagadas-nivel-por-asignar">0</div>
                                                    </div>
                                                    <div class="col-auto">
                                                        <i class="fas fa-question-circle fa-3x text-gray-300"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-2 col-xs-12 col-lg-2 mb-4">
                                        <div class="card shadow h-100 py-2" style="border-left:5px solid #536b97;">
                                            <div class="card-body">
                                                <div class="row no-gutters align-items-center">
                                                    <div class="col mr-2">
                                                        <div class="text-xs text-primary text-uppercase mb-1 titulo-indicadores"><strong>Sin pagar con Nivel Por Asignar</strong></div>
                                                        <div class="h5 mb-0 font-weight-bold text-gray-800" style="font-size: 2em;" id="entregas-no-pagadas-nivel-por-asignar">0</div>
                                                    </div>
                                                    <div class="col-auto">
                                                        <i class="fas fa-question-circle fa-3x text-gray-300"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-2 col-xs-12 col-lg-2 mb-4">
                                        <div class="card shadow h-100 py-2" style="border-left:5px solid #536b97;">
                                            <div class="card-body">
                                                <div class="row no-gutters align-items-center">
                                                    <div class="col mr-2">
                                                        <div class="text-xs text-primary text-uppercase mb-1 titulo-indicadores"><strong>Libros Pagados por Entregar</strong></div>
                                                        <div class="h5 mb-0 font-weight-bold text-gray-800" style="font-size: 2em;" id="entregas-por-entregar">0</div>
                                                    </div>
                                                    <div class="col-auto">
                                                        <i class="far fa-square fa-3x text-gray-300"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-2 col-xs-12 col-lg-2 mb-4">
                                        <div class="card shadow h-100 py-2" style="border-left:5px solid #536b97;">
                                            <div class="card-body">
                                                <div class="row no-gutters align-items-center">
                                                    <div class="col mr-2">
                                                        <div class="text-xs text-primary text-uppercase mb-1 titulo-indicadores"><strong>Pedidos por Pagar</strong></div>
                                                        <div class="h5 mb-0 font-weight-bold text-gray-800" style="font-size: 2em;" id="entregas-por-pagar">0</div>
                                                    </div>
                                                    <div class="col-auto">
                                                        <i class="fas fa-clock fa-3x text-gray-300"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-2 col-xs-12 col-lg-2 mb-4">
                                        <div class="card shadow h-100 py-2" style="border-left:5px solid #536b97;">
                                            <div class="card-body">
                                                <div class="row no-gutters align-items-center">
                                                    <div class="col mr-2">
                                                        <div class="text-xs text-primary text-uppercase mb-1 titulo-indicadores"><strong>Balance en Almacén</strong></div>
                                                        <div class="h5 mb-0 font-weight-bold text-gray-800" style="font-size: 2em;" id="entregas-inventario">0</div>
                                                    </div>
                                                    <div class="col-auto">
                                                        <i class="fas fa-box fa-3x text-gray-300"></i>
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
                <hr>
                <div class="row">
                    <div class="col-xs-12 col-md-12 mb-3">
                        <table id="tabla-pedidos" class="table table-striped table-bordered" style="width:100%">
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

<!-- Página -->
<script type="text/javascript" src="scripts/escuela_entrega.js?token=<?php echo $token; ?>"></script>

<?php

    ob_end_flush();

?>