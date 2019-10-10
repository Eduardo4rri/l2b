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

<style>
	#descargaPDF {
		color: blue;
		cursor: pointer;
		text-decoration: underline;
	}
	.btn-success {
	    background-color: #33cc99;
	    border-color: #33cc99;
    }
</style>

<!-- Data Tables Buttons -->
<link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/select/1.3.0/css/select.dataTables.min.css" rel="stylesheet"/>
<link href="https://cdn.datatables.net/fixedheader/3.1.5/css/fixedHeader.bootstrap4.min.css" rel="stylesheet"/>

<style type="text/css">
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
</style>

<!--
<br>
<div class="text-center" id="pagina-mensaje"><br>
	<h2><i class="fas fa-user"></i> ¡Bienvenido! Como coordinador podrás gestionar todo lo relacionado con la distribución de materiales para los alumnos de tu institución en la zona/subzona/escuela que te ha sido asignada.</h2>
</div>
-->

<!-- !!!!!!!!!!!!!!!!!!!!!!!!!!!!!! MODAL !!!!!!!!!!!!!!!!!!!!!!!!!!!!!! -->
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
							<input type="file" id="subir_file" name="subir_file">
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<div style="width: 100%;">
					<button type="button" class="btn btn-secondary btn-block" data-dismiss="modal"><i class="fas fa-times"></i> Cancelar</button>
					<button type="button" class="btn btn-primary btn-block" id="usuario-cargar-clave" onclick="ExportToTable()"><i class="fas fa-check"></i> Cargar</button>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! -->

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
		<div class="card shadow h-100">
			<div class="card-header"><i class="fas fa-school"></i> <strong> Pedido</strong></div>
			<div class="card-body">
				<div class="row">
					<div class="col-xs-12 col-md-12 mb-3">
						<table id="tabla-pedidos" class="table table-striped table-bordered" style="width:100%">
						</table>
					</div>
				</div>
				<div class="row">
                    <div class="col-xs-6 col-md-6 mb-3">
    				    <button id="actualizar-entregados" type="button" class="btn btn-primary btn-block"><i class="fas fa-save"></i> Guardar datos de entregados</button>
                    </div>
                    <div class="col-xs-6 col-md-6 mb-3">
    				    <button id="confirmar-entregados" type="button" class="btn btn-primary btn-block"><i class="fas fa-clipboard-check"></i> Confirmar datos de entregados</button>
                    </div>
                </div>
			</div>
		</div>
	</div>
</div>
<br>
<br>

<?php

    require_once '../sistema/footer.php';

?>

<!-- Data Tables -->
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.3/js/responsive.bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/select/1.3.0/js/dataTables.select.min.js"></script>
<script src="https://cdn.datatables.net/fixedheader/3.1.5/js/dataTables.fixedHeader.min.js"></script>

<!-- Data Tables Buttons -->
<script src="https://cdn.datatables.net/buttons/1.5.6/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.bootstrap4.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.html5.min.js"></script>

<!-- Data Tables Import -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.7.7/xlsx.core.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/xls/0.7.4-a/xls.core.min.js"></script>

<!-- Página -->
<script type="text/javascript" src="scripts/pedido.js?token=<?php echo $token; ?>"></script>


<?php

    ob_end_flush();

?>