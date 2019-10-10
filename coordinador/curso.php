<?php

    session_start();
    ob_start();
    $token = uniqid();
    require_once '../sistema/header.php';

?>

<!-- Date Picker CSS -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/css/bootstrap-datepicker.min.css" rel="stylesheet" />

<!-- Select Picker -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/css/bootstrap-select.min.css">

<div class="alert alert-success alert-dismissible fade show" role="alert">
    <strong>¡Bienvenido a <i class="fas fa-school"></i> Mis cursos!</strong><br><br>
    En está página podrás:<br>
    • Seleccionar un programa y  curso de Inglés correspondiente<br>
    • Configurar el curso, los precios de los libros y las fechas del curso seleccionado<br>
</div>

<div class="row">
	<div class="col-xl-12 col-md-12 mb-4">
		<div class="card shadow h-100">
			<div class="card-header"><i class="fas fa-chalkboard-teacher"></i><strong> Selecciona un programa y un curso de Inglés</strong></div>
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
								<div class="row">
									<div class="col-xl-6 col-md-6">
										<div class="form-group">
											<select name="curso-select" id="curso-select" class="form-control" data-show-subtext="true" data-live-search="true"></select>
										</div>
									</div>
									<div class="col-xl-6 col-md-6">
										<div class="form-group">
											<button id="curso-nuevo" type="button" class="btn btn-primary btn-block" ><i class="fas fa-calendar-plus"></i> Agregar curso nuevo</button>
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
			<div class="card-header"><strong><i class="fas fa-cogs"></i> Configuración de curso</strong></div>
			<div class="card-body">
				<label><i class="fas fa-info-circle"></i> Por favor Indíca a continuación los precios de los libros en los niveles del programa seleccionado y las fechas del curso seleccionado</label>
				<br>
				<label><i class="fas fa-info-circle"></i> Esta configuración tendrá efecto <strong>ÚNICAMENTE</strong> para el curso seleccionado</label>
				<br>
				<label><i class="fas fa-info-circle"></i> Recuerda que hay una fecha límite para realizar la configuración, ponte en contacto con nosotros si no alcanzaste a configurar el curso en tiempo</label>
				<br>
				<label><i class="fas fa-info-circle"></i> Puedes guardar la configuración y confirmarla después, cuando todo se encuentre <strong>OK!</strong></label>
				<br>
				<br>
				<div class="row">
					<div class="col-xl-6 col-md-6 mb-4">
        				<label for="accion-periodo-venta-inicio"><strong>Curso seleccionado </strong></label>
        				<input style="width:100%" class="form-control" name="actualizar-nombre-curso" id="actualizar-nombre-curso" placeholder="Curso seleccionado" />
        				
        			</div>
        			<div class="col-xl-6 col-md-6 mb-4">
        			    <label for="accion-editar-nombre-curso"><strong>Editar nombre del curso </strong></label>
        				<button class="btn btn-primary btn-block" id="accion-editar-nombre-curso" ><i class="fas fa-pencil-alt"></i></button>
        			</div>
				</div>
				<div class="row">
					<div class="col-xl-12 col-md-12 mb-4">
						<div class="card h-100">
							<div class="card-header">
								<ul class="nav nav-pills" id="pills-tab" role="tablist">
									<li class="nav-item">
										<a class="nav-link active" id="pills-precios-tab" data-toggle="tab" href="#pills-precios" role="tab" aria-controls="pills-precios" aria-selected="true"><i class="fas fa-dollar-sign"></i> Precios</a>
									</li>
									<li class="nav-item">
										<a class="nav-link" id="pills-periodo-venta-tab" data-toggle="tab" href="#pills-periodo-venta" role="tab" aria-controls="pills-periodo-venta" aria-selected="false"><i class="fas fa-shopping-cart"></i> Período de venta</a>
									</li>
									<li class="nav-item">
										<a class="nav-link" id="pills-placement-test-tab" data-toggle="tab" href="#pills-placement-test" role="tab" aria-controls="pills-placement-test" aria-selected="false"><i class="fas fa-comments"></i> Placement Test</a>
									</li>
									<li class="nav-item">
										<a class="nav-link" id="pills-entrega-material-tab" data-toggle="tab" href="#pills-entrega-material" role="tab" aria-controls="pills-entrega-material" aria-selected="false"><i class="fas fa-truck"></i> Entrega de material</a>
									</li>
									<li class="nav-item">
										<a class="nav-link" id="pills-inicio-curso-tab" data-toggle="tab" href="#pills-inicio-curso" role="tab" aria-controls="pills-inicio-curso" aria-selected="false"><i class="fas fa-chalkboard-teacher"></i> Inicio de curso</a>
									</li>
								</ul>
							</div>
							<div class="card-body">
								<div class="mb-3">
									<div class="tab-content" id="pills-tabContent">
										<div class="tab-pane fade show active" id="pills-precios" role="tabpanel" aria-labelledby="pills-precios-tab">
											<label><i class="fas fa-dollar-sign"></i> Indíca los <strong>precios</strong> de venta de los libros para los alumnos durante el periodo de venta en el curso seleccionado</label>
											<br>
											<label><i class="fas fa-info-circle"></i> Si asignas <strong>puntos</strong> de recompesa por venta, se activará la sección de <strong><i class="fas fa-award"></i> Rewards</strong> del curso y podrás hacer uso de ella una vez que el curso haya comenzado</label>
											<br>
											<br>
											<table id="tabla-precio" class="table table-striped table-bordered nowrap" style="width:100%">
											</table>
											<p id="info"></p>
											<br>
											<br>
											<div class="row text-center ">
												<div class="col-xl-6 col-md-6 mb-4">
												    <button class="btn btn-primary btn-block" id="accion-guardar-configuracion-precios" ><i class="fas fa-save"></i> Guardar configuración de precios</button>
												</div>
												<div class="col-xl-6 col-md-6 mb-4">
											        <a class="links-style" id="accion-siguiente-periodo-venta" href="">Siguiente <i class="fas fa-arrow-circle-right"></i></a>
												</div>
											</div>
										</div>
										<div class="tab-pane fade" id="pills-periodo-venta" role="tabpanel" aria-labelledby="pills-periodo-venta-tab">
											<label><i class="fas fa-shopping-cart"></i> Indíca las fechas del <strong>período de venta</strong> para los alumnos</label>
											<br>
											<label><i class="fas fa-info-circle"></i> Es el período de tiempo en el cual la sección <a class="links-style" href="https://<?php echo strtolower($_SESSION['web_subdominio']); ?>.links2books.com/tienda/registro.php"><i class="fas fa-shopping-cart"></i> Tienda</a> estará abierta para que los alumnos puedan realizar sus pedidos de libros para el curso</label>
											<br>
											<br>
											<div class="row">
												<div class="col-xl-4 col-md-4 mb-4">
												    <label for="accion-periodo-venta-inicio"><strong>Primer día del período de venta </strong></label>
													<input style="width:100%" class="form-control" data-date-format="yyyy-mm-dd" name="accion-periodo-venta-inicio" id="accion-periodo-venta-inicio" placeholder="Primer día del período de venta" />
													<div class="invalid-feedback">Por favor completa este campo</div>
												</div>
												<div class="col-xl-4 col-md-4 mb-4">
													<label for="accion-periodo-venta-fin"><strong>Último día del período de venta </strong></label>
													<input style="width:100%" class="form-control" data-date-format="yyyy-mm-dd" name="accion-periodo-venta-fin" id="accion-periodo-venta-fin" placeholder="Último día del período de venta" />
												    <div class="invalid-feedback">Por favor completa este campo</div>
												</div>
												<div class="col-xl-4 col-md-4 mb-4">
												    <label for="accion-guardar-fechas-periodo-venta"><strong> Guardar fechas de período de venta</strong></label>
												    <button class="btn btn-primary btn-block" id="accion-guardar-fechas-periodo-venta" ><i class="fas fa-save"></i></button>
												</div>
											</div>
											<br>
											<br>
											<div class="row text-center ">
											    <div class="col-xl-3 col-md-3 mb-4">
											        <a class="links-style" id="accion-atras-precios" href=""><i class="fas fa-arrow-alt-circle-left"></i> Anterior</a>
												</div>
												<div class="col-xl-6 col-md-6 mb-4">
												    
												</div>
												<div class="col-xl-3 col-md-3 mb-4">
											        <a class="links-style" id="accion-siguiente-placement-test" href="">Siguiente <i class="fas fa-arrow-circle-right"></i></a>
												</div>
											</div>
										</div>
										<div class="tab-pane fade" id="pills-placement-test" role="tabpanel" aria-labelledby="pills-placement-test-tab">
											<label><i class="fas fa-comments"></i></i> Indíca las fechas de <strong>Placement Test</strong> para los alumnos</label>
											<br>
											<label><i class="fas fa-info-circle"></i> Es el periodo de tiempo en el cual los exámenes de colocación (<strong>Placement Test</strong>) serán aplicados en tu institución para asignar a los alumnos un nivel del Inglés</label>
											<br>
											<br>
											<div class="row">
												<div class="col-xl-4 col-md-4 mb-4">
												    <label for="accion-placement-test-inicio"><strong>Primer día de Placement Test </strong></label>
													<input style="width:100%" class="form-control" data-date-format="yyyy-mm-dd" name="accion-placement-test-inicio" id="accion-placement-test-inicio" placeholder="Primer día de Placement Test" />
													<div class="invalid-feedback">Por favor completa este campo</div>
												</div>
												<div class="col-xl-4 col-md-4 mb-4">
													<label for="accion-placement-test-fin"><strong>Último día de Placement Test </strong></label>
													<input style="width:100%" class="form-control" data-date-format="yyyy-mm-dd" name="accion-placement-test-fin" id="accion-placement-test-fin" placeholder="Último día de Placement Test" />
												    <div class="invalid-feedback">Por favor completa este campo</div>
												</div>
												<div class="col-xl-4 col-md-4 mb-4">
												    <label for="accion-guardar-fechas-placement-test"><strong>Guardar fechas de Placement Test</strong></label>
												    <button class="btn btn-primary btn-block" id="accion-guardar-fechas-placement-test"><i class="fas fa-save"></i></button>
												</div>
											</div>
											<br>
											<br>
											<div class="row text-center ">
											    <div class="col-xl-3 col-md-3 mb-4">
											        <a class="links-style" id="accion-atras-periodo-venta" href=""><i class="fas fa-arrow-alt-circle-left"></i> Anterior</a>
												</div>
												<div class="col-xl-6 col-md-6 mb-4">
												    
												</div>
												<div class="col-xl-3 col-md-3 mb-4">
											        <a class="links-style" id="accion-siguiente-entrega-material" href="">Siguiente <i class="fas fa-arrow-circle-right"></i></a>
												</div>
											</div>
										</div>
										<div class="tab-pane fade" id="pills-entrega-material" role="tabpanel" aria-labelledby="pills-entrega-material-tab">
											<label><i class="fas fa-truck"></i> Indíca las fechas de <strong>entrega de material</strong> para los alumnos</label>
											<br>
											<label><i class="fas fa-info-circle"></i> Es un rango de fechas en el que se espera recibir el envío de libros para los alumnos en tu institución (<strong>ETA</strong>) y su posterior entrega (<strong>coordinación interna en tu institución</strong>)</label>
											<br>
											<br>
											<div class="row">
												<div class="col-xl-4 col-md-4 mb-4">
												    <label for="accion-entrega-material-inicio"><strong>Primer día de espera de entrega de material </strong></label>
													<input style="width:100%" class="form-control" data-date-format="yyyy-mm-dd" name="accion-entrega-material-inicio" id="accion-entrega-material-inicio" placeholder="Primer día de espera de entrega de material" />
													<div class="invalid-feedback">Por favor completa este campo</div>
												</div>
												<div class="col-xl-4 col-md-4 mb-4">
													<label for="accion-entrega-material-fin"><strong>Último día de espera de entrega de material </strong></label>
													<input style="width:100%" class="form-control" data-date-format="yyyy-mm-dd" name="accion-entrega-material-fin" id="accion-entrega-material-fin" placeholder="Último día de espera de entrega de material" />
											        <div class="invalid-feedback">Por favor completa este campo</div>
												</div>
												<div class="col-xl-4 col-md-4 mb-4">
												    <label for="accion-guardar-fechas-entrega-material"><strong>Guardar fechas de entrega de material</strong></label>
												    <button class="btn btn-primary btn-block" id="accion-guardar-fechas-entrega-material"><i class="fas fa-save" ></i></button>
												</div>
											</div>
											<br>
											<br>
											<div class="row text-center ">
											    <div class="col-xl-3 col-md-3 mb-4">
											        <a class="links-style" id="accion-atras-placement-test" href="#"><i class="fas fa-arrow-alt-circle-left"></i> Anterior</a>
												</div>
												<div class="col-xl-6 col-md-6 mb-4">
												    
												</div>
												<div class="col-xl-3 col-md-3 mb-4">
											        <a class="links-style" id="accion-siguiente-inicio-curso" href="#">Siguiente <i class="fas fa-arrow-circle-right"></i></a>
												</div>
											</div>
										</div>
										<div class="tab-pane fade" id="pills-inicio-curso" role="tabpanel" aria-labelledby="pills-inicio-curso-tab">
											<label><i class="fas fa-chalkboard-teacher"></i> Indíca la fecha de <strong>inicio de curso</strong> para los alumnos</label>
											<br>
											<label><i class="fas fa-info-circle"></i> Es el día en el que oficialmente iniciará el curso de Inglés en tu institución (<strong>yipi!</strong>)</label>
											<br>
											<br>
											<div class="row">
												<div class="col-xl-6 col-md-6 mb-4">
												    <label for="accion-inicio-curso-inicio"><strong>Fecha de inicio del curso </strong></label>
													<input style="width:100%" class="form-control" data-date-format="yyyy-mm-dd" name="accion-inicio-curso-inicio" id="accion-inicio-curso-inicio" placeholder="Fecha de inicio del curso" />
												    <div class="invalid-feedback">Por favor completa este campo</div>
												</div>
											</div>
											<br>
											<br>
											<div class="row text-center ">
											    <div class="col-xl-6 col-md-6 mb-4">
											        <a class="links-style" id="accion-atras-entrega-material" href="#"><i class="fas fa-arrow-alt-circle-left"></i> Anterior</a>
												</div>
												<div class="col-xl-6 col-md-6 mb-4">
												    <button class="btn btn-primary btn-block" id="accion-guardar-fechas-inicio-curso" ><i class="fas fa-save" ></i> Guardar fecha de inicio del curso</button>
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
	</div>
</div>
<!--
<div class="row">
	<div class="col-xl-12 col-md-12 mb-4">
		<div class="card shadow h-100">
			<div class="card-header"><i class="fas fa-save"></i><strong> Guardar o confirmar configuración</strong></div>
			<div class="card-body">
				<label><i class="fas fa-info-circle"></i> Puedes guardar la configuración cuantas veces sea necesario, <strong>una vez confirmada no se podrán hacer cambios</strong></label>
				<br>
				<br>
				<div class="row">
					<div class="col-xl-6 col-md-6 mb-4">
						<button class="btn btn-primary btn-block" id="accion-guardar-configuracion"><i class="fas fa-save"></i> Guardar</button>
					</div>
					<div class="col-xl-6 col-md-6 mb-4">
						<button class="btn btn-primary btn-block" id="accion-confirmar-configuracion"><i class="fas fa-check"></i> Confirmar</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>-->

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
<script type="text/javascript" src="scripts/curso.js?token=<?php echo $token; ?>"></script>

<?php

    ob_end_flush();

?>