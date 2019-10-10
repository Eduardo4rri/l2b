<?php

    session_start();
    ob_start();
    $token = uniqid();
    require_once '../sistema/header.php';

?>

<!-- Select Picker -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/css/bootstrap-select.min.css">

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

<div class="alert alert-success alert-dismissible fade show" role="alert">
    <strong>¡Bienvenido a <i class="fas fa-dolly-flatbed"></i> Mis Escuelas!</strong><br><br>
    En está página podrás:<br>
    • Selecionar el programa y curso de Ingles<br>
    • Elegir la escuela<br>
    • Podras hacer la asignación de un distribuidor<br>
</div>

<div class="row">
	<div class="col-xl-12 col-md-12 mb-4">
		<div class="card shadow h-100">
			<div class="card-header"><i class="fas fa-chalkboard-teacher"></i><strong>1. Selecciona un programa y un curso de Inglés</strong></div>
			<div class="card-body">
				<div class="row">
					<div class="col-xl-6 col-md-6 mb-4">
						<div class="card h-100">
							<div class="card-header"><strong><i class="fas fa-tasks"></i> Programa de Inglés</strong> (Curricular, Centro de Idiomas, etc...)</div>
							<div class="card-body">
								<label><i class="fas fa-info-circle"></i> Los programas aquí listados han sido precargados a partir de la información que tenemos de tu institución</label>
								<br>
								<br>
								<div class="form-group">
									<select name="programa-select" id="programa-select" class="form-control" data-show-subtext="true" data-live-search="true"></select>
								</div>
							</div>
						</div>
					</div>
					<div class="col-xl-6 col-md-6 mb-4">
						<div class="card h-100">
							<div class="card-header"><strong><i class="fas fa-calendar-alt"></i> Curso</strong> (semestre, cuatrimestre, trimestre, etc...)</div>
							<div class="card-body">
								<label><i class="fas fa-info-circle"></i> Selecciona (o agrega) un curso en el programa seleccionado para gestionar los precios de los libros y las fechas del curso</label>
								<br>
								<br>
								<div class="form-group">
									<select name="curso-select" id="curso-select" class="form-control" data-show-subtext="true" data-live-search="true"></select>
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
			<div class="card-header"><strong><i class="fas fa-parachute-box"></i> 3. Asignación de distribuidor</strong></div>
			<div class="card-body">
				<label><i class="fas fa-info-circle"></i> Selecciona un distribuidor de la lista desplegable y da click en <strong><i class="fas fa-check"></i> Asignar distribuidor</strong>, con ello habrás asignado al distribuidor que realizará los envíos de libros a tus escuelas.</label>
				<br>
				<br>
				<div class="row">
					<div class="col-xl-6 col-md-6">
						<div class="form-group">
							<select name="distribuidor-select" id="distribuidor-select" class="form-control" data-show-subtext="true" data-live-search="true"></select>
						</div>
					</div>
					<div class="col-xl-6 col-md-6">
						<div class="form-group">
							<button id="distribuidor-asignar" type="button" class="btn btn-primary btn-block"><i class="fas fa-check"></i> Asignar distribuidor</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<?php

    require_once '../sistema/footer.php';

?>


<!-- Date Picker -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/js/bootstrap-datepicker.min.js"></script>

<!-- Select Picker -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/js/bootstrap-select.min.js"></script>

<!-- Data Tables -->
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.3/js/responsive.bootstrap4.min.js"></script>
<script src="https://cdn.datatables.net/select/1.3.0/js/dataTables.select.min.js"></script>

<!-- Página -->
<script type="text/javascript" src="scripts/escuela.js?token=<?php echo $token; ?>"></script>

<?php

    ob_end_flush();

?>