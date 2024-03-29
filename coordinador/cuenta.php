<?php

    session_start();
    ob_start();
    $token = uniqid();
    require_once '../sistema/header.php';

?>

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
								<label for="usuario-matricula"><strong>DNI</strong></label>
								<input type="text" class="form-control" id="usuario-matricula" name="usuario-matricula" placeholder="DNI" value="">
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
										<input type="text" class="form-control" id="usuario-telefono" name="usuario-telefono" placeholder="Telefono" value="" maxlength="8" onkeypress="return validarDatosNumericos(event)">
										<div class="invalid-feedback">Por favor completa correctamente este campoo</div>
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

<div class="row">
	<div class="col-xs-12 col-md-12 mb-4">
		<div class="card shadow h-100">
			<div class="card-header"><i class="fas fa-user"></i><strong> Mis datos</strong></div>
			<div class="card-body">
				<div class="row mb-4">
					<div class="col-xs-3 col-md-3">
						<strong>Nombre</strong>
						<p class="card-text" id="confirmacion-usuario"></p>
					</div>
					<div class="col-xs-2 col-md-2">
						<strong>DNI</strong>
						<p class="card-text" id="confirmacion-usuario-matricula"></p>
					</div>
					<div class="col-xs-2 col-md-2">
						<strong>Teléfono</strong>
						<p class="card-text" id="confirmacion-usuario-telefono"></p>
					</div>
					<div class="col-xs-2 col-md-2">
						<strong>Rol</strong>
						<p class="card-text" id="confirmacion-usuario-rol"></p>
					</div>
					<div class="col-xs-3 col-md-3">
						<strong>Correo Electrónico</strong>
						<p class="card-text" id="confirmacion-usuario-login"></p>
					</div>
				</div>
				<br>
				<div class="row">
				    <div class="col-xs-3 col-md-3 mb-3"></div>
				    <div class="col-xs-3 col-md-3 mb-3">
				        <button class="btn btn-primary" style="width:100%;" data-toggle="modal" data-target="#usuario-modal"><i class="fas fa-edit"></i> Editar mis datos</button>
				    </div>
				    <div class="col-xs-3 col-md-3 mb-3">
                    <button class="btn btn-primary" style="width:100%;" data-toggle="modal" data-target="#usuario-clave-modal"><i class="fas fa-lock"></i> Cambiar mi contraseña</button>
                    </div>
				    <div class="col-xs-3 col-md-3 mb-3"></div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-xs-12 col-md-12 mb-4">
		<div class="card shadow">
			<div class="card-header"><i class="fas fa-dolly-flatbed"></i><strong> Mis pedidos</strong></div>
			<div class="card-body">
				<div class="panel-body table-responsive">
					<div class="row">
						<div class="col-xl-12 col-md-12">
							<div class="form-group">
								<div class="row">
            						<div class="col-xl-12 col-md-12 mb-4">
        								<label> <strong>Escuela</strong></label>
        							    <select name="escuela-select" id="escuela-pedido-select" class="form-control selectpicker" data-show-subtext="true" data-live-search="true"></select>
        							    <br>
        							    <br>
        							    <br>
        							    <br>
        							    <br>
        							    <br>
        							    <br>
        							    <br>
        							    <br>
        							    <br>
        							    <br>
        							    <br>
        							    <br>
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
	<div class="col-xs-12 col-md-12 mb-4">
		<div class="card shadow">
			<div class="card-header"><i class="fas fa-dolly-flatbed"></i><strong> Mis consignaciones y entregas</strong></div>
			<div class="card-body">
				<div class="panel-body table-responsive">
					<div class="row">
						<div class="col-xl-12 col-md-12">
							<div class="form-group">
								<div class="row">
            						<div class="col-xl-12 col-md-12 mb-4">
        								<label> <strong>Escuela</strong></label>
        							    <select name="escuela-select" id="escuela-select" class="form-control selectpicker" data-show-subtext="true" data-live-search="true"></select>
							        </div>
							    </div>
							    <div class="row">
                                    <div class="col-xl-12 col-md-12 mb-4">
        								<label> <strong>Estatus general de la escuela</strong></label>
        								<br>
        								<br>
        								<br>
                                        <div class="row justify-content-md-center">
                                            <div class="col-md-3 col-xs-3 col-lg-2 mb-4">
                                                <div class="card shadow h-100 py-2" style="border-left:5px solid #536b97;">
                                                    <div class="card-body">
                                                        <div class="row no-gutters align-items-center">
                                                            <div class="col mr-2">
                                                                <div class="text-xs text-primary text-uppercase mb-1 titulo-indicadores"><strong>Balance Anterior</strong></div>
                                                                <div class="h5 mb-0 font-weight-bold text-gray-800" style="font-size: 2em;" id="balance-anterior">0</div>
                                                            </div>
                                                            <div class="col-auto">
                                                                <i class="far fa-square fa-3x text-gray-300"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class=" col-md-3 col-xs-3 col-lg-2 mb-4">
                                                <div class="card shadow h-100 py-2" style="border-left:5px solid #536b97;">
                                                    <div class="card-body">
                                                        <div class="row no-gutters align-items-center">
                                                            <div class="col mr-2">
                                                                <div class="text-xs text-primary text-uppercase mb-1 titulo-indicadores"><strong>Pedido</strong></div>
                                                                <div class="h5 mb-0 font-weight-bold text-gray-800" style="font-size: 2em;" id="entregas-solicitados">0</div>
                                                            </div>
                                                            <div class="col-auto">
                                                                <i class="fas fa-truck-loading fa-3x text-gray-300"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--<div class=" col-md-2 col-xs-12 col-lg-2 mb-4">
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
                                            </div>-->
                                            <div class="col-md-3 col-xs-3 col-lg-2 mb-4">
                                                <div class="card shadow h-100 py-2" style="border-left:5px solid #536b97;">
                                                    <div class="card-body">
                                                        <div class="row no-gutters align-items-center">
                                                            <div class="col mr-2">
                                                                <div class="text-xs  text-primary text-uppercase mb-1 titulo-indicadores"><strong>Enviado</strong></div>
                                                                <div class="h5 mb-0 font-weight-bold text-gray-800" style="font-size: 2em;" id="entregas-enviadas">0</div>
                                                            </div>
                                                            <div class="col-auto">
                                                                <i class="fas fa-wallet fa-3x text-gray-300"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3 col-xs-3 col-lg-2 mb-4">
                                                <div class="card shadow h-100 py-2" style="border-left:5px solid #536b97;">
                                                    <div class="card-body">
                                                        <div class="row no-gutters align-items-center">
                                                            <div class="col mr-2">
                                                                <div class="text-xs text-primary text-uppercase mb-1 titulo-indicadores"><strong>Nuevo Balance</strong></div>
                                                                <div class="h5 mb-0 font-weight-bold text-gray-800" style="font-size: 2em;" id="nuevo-balance">0</div>
                                                            </div>
                                                            <div class="col-auto">
                                                                <i class="fas fa-box fa-3x text-gray-300"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--<div class="col-md-2 col-xs-12 col-lg-2 mb-4">
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
                                            </div>-->
                                        </div>
                                        <div class="row justify-content-md-center">
                                            <div class="col-md-2 col-xs-12 col-lg-2 mb-4">
                                                <div class="card shadow h-100 py-2" style="border-left:5px solid #536b97;">
                                                    <div class="card-body">
                                                        <div class="row no-gutters align-items-center">
                                                            <div class="col mr-2">
                                                                <div class="text-xs  text-primary text-uppercase mb-1 titulo-indicadores"><strong>Venta</strong></div>
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
                                                                <div class="text-xs text-primary text-uppercase mb-1 titulo-indicadores"><strong>Entregas</strong></div>
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
                                                                <div class="text-xs text-primary text-uppercase mb-1 titulo-indicadores"><strong>Por entregar</strong></div>
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
                                                                <div class="text-xs text-primary text-uppercase mb-1 titulo-indicadores"><strong>Balance Actual</strong></div>
                                                                <div class="h5 mb-0 font-weight-bold text-gray-800" style="font-size: 2em;" id="balance-actual">0</div>
                                                            </div>
                                                            <div class="col-auto">
                                                                <i class="fas fa-box-open fa-3x text-gray-300"></i>
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
        								<label> <strong>Curso</strong></label>
        								<select name="curso-select" id="curso-select" class="form-control selectpicker" data-show-subtext="true" data-live-search="true"></select>
        						    </div>
							    </div>
							    <div class="row">
            						<div class="col-xl-4 col-md-4 mb-4"></div>
            						<div class="col-xl-4 col-md-4 mb-4 text-center">
							            <button type="button" class="btn btn-primary" id="recargar-escuela-curso"><i class="fas fa-sync-alt"></i> Actualizar</button>
							        </div>
            						<div class="col-xl-4 col-md-4 mb-4"></div>
						        </div>
							</div>
						</div>
					</div>
					<hr>
					<div class="row">
					    <div class="col-xs-12 col-md-12 mb-3">
					        <i class="fas fa-info-circle"></i> <strong>NOTA</strong><br><br>Si tu pantalla es de 15 pulgadas o menos, has click en el símbolo <strong>+</strong>, el cual lo encontraras en la columna de Libros Solicitados para visualizar toda la información disponible<br><br>
					    </div>
					</div>
					<div class="row" id="contenedor-tablas">
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
<script type="text/javascript" src="scripts/cuenta.js?token=<?php echo $token; ?>"></script>

<?php

    ob_end_flush();

?>