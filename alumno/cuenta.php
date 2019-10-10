<?php

    session_start();
    ob_start();
    $token = uniqid();
    require_once '../sistema/header.php';

?>

<style>
  @media screen and (max-width: 1200px) and (min-width: 700px) {
    .form-espacio-margen-lada{
        padding-right:0px;
    }
    .form-espacio-margen-telefono{
        padding-left:7px;
    }
  }
</style>
<!-- Modal Datos Usuario -->
<div class="modal fade" id="usuario-modal" tabindex="-1" role="dialog" aria-labelledby="usuario-modal-label" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-lg" style="max-width: 90% !important; width: 90% !important;" role="document">
		<div class="modal-content">
			<div class="modal-header modal-vegdi">
				<h5 class="modal-title"><i class="fas fa-user"></i> Mis datos</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="card card-body">
					<form id="form-usuario">
						<div class="form-row">
							<input type="hidden" id="usuario-id" name="usuario-id" value="">
							<input type="hidden" id="usuario-idescuela" name="usuario-idescuela" value="">
							<input type="hidden" id="usuario-idprograma" name="usuario-idprograma" value="">
							<input type="hidden" id="usuario-escuela-nombre" name="usuario-escuela-nombre" value="">
							<input type="hidden" id="usuario-programa-nombre" name="usuario-programa-nombre" value="">
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
								<label for="usuario-matricula"><strong>Matrícula *</strong></label>
								<input type="text" class="form-control" id="usuario-matricula" name="usuario-matricula" placeholder="Matrícula" value="">
								<div class="invalid-feedback">Por favor completa este campo</div>
							</div>
							<div class="col-md-4 mb-3">
								<div class="row">
									<div class="col-md-5 mb-3 form-espacio-margen-lada" >
										<label for="usuario-lada"><strong>Lada</strong></label>
										<input type="text" class="form-control" id="usuario-lada" name="usuario-lada" placeholder="Lada" value="" maxlength="3" onkeypress="return validarDatosNumericos(event)">
										<div class="invalid-feedback">Por favor completa correctamente este campo</div>
									</div>
									<div class="col-md-7 mb-3 form-espacio-margen-telefono" >
										<label for="usuario-telefono"><strong>Teléfono</strong></label>
										<input type="text" class="form-control" id="usuario-telefono" name="usuario-telefono" placeholder="Telefono" value="" maxlength="8" onkeypress="return validarDatosNumericos(event)">
										<div class="invalid-feedback">Por favor completa correctamente este campo</div>
									</div>
								</div>
							</div>
							<div class="col-md-4 mb-3">
								<label for="usuario-login"><strong>Correo Electrónico</strong></label>
								<input type="text" class="form-control" id="usuario-login" name="usuario-login" placeholder="Correo Electrónico" value="">
								<div class="invalid-feedback">Por favor completa este campo</div>
							</div>
						</div>
						<br>
						<div class="form-row">
							<div class="col-md-4 mb-3">
								<label for="usuario-escuela"><strong>Escuela **</strong></label>
								<input type="text" class="form-control" id="usuario-escuela" name="usuario-escuela" placeholder="Escuela" value="" disabled>
							</div>
							<div class="col-md-4 mb-3">
								<label for="usuario-programa"><strong>Programa **</strong></label>
								<input type="text" class="form-control" id="usuario-programa" name="usuario-programa" placeholder="Programa de Inglés" value="" disabled>
							</div>
							<div class="col-md-4 mb-3">
								<label for="usuario-programa-nivel"><strong>Niveles **</strong></label>
								<input type="text" class="form-control" id="usuario-programa-nivel" name="usuario-programa-nivel" placeholder="Nivel de Inglés" value="" disabled>
							</div>
						</div>
						<br>
						<div class="form-group text-center">
							<div class="form-check">
								<input class="form-check-input" type="checkbox" value="" id="usuario-terminos-condiciones" name="usuario-terminos-condiciones">
								<label class="form-check-label" for="usuario-terminos-condiciones" data-toggle="collapse" data-target="#terminos-collapse">
									<p><u>Acepto los términos y condiciones</u></p>
								</label>
							</div>
						</div>
						<div class="collapse" id="terminos-collapse">
							<div class="card">
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
					</form>
				</div>
				<br>
				<p align="center"><strong>*</strong> La matrícula es un código utilizado por tu escuela para identificarte como alumno de la institución (por ejemplo: número de control)</p>
				<p align="center"><strong>**</strong> Tanto tu escuela como tu programa y nivel de inglés son seleccionables en la sección <a class="links-style" href="../tienda/registro.php"><i class="fas fa-shopping-cart"></i> Tienda • Registro</a></p>
			</div>
			<div class="modal-footer">
				<div style="width: 100%;">
					<button type="button" class="btn btn-secondary btn-block" data-dismiss="modal"><i class="fas fa-times"></i> Cerrar</button>
					<button type="button" class="btn btn-primary btn-block" id="usuario-guardar-datos"><i class="fas fa-check"></i> Guardar</button>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- Modal Password Usuario -->
<div class="modal fade" id="usuario-clave-modal" tabindex="-1" role="dialog" aria-labelledby="usuario-clave-modal-label" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header modal-vegdi">
				<h5 class="modal-title"><i class="fas fa-lock"></i> Cambiar mi contraseña</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="card card-body">
					<form id="form-usuario-clave">
						<div class="form-row">
							<div class="col-md-6 mb-6">
								<label for="usuario-clave"><strong>Nueva Contraseña</strong></label>
								<input type="password" class="form-control" id="usuario-clave" name="usuario-clave" placeholder="Contraseña" value="">
								<div class="invalid-feedback">Por favor completa este campo</div>
							</div>
							<div class="col-md-6 mb-6">
								<label for="usuario-clave-confirmar"><strong>Confirmar Nueva Contraseña</strong></label>
								<input type="password" class="form-control" id="usuario-clave-confirmar" name="usuario-clave-confirmar" placeholder="Confirmar Nueva Contraseña" value="">
								<div class="invalid-feedback">Por favor completa este campo</div>
							</div>
						</div>
					</form>
				</div>
			</div>
			<div class="modal-footer">
				<div style="width: 100%;">
					<button type="button" class="btn btn-secondary btn-block" data-dismiss="modal"><i class="fas fa-times"></i> Cancelar</button>
					<button type="button" class="btn btn-primary btn-block" id="usuario-guardar-clave"><i class="fas fa-check"></i> Guardar</button>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="alert blue-alert" role="alert">
	<strong>¡Bienvenido a <i class="fas fa-user"></i> Mi Cuenta!</strong><br><br>
	En está página podrás:<br>
	• Editar y actualizar tus datos<br>
	• Consultar el listado de las compras que has realizado<br>
</div>

<div class="row">
	<div class="col-xs-12 col-md-12 mb-4">
		<div class="card h-100">
			<div class="card-header"><i class="fas fa-user"></i><strong> Mis datos</strong></div>
			<div class="card-body">
				<div class="row">
					<div class="col-xs-3 col-md-3">
						<strong>Nombre</strong>
						<p class="card-text" id="confirmacion-usuario"></p>
					</div>
					<div class="col-xs-3 col-md-3">
						<strong>Matrícula *</strong>
						<p class="card-text" id="confirmacion-usuario-matricula"></p>
					</div>
					<div class="col-xs-3 col-md-3">
						<strong>Teléfono</strong>
						<p class="card-text" id="confirmacion-usuario-telefono"></p>
					</div>
					<div class="col-xs-3 col-md-3">
						<strong>Correo Electrónico</strong>
						<p class="card-text" id="confirmacion-usuario-login"></p>
					</div>
				</div>
				<br>
				<div class="row">
					<div class="col-xs-6 col-md-6">
						<strong>Escuela **</strong>
						<p class="card-text" id="confirmacion-escuela-nombre"></p>
					</div>
					<div class="col-xs-3 col-md-3">
						<strong>Programa **</strong>
						<p class="card-text" id="confirmacion-usuario-programa-nombre"></p>
					</div>
					<div class="col-xs-3 col-md-3">
						<strong>Niveles **</strong>
						<p class="card-text" id="confirmacion-usuario-programa-nivel"></p>
					</div>
				</div>
				<br>
				<hr>
				<div class="row">
					<div class="col-xs-12 col-md-12 text-center">
						<br>
						<strong>*</strong> La matrícula es un código utilizado por tu escuela para identificarte como alumno de la institución (por ejemplo: número de control)
						<br>
						<strong>**</strong> Tanto tu escuela como tu programa y nivel de inglés son seleccionables en la sección <a class="links-style" href="../tienda/registro.php"><i class="fas fa-shopping-cart"></i> Tienda • Registro</a>
						<br>
						<br>
						<br>
						<p>
							<button class="btn btn-primary btn-block" data-toggle="modal" data-target="#usuario-modal"><i class="fas fa-edit"></i> Editar mis datos</button>
							<button class="btn btn-primary btn-block" data-toggle="modal" data-target="#usuario-clave-modal"><i class="fas fa-lock"></i> Cambiar mi contraseña</button>
						</p>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-xs-12 col-md-12 mb-4">
		<div class="card">
			<div class="card-header"><i class="fas fa-dolly-flatbed"></i><strong> Mis compras</strong></div>
			<div class="card-body">
				<div class="panel-body table-responsive">
					<div class="row">
						<div class="col-xl-12 col-md-12">
							<div class="form-group">
								<label> <strong>Listar compras por curso</strong></label>
								<select name="curso-select" id="curso-select" class="form-control"></select>
							</div>
						</div>
					</div>
					<hr>
					<table id="tabla-pedidos" class="table table-striped table-bordered nowrap" style="width:100%">
					</table>
				</div>

			</div>
		</div>
	</div>
</div>

<?php

    require_once '../sistema/footer.php';

?>

<!-- Página -->
<script type="text/javascript" src="scripts/cuenta.js?token=<?php echo $token; ?>"></script>

<?php

    ob_end_flush();

?>