<?php

    session_start();
    ob_start();
    $token = uniqid();
    require_once '../sistema/header.php';

?>

<!-- Date Picker CSS -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/css/bootstrap-datepicker.min.css" rel="stylesheet" />

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
								<label for="usuario-matricula"><strong>Matrícula</strong></label>
								<input type="text" class="form-control" id="usuario-matricula" name="usuario-matricula" placeholder="Matrícula" value="">
								<div class="invalid-feedback">Por favor completa este campo</div>
							</div>
							<div class="col-md-4 mb-3">
                                <div class="row">
                                    <div class="col-md-4 mb-3" style="padding-right:2px;">
                                        <label for="usuario-lada"><strong>Lada</strong></label>
                                        <input type="text" class="form-control" id="usuario-lada" name="usuario-lada" placeholder="Lada" value="" maxlength="3" onkeypress="return validarDatosNumericos(event)">
                                        <div class="invalid-feedback">Por favor completa correctamente este campo</div>
                                    </div>
                                    <div class="col-md-8 mb-3" style="padding-left:2px;">
                                        <label for="usuario-telefono"><strong>Teléfono</strong></label>
                                        <input type="text" class="form-control" id="usuario-telefono" name="usuario-telefono" placeholder="Telefono" value="" maxlength="8" onkeypress="return validarDatosNumericos(event)">
                                        <div class="invalid-feedback">Por favor completa correctamente este campo</div>
                                    </div>
                                </div>
                            </div>
							<div class="col-md-4 mb-3">
								<label for="usuario-login"><strong>Correo Electrónico</strong></label>
								<input type="text" class="form-control" id="usuario-login" name="usuario-login" placeholder="Correo Electrónico" value="" disabled>
								<div class="invalid-feedback">Por favor completa este campo</div>
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

<!-- Modal Datos Distribución -->
<div class="modal fade" id="distribuidor-modal" tabindex="-1" role="dialog" aria-labelledby="distribuidor-modal-label" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-lg" style="max-width: 90% !important; width: 90% !important;" role="document">
		<div class="modal-content">
			<div class="modal-header modal-vegdi">
				<h5 class="modal-title"><i class="fas fa-warehouse"></i> Mis datos de distribución</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="card card-body">
					<form id="form-distribuidor">
						<div class="form-row">
							<input type="hidden" id="distribuidor-id" name="distribuidor-id" value="">
						</div>
						<div class="form-row">
							<div class="col-md-4 mb-3">
								<label for="distribuidor-nombre"><strong>Nombre(s)</strong></label>
								<input type="text" class="form-control" id="distribuidor-nombre" name="distribuidor-nombre" placeholder="Nombre" value="">
								<div class="invalid-feedback">Por favor completa este campo</div>
							</div>
							<div class="col-md-4 mb-3">
								<label for="distribuidor-alias"><strong>Alias</strong></label>
								<input type="text" class="form-control" id="distribuidor-alias" name="distribuidor-alias" placeholder="Alias" value="">
								<div class="invalid-feedback">Por favor completa este campo</div>
							</div>
							<div class="col-md-4 mb-3">
								<label for="distribuidor-dominio"><strong>Organización</strong></label>
								<input type="text" class="form-control" id="distribuidor-dominio" name="distribuidor-dominio" placeholder="Organización" value="" disabled>
								<div class="invalid-feedback">Por favor completa este campo</div>
							</div>
						</div>
						<br>
						<div class="form-row">
							<div class="col-md-4 mb-3">
                                <div class="row">
                                    <div class="col-md-4 mb-3" style="padding-right:2px;">
                                        <label for="distribuidor-lada"><strong>Lada</strong></label>
                                        <input type="text" class="form-control" id="distribuidor-lada" name="distribuidor-lada" placeholder="Lada" value="" maxlength="3" onkeypress="return validarDatosNumericos(event)">
                                        <div class="invalid-feedback">Por favor completa este campo</div>
                                    </div>
                                    <div class="col-md-8 mb-3" style="padding-left:2px;">
                                        <label for="distribuidor-telefono"><strong>Teléfono</strong></label>
                                        <input type="text" class="form-control" id="distribuidor-telefono" name="distribuidor-telefono" placeholder="Telefono" value="" maxlength="7" onkeypress="return validarDatosNumericos(event)">
                                        <div class="invalid-feedback">Por favor completa este campo</div>
                                    </div>
                                </div>
                            </div>
							<div class="col-md-4 mb-3">
								<label for="distribuidor-correo"><strong>Correo Electrónico</strong></label>
								<input type="text" class="form-control" id="distribuidor-correo" name="distribuidor-correo" placeholder="Correo Electrónico" value="" disabled>
								<div class="invalid-feedback">Por favor completa este campo</div>
							</div>
							<div class="col-md-4 mb-3">
								<label for="distribuidor-estado"><strong>Estado</strong></label>
								<input type="text" class="form-control" id="distribuidor-estado" name="distribuidor-estado" placeholder="Estado" value="">
								<div class="invalid-feedback">Por favor completa este campo</div>
							</div>
						</div>
						<br>
						<div class="form-row">
							<div class="col-md-4 mb-3">
								<label for="distribuidor-ciudad"><strong>Ciudad</strong></label>
								<input type="text" class="form-control" id="distribuidor-ciudad" name="distribuidor-ciudad" placeholder="Ciudad" value="">
								<div class="invalid-feedback">Por favor completa este campo</div>
							</div>
							<div class="col-md-4 mb-3">
								<label for="distribuidor-colonia"><strong>Colonia</strong></label>
								<input type="text" class="form-control" id="distribuidor-colonia" name="distribuidor-colonia" placeholder="Colonia" value="">
								<div class="invalid-feedback">Por favor completa este campo</div>
							</div>
							<div class="col-md-4 mb-3">
								<label for="distribuidor-codigo-postal"><strong>Código Postal</strong></label>
								<input type="text" class="form-control" id="distribuidor-codigo-postal" name="distribuidor-codigo-postal" placeholder="Código Postal" value="" onkeypress="return validarDatosNumericos(event)">
								<div class="invalid-feedback">Por favor completa este campo</div>
							</div>
						</div>
						<br>
						<div class="form-row">
    						<div class="col-md-4 mb-3">
    							<label for="distribuidor-calle"><strong>Calle</strong></label>
    							<input type="text" class="form-control" id="distribuidor-calle" name="distribuidor-calle" placeholder="Calle" value="">
    							<div class="invalid-feedback">Por favor completa este campo</div>
    						</div>
    						<div class="col-md-4 mb-3">
    							<label for="distribuidor-numero-exterior"><strong>Número Exterior</strong></label>
    							<input type="text" class="form-control" id="distribuidor-numero-exterior" name="distribuidor-numero-exterior" placeholder="Número Exterior" value="">
    							<div class="invalid-feedback">Por favor completa este campo</div>
    						</div>
    						<div class="col-md-4 mb-3">
    							<label for="distribuidor-numero-interior"><strong>Número Interior</strong></label>
    							<input type="text" class="form-control" id="distribuidor-numero-interior" name="distribuidor-numero-interior" placeholder="Número Interior" value="">
    							<div class="invalid-feedback">Por favor completa este campo</div>
    						</div>
						</div>
					</form>
				</div>
			</div>
			<div class="modal-footer">
			    <div style="width: 100%;">
    				<button type="button" class="btn btn-secondary btn-block" data-dismiss="modal"><i class="fas fa-times"></i> Cerrar</button>
    				<button type="button" class="btn btn-primary btn-block" id="distribuidor-guardar-datos"><i class="fas fa-check"></i> Guardar</button>
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

<!--
<br>
<br>
<div class="text-center" id="pagina-mensaje"><br>
	<h2><i class="fas fa-user"></i> ¡Bienvenido! Como coordinador podrás gestionar todo lo relacionado con la distribución de materiales para los alumnos de tu institución en la zona/subzona/escuela que te ha sido asignada.</h2>
</div>
-->



<div class="alert alert-warning alert-dismissible fade show" role="alert">
	<strong><i class="fas fa-school"></i> Fecha límite de asignación de distribuidor</strong>
	<br>
	Viernes 21 de Junio del 2019.
	<button type="button" class="close" data-dismiss="alert" aria-label="Close">
		<span aria-hidden="true">&times;</span>
	</button>
</div>

<div class="row">
	<div class="col-xs-12 col-md-12 mb-4">
		<div class="card shadow h-100">
			<div class="card-header"><i class="fas fa-user"></i><strong> Mis datos personales</strong></div>
			<div class="card-body">
				<div class="row">
					<div class="col-xs-3 col-md-3">
						<strong>Nombre</strong>
						<p class="card-text" id="confirmacion-usuario"></p>
					</div>
					<div class="col-xs-3 col-md-3">
						<strong>Matrícula</strong>
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
                <p>
				    <button class="btn btn-primary btn-block" data-toggle="modal" data-target="#usuario-modal"><i class="fas fa-edit"></i> Editar mis datos</button>
					<button class="btn btn-primary btn-block" data-toggle="modal" data-target="#usuario-clave-modal"><i class="fas fa-lock"></i> Cambiar mi contraseña</button>
				</p>
			</div>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-xs-12 col-md-12 mb-4">
		<div class="card shadow h-100">
			<div class="card-header"><i class="fas fa-warehouse"></i><strong> Mis datos de distribución</strong></div>
			<div class="card-body">
				<div class="row">
					<div class="col-xs-3 col-md-3">
						<strong>Nombre</strong>
						<p class="card-text" id="confirmacion-distribuidor-nombre"></p>
					</div>
					<div class="col-xs-3 col-md-3">
						<strong>Alias</strong>
						<p class="card-text" id="confirmacion-distribuidor-alias"></p>
					</div>
					<div class="col-xs-3 col-md-3">
						<strong>Teléfono de contacto</strong>
						<p class="card-text" id="confirmacion-distribuidor-telefono"></p>
					</div>
					<div class="col-xs-3 col-md-3">
						<strong>Correo Electrónico de Contacto</strong>
						<p class="card-text" id="confirmacion-distribuidor-correo"></p>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-3 col-md-3">
						<strong>Organización</strong>
						<p class="card-text" id="confirmacion-distribuidor-dominio"></p>
					</div>
					<div class="col-xs-3 col-md-3">
						<strong>Estado</strong>
						<p class="card-text" id="confirmacion-distribuidor-estado"></p>
					</div>
					<div class="col-xs-3 col-md-3">
						<strong>Ciudad</strong>
						<p class="card-text" id="confirmacion-distribuidor-ciudad"></p>
					</div>
					<div class="col-xs-3 col-md-3">
						<strong>Colonia</strong>
						<p class="card-text" id="confirmacion-distribuidor-colonia"></p>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-3 col-md-3">
						<strong>Calle</strong>
						<p class="card-text" id="confirmacion-distribuidor-calle"></p>
					</div>
					<div class="col-xs-3 col-md-3">
						<strong>Número Exterior</strong>
						<p class="card-text" id="confirmacion-distribuidor-numero-exterior"></p>
					</div>
					<div class="col-xs-3 col-md-3">
						<strong>Número Interior</strong>
						<p class="card-text" id="confirmacion-distribuidor-numero-interior"></p>
					</div>
					<div class="col-xs-3 col-md-3">
						<strong>Código Postal</strong>
						<p class="card-text" id="confirmacion-distribuidor-codigo-postal"></p>
					</div>
				</div>
				<br>
                <p>
				    <button class="btn btn-primary btn-block" data-toggle="modal" data-target="#distribuidor-modal"><i class="fas fa-edit"></i> Editar mis datos de distribución</button>
				</p>
			</div>
		</div>
	</div>
</div>

<?php

	require_once '../sistema/footer.php';

?>

<!-- Date Picker -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/js/bootstrap-datepicker.min.js"></script>

<!-- Data Tables -->
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.3/js/responsive.bootstrap4.min.js"></script>
<script src="https://cdn.datatables.net/select/1.3.0/js/dataTables.select.min.js"></script>

<!-- Página -->
<script type="text/javascript" src="scripts/cuenta.js?token=<?php echo $token; ?>"></script>

<?php

    ob_end_flush();

?>