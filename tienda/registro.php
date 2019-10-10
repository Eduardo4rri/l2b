<?php

    ob_start();
    session_start();
    $token = uniqid();
    require_once '../sistema/header.php';
    $rol = $_SESSION['usuario_rol'];
    if (!($rol == 'alumno' || $rol == 'coordinador_dominio' || $rol == 'coordinador_zona' || $rol == 'coordinador_subzona' || $rol == 'coordinador_escuela'))
    {
        header('Location: ' . PRO_URL_SESION_CADUCADA);
    }

?>

<!-- Modal Usuario Confirmación -->
<div class="modal fade" id="registro-confirmacion-modal" tabindex="-1" role="dialog" aria-labelledby="registro-confirmacion-modal-label" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-lg" style="max-width: 90% !important; width: 90% !important;" role="document">
		<div class="modal-content">
			<div class="modal-header modal-vegdi">
				<h5 class="modal-title" id="registro-confirmacion-modal-label"><i class="fas fa-user"></i> ¿Tus datos son correctos?</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-md-3 mb-3">
						<h6><strong>Nombre</strong></h6>
						<h6 id="confirmacion-usuario-nombre"></h6>
					</div>
					<div class="col-md-3 mb-3">
						<h6><strong id="confirmacion-usuario-identificador"></strong></h6>
						<h6 id="confirmacion-usuario-matricula"></h6>
					</div>
					<div class="col-md-3 mb-3">
						<h6><strong>Teléfono</strong></h6>
						<h6 id="confirmacion-usuario-telefono"></h6>
					</div>
					<div class="col-md-3 mb-3">
						<h6><strong>Correo Electrónico</strong></h6>
						<h6 id="confirmacion-usuario-login"></h6>
					</div>
				</div>
				<div class="row">
					<div class="col-md-6 mb-6">
						<h6><strong>Escuela</strong></h6>
						<h6 id="confirmacion-escuela-seleccionada"></h6>
					</div>
					<div class="col-md-3 mb-3">
						<h6><strong>Programa</strong></h6>
						<h6 id="confirmacion-programa-seleccionado"></h6>
					</div>
					<div class="col-md-3 mb-3">
						<h6><strong>Niveles</strong></h6>
						<h6 id="confirmacion-programa-nivel-seleccionado"></h6>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<div style="width: 100%;">
					<button type="button" class="btn btn-secondary btn-block" data-dismiss="modal"><i class="fas fa-times"></i> Cancelar</button>
					<button type="button" class="btn btn-primary btn-block" id="tienda-confirmar-registro"><i class="fas fa-check"></i> Proceder a la compra</button>
				</div>
			</div>
		</div>
	</div>
</div>

<br>
<br>
<div class="alert pasos-alert" role="alert">
    <div class="text-center" id="pagina-mensaje"><br>
    	<h2>Paso 1 • Registro</h2>
    </div>
    <br>
    <br>
    
    <div class="row">
    	<div class="col-xs-12 col-md-12 text-center">
    		<nav class="nav nav-pills flex-column flex-sm-row">
    			<a class="flex-sm-fill text-sm-center nav-link active" href="#" id="paso-registro"><i class="fas fa-user"></i> 1. Registro</a>
    			<a class="flex-sm-fill text-sm-center nav-link disabled" href="#"><i class="fas fa-circle"></i></a>
    			<a class="flex-sm-fill text-sm-center nav-link disabled" href="#" id="paso-compra"><i class="fas fa-shopping-cart"></i> 2. Compra</a>
    			<a class="flex-sm-fill text-sm-center nav-link disabled" href="#"><i class="fas fa-circle"></i></a>
    			<a class="flex-sm-fill text-sm-center nav-link disabled" href="#" id="paso-confirmacion"><i class="fas fa-credit-card"></i> 3. Pago</a>
    			<a class="flex-sm-fill text-sm-center nav-link disabled" href="#"><i class="fas fa-circle"></i></a>
    			<a class="flex-sm-fill text-sm-center nav-link disabled" href="#" id="paso-entrega"><i class="fas fa-parachute-box"></i> 4. Entrega</a>
    		</nav>
    	</div>
    </div>
</div>

<br>
<br>

<div class="row">
	<div class="col-xs-12 col-md-12 mb-4">
		<div class="card shadow">
			<div class="card-header"><i class="fas fa-user"></i><strong> Tus datos</strong> (se requerirá una confirmación antes de continuar al paso <strong>2. Compra</strong>)</div>
			<div class="card-body">
				<form id="tienda-form-usuario">
					<div class="form-row">
						<input type="hidden" id="usuario-id" name="usuario-id" value="">
						<input type="hidden" id="usuario-idescuela" name="usuario-idescuela" value="">
						<input type="hidden" id="usuario-idprograma" name="usuario-idprograma" value="">
						<input type="hidden" id="usuario-escuela-nombre" name="usuario-escuela-nombre" value="">
						<input type="hidden" id="usuario-programa-nombre" name="usuario-programa-nombre" value="">
						<input type="hidden" id="usuario-programa-nivel" name="usuario-programa-nivel" value="">
						<input type="hidden" id="usuario-idcurso" name="usuario-idcurso" value="">
						<input type="hidden" id="usuario-idconsignacion" name="usuario-idconsignacion" value="">
					</div>
					<div class="form-row">
						<div class="col-md-4 mb-3">
							<label for="usuario-nombre"><strong>Nombre(s)</strong></label>
							<input type="text" class="form-control" id="usuario-nombre" name="usuario-nombre" placeholder="Nombre" value="">
							<div class="invalid-feedback">Por favor completa este campo</div>
						</div>
						<div class="col-md-4 mb-3">
							<label for="usuario-apellido-paterno"><strong>Apellido Paterno</strong></label>
							<input type="text" class="form-control" id="usuario-apellido-paterno" name="usuario-apellido-paterno" placeholder="Apellido Paterno" value="">
							<div class="invalid-feedback">Por favor completa este campo</div>
						</div>
						<div class="col-md-4 mb-3">
							<label for="usuario-apellido-materno"><strong>Apellido Materno</strong></label>
							<input type="text" class="form-control" id="usuario-apellido-materno" name="usuario-apellido-materno" placeholder="Apellido Materno" value="">
							<div class="invalid-feedback">Por favor completa este campo</div>
						</div>
					</div>
					<br>
					<div class="form-row">
						<div class="col-md-4 mb-3">
							<label for="usuario-matricula"><strong id="usuario-identificador"></strong></label>
							<input type="text" class="form-control" id="usuario-matricula" name="usuario-matricula" placeholder="Matrícula" value="">
							<div class="invalid-feedback">Por favor completa este campo</div>
						</div>
						<div class="col-md-4 mb-3">
							<div class="row">
								<div class="col-md-4 mb-3">
									<label for="usuario-lada"><strong>Lada</strong></label>
									<input type="text" class="form-control" id="usuario-lada" name="usuario-lada" placeholder="Lada" value="" maxlength="3" onkeypress="return validarDatosNumericos(event)">
									<div class="invalid-feedback">Por favor completa correctamente este campo</div>
								</div>
								<div class="col-md-8 mb-3">
									<label for="usuario-telefono"><strong>Teléfono</strong></label>
									<input type="text" class="form-control" id="usuario-telefono" name="usuario-telefono" placeholder="Telefono"  maxlength="8" value="" onkeypress="return validarDatosNumericos(event)">
									<div class="invalid-feedback">Por favor completa correctamenteeste campo</div>
								</div>
							</div>
						</div>
						<div class="col-md-4 mb-3">
							<label for="usuario-login"><strong>Correo Electrónico</strong></label>
							<input type="text" class="form-control" id="usuario-login" name="usuario-login" placeholder="Correo Electrónico" value="">
							<div class="invalid-feedback">Por favor completa este campo</div>
						</div>
					</div>
					<div class="form-row">
						<div class="col-md-12 mb-3">
							<div class="form-group text-center">
								<div class="form-check">
									<input class="form-check-input" type="checkbox" value="" id="usuario-terminos-condiciones" name="usuario-terminos-condiciones">
									<label class="form-check-label" for="usuario-terminos-condiciones" data-toggle="collapse" data-target="#terminos-collapse">
										<p><u>Acepto los términos y condiciones</u></p>
									</label>
								</div>
							</div>
							<div class="collapse" id="terminos-collapse">
								<div class="card shadow">
									<div class="card-header"><i class="fas fa-file-alt"></i><strong> Términos y condiciones</strong></div>
									<div class="card-body">
										<div class="row">
											<div class="col-md-12 mb-3">
												<div class="container">
													<iframe src="../terminos-y-condiciones.php" height="300" width="100%" style="border:0"></iframe>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-xs-12 col-md-12 mb-4">
		<div class="card shadow">
			<div class="card-header"><i class="fas fa-school"></i><strong> Tu escuela y programa de Inglés</strong> (para cambiar la selección utiliza la función <strong>Seleccionar escuela y programa</strong>)</div>
			<div class="card-body">
				<label>Escuela</label>
				<h6 class="form-control" id="usuario-escuela"></h6>
				<br>
				<label>Programa</label>
				<h6 class="form-control" id="usuario-programa"></h6>
				<br>
				<button type="button" class="btn btn-primary btn-block" data-toggle="collapse" data-target="#escuela-programa-collapse" aria-expanded="false" aria-controls="escuela-programa-collapse"><i class="fas fa-search"></i> Seleccionar escuela y programa</button>
				<br>
				<div class="collapse" id="escuela-programa-collapse">
					<div class="card card-body">
						<div class="row" id="tienda-buscar-escuela">
							<div class="col-xs-6 col-md-6 mb-4">
								<form method="post" id="tienda-form-direccion">
									<div class="form-group has-feedback">
										<h5 class="text-center">Buscar escuela por dirección</h5>
										<br>
										<input type="text" id="estado" name="estado" class="form-control" placeholder="Estado">
										<br>
										<input type="text" id="ciudad" name="ciudad" class="form-control" placeholder="Ciudad">
										<br>
										<input type="text" id="codigo-postal" name="codigo-postal" class="form-control" placeholder="Código Postal">
									</div>
									<button type="submit" class="btn btn-primary btn-block btn-flat"><i class="fas fa-search"></i> Buscar escuela por dirección</button>
								</form>
							</div>
							<div class="col-xs-6 col-md-6 mb-4">
								<form method="post" id="tienda-form-alias-nombre">
									<div class="form-group has-feedback">
										<h5 class="text-center">Buscar escuela por alias o nombre</h5>
										<br>
										<input type="text" id="alias" name="alias" class="form-control" placeholder="Alias">
										<br>
										<input type="text" id="nombre" name="nombre" class="form-control" placeholder="Nombre">
									</div>
									<button type="submit" class="btn btn-primary btn-block btn-flat"><i class="fas fa-search"></i> Buscar escuela por alias o nombre</button>
								</form>
							</div>
						</div>
						<br>
						<div class="row" id="tienda-escuela">
							<div class="col-xs-12 col-md-12">
								<br>
								<h5 class="text-center">Selecciona tu escuela</h5>
								<br>
								<table id="tienda-tabla-escuelas" class="table table-striped table-bordered nowrap" style="width:100%">
								</table>
							</div>
						</div>
						<br>
						<div class="row" id="tienda-programa">
							<div class="col-xs-12 col-md-12">
								<br>
								<h5 class="text-center">Selecciona tu programa</h5>
								<br>
								<table id="tienda-tabla-programas" class="table table-striped table-bordered nowrap" style="width:100%">
								</table>
							</div>
						</div>
						<br>
						<div class="row" id="tienda-registro-escuela-programa">
							<div class="col-xs-12 col-md-12">
								<button type="button" class="btn btn-primary btn-block" id="tienda-pre-confirmar-registro-cambio-escuela-programa"><i class="fas fa-check"></i> Confirmar selección de escuela y programa</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-xs-12 col-md-12">
		<div class="card shadow">
			<div class="card-header"><i class="fas fa-shopping-cart"></i><strong> Proceder a la compra</strong> (se requerirá una confirmación antes de continuar al paso <strong>2. Compra</strong>)</div>
			<div class="card-body">
				<button type="button" class="btn btn-primary btn-block" data-toggle="modal" id="tienda-pre-confirmar-registro"><i class="fas fa-check"></i> Proceder a la compra</button>
			</div>
		</div>
	</div>
</div>

<br>

<?php

    require_once '../sistema/footer.php';

?>

<!-- Página -->
<script type="text/javascript" src="scripts/registro.js?token=<?php echo $token; ?>"></script>

<?php

    ob_end_flush();

?>